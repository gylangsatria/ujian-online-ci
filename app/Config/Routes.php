<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

// Auth
$routes->get('/login', 'Auth\Login::index');
$routes->post('/login', 'Auth\Login::process');
$routes->get('/logout', 'Auth\Login::logout');

// Dashboard
$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'auth']);

// Routes for all logged-in users
$routes->group('', ['filter' => 'auth'], static function ($routes) {
    $routes->get('settings', 'Settings::index');
    $routes->post('settings/update_password', 'Settings::update_password');
});

// Admin Only Routes
$routes->group('', ['filter' => 'auth:admin'], static function ($routes) {
    // Jurusan
    $routes->get('jurusan', 'Jurusan::index');
    $routes->match(['get', 'post'], 'jurusan/create', 'Jurusan::create');
    $routes->match(['get', 'post'], 'jurusan/update/(:num)', 'Jurusan::update/$1');
    $routes->get('jurusan/delete/(:num)', 'Jurusan::delete/$1');

    // Matkul
    $routes->get('matkul', 'Matkul::index');
    $routes->match(['get', 'post'], 'matkul/create', 'Matkul::create');
    $routes->match(['get', 'post'], 'matkul/update/(:num)', 'Matkul::update/$1');
    $routes->get('matkul/delete/(:num)', 'Matkul::delete/$1');

    // Dosen
    $routes->get('dosen', 'Dosen::index');
    $routes->match(['get', 'post'], 'dosen/create', 'Dosen::create');
    $routes->match(['get', 'post'], 'dosen/update/(:num)', 'Dosen::update/$1');
    $routes->get('dosen/delete/(:num)', 'Dosen::delete/$1');

    // Kelas
    $routes->get('kelas', 'Kelas::index');
    $routes->match(['get', 'post'], 'kelas/create', 'Kelas::create');
    $routes->match(['get', 'post'], 'kelas/update/(:num)', 'Kelas::update/$1');
    $routes->get('kelas/delete/(:num)', 'Kelas::delete/$1');

    // Mahasiswa
    $routes->get('mahasiswa', 'Mahasiswa::index');
    $routes->match(['get', 'post'], 'mahasiswa/create', 'Mahasiswa::create');
    $routes->match(['get', 'post'], 'mahasiswa/update/(:num)', 'Mahasiswa::update/$1');
    $routes->get('mahasiswa/delete/(:num)', 'Mahasiswa::delete/$1');

    // Jurusan-Matkul
    $routes->get('jurusan-matkul', 'JurusanMatkul::index');
    $routes->match(['get', 'post'], 'jurusan-matkul/create', 'JurusanMatkul::create');
    $routes->get('jurusan-matkul/delete/(:num)', 'JurusanMatkul::delete/$1');

    // Kelas-Dosen
    $routes->get('kelas-dosen', 'KelasDosen::index');
    $routes->match(['get', 'post'], 'kelas-dosen/create', 'KelasDosen::create');
    $routes->get('kelas-dosen/delete/(:num)', 'KelasDosen::delete/$1');

    // User management
    $routes->get('users', 'Users::index');
    $routes->get('users/edit/(:num)', 'Users::edit/$1');
    $routes->post('users/update', 'Users::update');
    $routes->get('users/delete/(:num)', 'Users::delete/$1');
    $routes->get('users/activate/(:num)', 'Users::activate/$1');
    $routes->get('users/deactivate/(:num)', 'Users::deactivate/$1');
});

// Admin & Dosen Routes
$routes->group('', ['filter' => 'auth:admin,dosen'], static function ($routes) {
    // Bank Soal
    $routes->get('soal', 'Soal::index');
    $routes->match(['get', 'post'], 'soal/create', 'Soal::create');
    $routes->match(['get', 'post'], 'soal/update/(:num)', 'Soal::update/$1');
    $routes->get('soal/delete/(:num)', 'Soal::delete/$1');
    $routes->match(['get', 'post'], 'soal/import', 'Soal::import');
    $routes->get('soal/export', 'Soal::export');
    $routes->get('soal/template', 'Soal::template');

    // Ujian
    $routes->get('ujian', 'Ujian::index');
    $routes->get('ujian/add', 'Ujian::add');
    $routes->get('ujian/edit/(:num)', 'Ujian::edit/$1');
    $routes->post('ujian/save', 'Ujian::save');
    $routes->get('ujian/token/(:num)', 'Ujian::token/$1');
    $routes->get('ujian/delete/(:num)', 'Ujian::delete/$1');

    // Hasil Ujian
    $routes->get('hasilujian', 'HasilUjian::index');
    $routes->get('hasilujian/detail/(:num)', 'HasilUjian::detail/$1');
    $routes->get('hasilujian/cetak/(:num)', 'HasilUjian::cetak/$1');
});

// Mahasiswa Only Routes
$routes->group('', ['filter' => 'auth:mahasiswa'], static function ($routes) {
    $routes->get('tes', 'Tes::index');
    $routes->get('tes/token/(:num)', 'Tes::token/$1');
    $routes->post('tes/cek_token', 'Tes::cek_token');
    $routes->get('tes/mulai/(:num)', 'Tes::mulai/$1');
    $routes->get('tes/kerjakan/(:num)', 'Tes::kerjakan/$1');
    $routes->post('tes/simpan_satu', 'Tes::simpan_satu');
    $routes->post('tes/selesai', 'Tes::selesai');
});
