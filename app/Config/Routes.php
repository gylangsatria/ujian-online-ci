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

// Master (placeholder for Phase 2)
$routes->group('', ['filter' => 'auth'], static function ($routes) {
    $routes->get('jurusan', 'Jurusan::index');
    $routes->get('matkul', 'Matkul::index');
    $routes->get('dosen', 'Dosen::index');
    $routes->get('kelas', 'Kelas::index');
    $routes->get('mahasiswa', 'Mahasiswa::index');
    $routes->get('jurusan-matkul', 'JurusanMatkul::index');
    $routes->get('kelas-dosen', 'KelasDosen::index');
    $routes->get('soal', 'Soal::index');
    $routes->get('ujian', 'Ujian::index');
    $routes->get('hasil-ujian', 'HasilUjian::index');
    $routes->get('users', 'Users::index');
    $routes->get('settings', 'Settings::index');
});
