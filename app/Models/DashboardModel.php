<?php

namespace App\Models;

use CodeIgniter\Model;

class DashboardModel extends Model
{
    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = db_connect();
    }

    // ─── Admin stats ───

    public function countJurusan(): int
    {
        return $this->db->table('jurusan')->countAll();
    }

    public function countMatkul(): int
    {
        return $this->db->table('matkul')->countAll();
    }

    public function countDosen(): int
    {
        return $this->db->table('dosen')->countAll();
    }

    public function countMahasiswa(): int
    {
        return $this->db->table('mahasiswa')->countAll();
    }

    public function countKelas(): int
    {
        return $this->db->table('kelas')->countAll();
    }

    public function countUjian(): int
    {
        return $this->db->table('m_ujian')->countAll();
    }

    public function countSoal(): int
    {
        return $this->db->table('tb_soal')->countAll();
    }

    // ─── Dosen stats ───

    public function countMatkulByDosen(int $dosenId): int
    {
        return $this->db->table('dosen')
            ->where('id_dosen', $dosenId)
            ->countAllResults();
    }

    public function countSoalByDosen(int $dosenId): int
    {
        return $this->db->table('tb_soal')
            ->where('dosen_id', $dosenId)
            ->countAllResults();
    }

    public function countUjianByDosen(int $dosenId): int
    {
        return $this->db->table('m_ujian')
            ->where('dosen_id', $dosenId)
            ->countAllResults();
    }

    public function countKelasByDosen(int $dosenId): int
    {
        return $this->db->table('kelas_dosen')
            ->where('dosen_id', $dosenId)
            ->countAllResults();
    }

    // ─── Mahasiswa stats ───

    public function countUjianTersedia(): int
    {
        return $this->db->table('m_ujian')
            ->where('tgl_mulai <=', date('Y-m-d H:i:s'))
            ->where('terlambat >=', date('Y-m-d H:i:s'))
            ->countAllResults();
    }

    public function countUjianDiikuti(int $mahasiswaId): int
    {
        return $this->db->table('h_ujian')
            ->where('mahasiswa_id', $mahasiswaId)
            ->countAllResults();
    }

    public function getNilaiTerakhir(int $mahasiswaId): ?object
    {
        return $this->db->table('h_ujian')
            ->select('h_ujian.nilai, h_ujian.tgl_selesai, m_ujian.nama_ujian')
            ->join('m_ujian', 'm_ujian.id_ujian = h_ujian.ujian_id')
            ->where('h_ujian.mahasiswa_id', $mahasiswaId)
            ->orderBy('h_ujian.tgl_selesai', 'DESC')
            ->limit(1)
            ->get()
            ->getRow();
    }

    // ─── Recent activity (admin) ───

    public function getLastLoginUsers(int $limit = 5): array
    {
        return $this->db->table('users')
            ->select('id, first_name, last_name, last_login')
            ->where('last_login >', 0)
            ->orderBy('last_login', 'DESC')
            ->limit($limit)
            ->get()
            ->getResult();
    }

    public function getUjianAktif(int $limit = 5): array
    {
        return $this->db->table('m_ujian')
            ->select('m_ujian.*, matkul.nama_matkul, dosen.nama_dosen')
            ->join('matkul', 'matkul.id_matkul = m_ujian.matkul_id')
            ->join('dosen', 'dosen.id_dosen = m_ujian.dosen_id')
            ->where('m_ujian.tgl_mulai <=', date('Y-m-d H:i:s'))
            ->where('m_ujian.terlambat >=', date('Y-m-d H:i:s'))
            ->orderBy('m_ujian.tgl_mulai', 'DESC')
            ->limit($limit)
            ->get()
            ->getResult();
    }
}