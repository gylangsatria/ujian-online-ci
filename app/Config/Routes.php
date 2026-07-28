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

// Master
$routes->group('', ['filter' => 'auth'], static function ($routes) {
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

    // Placeholder
    $routes->get('soal', 'Soal::index');
    $routes->get('ujian', 'Ujian::index');
    $routes->get('hasil-ujian', 'HasilUjian::index');
    $routes->get('users', 'Users::index');
    $routes->get('settings', 'Settings::index');
});
