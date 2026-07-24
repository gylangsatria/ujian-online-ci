<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

// Auth
$routes->get('/login', 'Auth\Login::index');
$routes->post('/login', 'Auth\Login::process');
$routes->get('/logout', 'Auth\Login::logout');

// Dashboard — protected
$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'auth']);
