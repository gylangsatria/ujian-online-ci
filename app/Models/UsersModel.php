<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'ip_address', 'username', 'password', 'email',
        'activation_selector', 'activation_code',
        'forgotten_password_selector', 'forgotten_password_code', 'forgotten_password_time',
        'remember_selector', 'remember_code',
        'created_on', 'last_login', 'active',
        'first_name', 'last_name', 'company', 'phone',
    ];

    // Dates
    protected $useTimestamps = false;

    /**
     * Find user by username or email.
     */
    public function findByIdentity(string $identity): ?object
    {
        return $this->where('username', $identity)
            ->orWhere('email', $identity)
            ->first();
    }

    /**
     * Get user group from users_groups join.
     */
    public function getUserGroup(int $userId): ?object
    {
        return $this->db->table('users_groups')
            ->select('users_groups.group_id, groups.name')
            ->join('groups', 'groups.id = users_groups.group_id')
            ->where('users_groups.user_id', $userId)
            ->get()
            ->getRow();
    }
}