<?php

namespace App\Libraries;

use App\Models\UsersModel;

class Auth
{
    protected $session;
    protected $usersModel;

    public function __construct()
    {
        $this->session = service('session');
        $this->usersModel = model('App\Models\UsersModel');
    }

    /**
     * Attempt login with username or email.
     * Returns true on success, false on failure.
     */
    public function login(string $identity, string $password): bool
    {
        $user = $this->usersModel->findByIdentity($identity);
        if (!$user) {
            return false;
        }

        if (!password_verify($password, $user->password)) {
            return false;
        }

        if (!$user->active) {
            return false;
        }

        // Get user group
        $group = $this->usersModel->getUserGroup($user->id);

        $sessionData = [
            'user_id'       => $user->id,
            'username'      => $user->username,
            'email'         => $user->email,
            'first_name'    => $user->first_name,
            'last_name'     => $user->last_name,
            'group_id'      => $group->group_id ?? 0,
            'group_name'    => $group->name ?? '',
            'is_logged_in'  => true,
        ];

        // Store role-specific ID
        $db = db_connect();
        if ($group->name === 'dosen') {
            $dosen = $db->table('dosen')
                ->where('nip', $user->username)
                ->orWhere('email', $user->email)
                ->get()
                ->getRow();
            if ($dosen) {
                $sessionData['dosen_id'] = $dosen->id_dosen;
            }
        } elseif ($group->name === 'mahasiswa') {
            $mhs = $db->table('mahasiswa')
                ->where('nim', $user->username)
                ->orWhere('email', $user->email)
                ->get()
                ->getRow();
            if ($mhs) {
                $sessionData['mahasiswa_id'] = $mhs->id_mahasiswa;
            }
        }

        $this->session->set($sessionData);

        // Update last_login
        $this->usersModel->update($user->id, ['last_login' => time()]);

        return true;
    }

    public function logout(): void
    {
        $this->session->destroy();
    }

    public function isLoggedIn(): bool
    {
        return $this->session->get('is_logged_in') === true;
    }

    public function getUserId(): ?int
    {
        return $this->session->get('user_id');
    }

    public function getGroupName(): string
    {
        return $this->session->get('group_name') ?? '';
    }

    public function getGroupId(): int
    {
        return (int) $this->session->get('group_id');
    }

    public function isAdmin(): bool
    {
        return $this->getGroupName() === 'admin';
    }

    public function isDosen(): bool
    {
        return $this->getGroupName() === 'dosen';
    }

    public function isMahasiswa(): bool
    {
        return $this->getGroupName() === 'mahasiswa';
    }

    /**
     * Check if current user has one of allowed groups.
     */
    public function hasGroup(array $groups): bool
    {
        return in_array($this->getGroupName(), $groups, true);
    }
}