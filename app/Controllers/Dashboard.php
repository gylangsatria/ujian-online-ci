<?php

namespace App\Controllers;

use App\Models\DashboardModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['group_name'] = $this->auth->getGroupName();
        $data['user_name'] = $this->auth->getUserId()
            ? session()->get('first_name') . ' ' . session()->get('last_name')
            : '';

        $dashboardModel = model('App\Models\DashboardModel');
        $role = $data['group_name'];

        if ($role === 'admin') {
            $data['count_jurusan']   = $dashboardModel->countJurusan();
            $data['count_matkul']    = $dashboardModel->countMatkul();
            $data['count_dosen']     = $dashboardModel->countDosen();
            $data['count_mahasiswa'] = $dashboardModel->countMahasiswa();
            $data['count_kelas']     = $dashboardModel->countKelas();
            $data['count_ujian']     = $dashboardModel->countUjian();
            $data['count_soal']      = $dashboardModel->countSoal();
            $data['last_login_users'] = $dashboardModel->getLastLoginUsers();
            $data['ujian_aktif']     = $dashboardModel->getUjianAktif();
        } elseif ($role === 'dosen') {
            $dosenId = session()->get('dosen_id');
            if (!$dosenId) {
                // Look up dosen by user_id or username
                $dosenId = $this->findDosenId();
            }
            $data['count_matkul'] = $dashboardModel->countMatkulByDosen($dosenId ?: 0);
            $data['count_soal']   = $dashboardModel->countSoalByDosen($dosenId ?: 0);
            $data['count_ujian']  = $dashboardModel->countUjianByDosen($dosenId ?: 0);
            $data['count_kelas']  = $dashboardModel->countKelasByDosen($dosenId ?: 0);
        } elseif ($role === 'mahasiswa') {
            $mahasiswaId = session()->get('mahasiswa_id');
            if (!$mahasiswaId) {
                $mahasiswaId = $this->findMahasiswaId();
            }
            $data['count_tersedia']  = $dashboardModel->countUjianTersedia();
            $data['count_diikuti']   = $dashboardModel->countUjianDiikuti($mahasiswaId ?: 0);
            $data['nilai_terakhir']  = $dashboardModel->getNilaiTerakhir($mahasiswaId ?: 0);
            $data['mahasiswa_id']    = $mahasiswaId;
        }

        return view('dashboard', $data);
    }

    private function findDosenId(): ?int
    {
        $username = session()->get('username');
        if (!$username) return null;

        $db = db_connect();
        $dosen = $db->table('dosen')
            ->where('nip', $username)
            ->orWhere('email', session()->get('email'))
            ->get()
            ->getRow();

        if ($dosen) {
            session()->set('dosen_id', $dosen->id_dosen);
            return (int) $dosen->id_dosen;
        }
        return null;
    }

    private function findMahasiswaId(): ?int
    {
        $username = session()->get('username');
        if (!$username) return null;

        $db = db_connect();
        $mhs = $db->table('mahasiswa')
            ->where('nim', $username)
            ->orWhere('email', session()->get('email'))
            ->get()
            ->getRow();

        if ($mhs) {
            session()->set('mahasiswa_id', $mhs->id_mahasiswa);
            return (int) $mhs->id_mahasiswa;
        }
        return null;
    }
}