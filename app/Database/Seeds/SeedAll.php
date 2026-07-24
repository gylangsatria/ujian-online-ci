<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SeedAll extends Seeder
{
    public function run()
    {
        // Disable foreign key checks
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');

        // ---- groups ----
        $this->db->table('groups')->truncate();
        $this->db->table('groups')->insertBatch([
            ['id' => 1, 'name' => 'admin',     'description' => 'Administrator'],
            ['id' => 2, 'name' => 'dosen',     'description' => 'Pembuat Soal dan ujian'],
            ['id' => 3, 'name' => 'mahasiswa', 'description' => 'Peserta Ujian'],
        ]);

        // ---- jurusan ----
        $this->db->table('jurusan')->truncate();
        $this->db->table('jurusan')->insertBatch([
            ['id_jurusan' => 1, 'nama_jurusan' => 'Sistem Informasi'],
            ['id_jurusan' => 2, 'nama_jurusan' => 'Teknik Informatika'],
        ]);

        // ---- matkul ----
        $this->db->table('matkul')->truncate();
        $this->db->table('matkul')->insertBatch([
            ['id_matkul' => 1, 'nama_matkul' => 'Bahasa Inggris'],
            ['id_matkul' => 2, 'nama_matkul' => 'Dasar Pemrograman'],
            ['id_matkul' => 3, 'nama_matkul' => 'Enterpreneurship'],
            ['id_matkul' => 5, 'nama_matkul' => 'Matematika Advanced'],
        ]);

        // ---- dosen ----
        $this->db->table('dosen')->truncate();
        $this->db->table('dosen')->insertBatch([
            ['id_dosen' => 1, 'nip' => '12345678', 'nama_dosen' => 'Koro Sensei',   'email' => 'korosensei@gmail.com',  'matkul_id' => 1],
            ['id_dosen' => 3, 'nip' => '01234567', 'nama_dosen' => 'Tobirama Sensei','email' => 'tobirama@gmail.com',   'matkul_id' => 5],
        ]);

        // ---- jurusan_matkul ----
        $this->db->table('jurusan_matkul')->truncate();
        $this->db->table('jurusan_matkul')->insertBatch([
            ['id' => 1, 'matkul_id' => 1, 'jurusan_id' => 1],
            ['id' => 2, 'matkul_id' => 1, 'jurusan_id' => 2],
            ['id' => 3, 'matkul_id' => 2, 'jurusan_id' => 2],
            ['id' => 6, 'matkul_id' => 5, 'jurusan_id' => 2],
        ]);

        // ---- kelas ----
        $this->db->table('kelas')->truncate();
        $this->db->table('kelas')->insertBatch([
            ['id_kelas' => 1, 'nama_kelas' => '12.1E.13', 'jurusan_id' => 1],
            ['id_kelas' => 2, 'nama_kelas' => '11.1A.13', 'jurusan_id' => 1],
            ['id_kelas' => 3, 'nama_kelas' => '10.1D.13', 'jurusan_id' => 1],
            ['id_kelas' => 7, 'nama_kelas' => '12.1A.10', 'jurusan_id' => 2],
            ['id_kelas' => 8, 'nama_kelas' => '12.1B.10', 'jurusan_id' => 2],
        ]);

        // ---- kelas_dosen ----
        $this->db->table('kelas_dosen')->truncate();
        $this->db->table('kelas_dosen')->insertBatch([
            ['id' => 1,  'kelas_id' => 3, 'dosen_id' => 1],
            ['id' => 2,  'kelas_id' => 2, 'dosen_id' => 1],
            ['id' => 3,  'kelas_id' => 1, 'dosen_id' => 1],
            ['id' => 9,  'kelas_id' => 2, 'dosen_id' => 3],
            ['id' => 10, 'kelas_id' => 1, 'dosen_id' => 3],
        ]);

        // ---- mahasiswa ----
        $this->db->table('mahasiswa')->truncate();
        $this->db->table('mahasiswa')->insert([
            'id_mahasiswa' => 1,
            'nama'         => 'Muhammad Ghifari Arfananda',
            'nim'          => '12183018',
            'email'        => 'mghifariarfan@gmail.com',
            'jenis_kelamin'=> 'L',
            'kelas_id'     => 1,
        ]);

        // ---- m_ujian ----
        $this->db->table('m_ujian')->truncate();
        $this->db->table('m_ujian')->insertBatch([
            ['id_ujian' => 1, 'dosen_id' => 1, 'matkul_id' => 1, 'nama_ujian' => 'First Test',  'jumlah_soal' => 3, 'waktu' => 1, 'jenis' => 'acak', 'tgl_mulai' => '2019-02-15 17:25:40', 'terlambat' => '2019-02-20 17:25:44', 'token' => 'DPEHL'],
            ['id_ujian' => 2, 'dosen_id' => 1, 'matkul_id' => 1, 'nama_ujian' => 'Second Test', 'jumlah_soal' => 3, 'waktu' => 1, 'jenis' => 'acak', 'tgl_mulai' => '2019-02-16 10:05:08', 'terlambat' => '2019-02-17 10:05:10', 'token' => 'GOEMB'],
            ['id_ujian' => 3, 'dosen_id' => 3, 'matkul_id' => 5, 'nama_ujian' => 'Try Out 01',  'jumlah_soal' => 2, 'waktu' => 1, 'jenis' => 'acak', 'tgl_mulai' => '2019-02-16 07:00:00', 'terlambat' => '2019-02-28 14:00:00', 'token' => 'IFSDH'],
        ]);

        // ---- tb_soal ----
        $this->db->table('tb_soal')->truncate();
        $this->db->table('tb_soal')->insertBatch([
            ['id_soal' => 1, 'dosen_id' => 1, 'matkul_id' => 1, 'bobot' => 1, 'file' => '', 'tipe_file' => '', 'soal' => '<p>Dian : The cake is scrumptious! I love i<br>Joni : … another piece?<br>Dian : Thank you. You should tell me the recipe.<br>Joni : I will.</p><p>Which of the following offering expressions best fill the blank?</p>', 'opsi_a' => '<p>Do you mind if you have</p>', 'opsi_b' => '<p>Would you like</p>', 'opsi_c' => '<p>Shall you hav</p>', 'opsi_d' => '<p>Can I have you</p>', 'opsi_e' => '<p>I will bring you</p>', 'file_a' => '', 'file_b' => '', 'file_c' => '', 'file_d' => '', 'file_e' => '', 'jawaban' => 'B', 'created_on' => 1550225760, 'updated_on' => 1550225760],
            ['id_soal' => 2, 'dosen_id' => 1, 'matkul_id' => 1, 'bobot' => 1, 'file' => '', 'tipe_file' => '', 'soal' => '<p>Fitri : The French homework is really hard. I don’t feel like to do it.<br>Rahmat : … to help you?<br>Fitri : It sounds great. Thanks, Rahmat!</p><p><br></p><p>Which of the following offering expressions best fill the blank?</p>', 'opsi_a' => '<p>Would you like me</p>', 'opsi_b' => '<p>Do you mind if I</p>', 'opsi_c' => '<p>Shall I</p>', 'opsi_d' => '<p>Can I</p>', 'opsi_e' => '<p>I will</p>', 'file_a' => '', 'file_b' => '', 'file_c' => '', 'file_d' => '', 'file_e' => '', 'jawaban' => 'A', 'created_on' => 1550225952, 'updated_on' => 1550225952],
            ['id_soal' => 3, 'dosen_id' => 1, 'matkul_id' => 1, 'bobot' => 1, 'file' => 'd166959dabe9a81e4567dc44021ea503.jpg', 'tipe_file' => 'image/jpeg', 'soal' => '<p>What is the picture describing?</p><p><small class="text-muted">Sumber gambar: meros.jp</small></p>', 'opsi_a' => '<p>The students are arguing with their lecturer.</p>', 'opsi_b' => '<p>The students are watching their preacher.</p>', 'opsi_c' => '<p>The teacher is angry with their students.</p>', 'opsi_d' => '<p>The students are listening to their lecturer.</p>', 'opsi_e' => '<p>The students detest the preacher.</p>', 'file_a' => '', 'file_b' => '', 'file_c' => '', 'file_d' => '', 'file_e' => '', 'jawaban' => 'D', 'created_on' => 1550226174, 'updated_on' => 1550226174],
            ['id_soal' => 5, 'dosen_id' => 3, 'matkul_id' => 5, 'bobot' => 1, 'file' => '', 'tipe_file' => '', 'soal' => '<p>(2000 x 3) : 4 x 0 = ...</p>', 'opsi_a' => '<p>NULL</p>', 'opsi_b' => '<p>NaN</p>', 'opsi_c' => '<p>0</p>', 'opsi_d' => '<p>1</p>', 'opsi_e' => '<p>-1</p>', 'file_a' => '', 'file_b' => '', 'file_c' => '', 'file_d' => '', 'file_e' => '', 'jawaban' => 'C', 'created_on' => 1550289702, 'updated_on' => 1550289724],
            ['id_soal' => 6, 'dosen_id' => 3, 'matkul_id' => 5, 'bobot' => 1, 'file' => '98a79c067fefca323c56ed0f8d1cac5f.png', 'tipe_file' => 'image/png', 'soal' => '<p>Nomor berapakah ini?</p>', 'opsi_a' => '<p>Sembilan</p>', 'opsi_b' => '<p>Sepuluh</p>', 'opsi_c' => '<p>Satu</p>', 'opsi_d' => '<p>Tujuh</p>', 'opsi_e' => '<p>Tiga</p>', 'file_a' => '', 'file_b' => '', 'file_c' => '', 'file_d' => '', 'file_e' => '', 'jawaban' => 'D', 'created_on' => 1550289774, 'updated_on' => 1550289774],
        ]);

        // ---- h_ujian ----
        $this->db->table('h_ujian')->truncate();
        $this->db->table('h_ujian')->insertBatch([
            ['id' => 1, 'ujian_id' => 1, 'mahasiswa_id' => 1, 'list_soal' => '1,2,3', 'list_jawaban' => '1:B:N,2:A:N,3:D:N', 'jml_benar' => 3, 'nilai' => '100.00', 'nilai_bobot' => '100.00', 'tgl_mulai' => '2019-02-16 08:35:05', 'tgl_selesai' => '2019-02-16 08:36:05', 'status' => 'N'],
            ['id' => 2, 'ujian_id' => 2, 'mahasiswa_id' => 1, 'list_soal' => '3,2,1', 'list_jawaban' => '3:D:N,2:C:N,1:D:N', 'jml_benar' => 1, 'nilai' => '33.00', 'nilai_bobot' => '100.00', 'tgl_mulai' => '2019-02-16 10:11:14', 'tgl_selesai' => '2019-02-16 10:12:14', 'status' => 'N'],
            ['id' => 3, 'ujian_id' => 3, 'mahasiswa_id' => 1, 'list_soal' => '5,6', 'list_jawaban' => '5:C:N,6:D:N', 'jml_benar' => 2, 'nilai' => '100.00', 'nilai_bobot' => '100.00', 'tgl_mulai' => '2019-02-16 11:06:25', 'tgl_selesai' => '2019-02-16 11:07:25', 'status' => 'N'],
        ]);

        // ---- users ----
        $this->db->table('users')->truncate();
        $this->db->table('users')->insertBatch([
            ['id' => 1, 'ip_address' => '127.0.0.1', 'username' => 'Administrator', 'password' => '$2y$12$tGY.AtcyXrh7WmccdbT1rOuKEcTsKH6sIUmDr0ore1yN4LnKTTtuu', 'email' => 'admin@admin.com', 'activation_selector' => null, 'activation_code' => '', 'forgotten_password_selector' => null, 'forgotten_password_code' => null, 'forgotten_password_time' => null, 'remember_selector' => null, 'remember_code' => null, 'created_on' => 1268889823, 'last_login' => 1550743550, 'active' => 1, 'first_name' => 'Admin', 'last_name' => 'Istrator', 'company' => 'ADMIN', 'phone' => '0'],
            ['id' => 3, 'ip_address' => '::1', 'username' => '12183018', 'password' => '$2y$10$TLtlU8WsPUBQgLWcL5n8SO9YoTd1jDktGIkIvm9Fk2ROI0yJQ.TlC', 'email' => 'mghifariarfan@gmail.com', 'activation_selector' => null, 'activation_code' => null, 'forgotten_password_selector' => null, 'forgotten_password_code' => null, 'forgotten_password_time' => null, 'remember_selector' => null, 'remember_code' => null, 'created_on' => 1550225511, 'last_login' => 1550743572, 'active' => 1, 'first_name' => 'Muhammad', 'last_name' => 'Arfananda', 'company' => null, 'phone' => null],
            ['id' => 4, 'ip_address' => '::1', 'username' => '12345678', 'password' => '$2y$10$9CxUKgrB/0tlgOEIec1Fl.RMrLLcpJPGyFqqRh2gec.crgeVBWvym', 'email' => 'korosensei@gmail.com', 'activation_selector' => null, 'activation_code' => null, 'forgotten_password_selector' => null, 'forgotten_password_code' => null, 'forgotten_password_time' => null, 'remember_selector' => null, 'remember_code' => null, 'created_on' => 1550226286, 'last_login' => 1550743600, 'active' => 1, 'first_name' => 'Koro', 'last_name' => 'Sensei', 'company' => null, 'phone' => null],
            ['id' => 8, 'ip_address' => '::1', 'username' => '01234567', 'password' => '$2y$10$5pAJAyB3XvrGEkvGak2QI.1pWqwK/S76r3Pf4ltQSGQzLMpw53Tvy', 'email' => 'tobirama@gmail.com', 'activation_selector' => null, 'activation_code' => null, 'forgotten_password_selector' => null, 'forgotten_password_code' => null, 'forgotten_password_time' => null, 'remember_selector' => null, 'remember_code' => null, 'created_on' => 1550289356, 'last_login' => 1550743585, 'active' => 1, 'first_name' => 'Tobirama', 'last_name' => 'Sensei', 'company' => null, 'phone' => null],
        ]);

        // ---- users_groups ----
        $this->db->table('users_groups')->truncate();
        $this->db->table('users_groups')->insertBatch([
            ['id' => 3,  'user_id' => 1, 'group_id' => 1],
            ['id' => 5,  'user_id' => 3, 'group_id' => 3],
            ['id' => 6,  'user_id' => 4, 'group_id' => 2],
            ['id' => 10, 'user_id' => 8, 'group_id' => 2],
        ]);

        // ---- login_attempts ----
        $this->db->table('login_attempts')->truncate();
        $this->db->table('login_attempts')->insert([
            'id' => 1, 'ip_address' => '::1', 'login' => 'ad', 'time' => 1550742963,
        ]);

        // Re-enable foreign key checks
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');

        echo "Seeded: groups, jurusan, matkul, dosen, jurusan_matkul, kelas, kelas_dosen, mahasiswa, m_ujian, tb_soal, h_ujian, users, users_groups, login_attempts\n";
    }
}