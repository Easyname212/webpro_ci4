<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Admin::login');
$routes->get('/admin/login-admin', 'Admin::login');
$routes->get('/admin/dashboard-admin', 'Admin::dashboard');
$routes->post('/admin/autentikasi-login', 'Admin::autentikasi');
$routes->get('/admin/logout', 'Admin::logout');

// Routes untuk module admin
$routes->get('/admin/master-data-admin', 'Admin::master_data_admin');
$routes->get('/admin/input-data-admin', 'Admin::input_data_admin');
$routes->post('/admin/simpan-admin', 'Admin::simpan_data_admin');
$routes->get('/admin/edit-data-admin/(:alphanum)', 'Admin::edit_data_admin/$1');
$routes->post('/admin/update-admin', 'Admin::update_data_admin');
$routes->get('/admin/hapus-data-admin/(:alphanum)', 'Admin::hapus_data_admin/$1');

// Routes untuk module buku
$routes->get('/admin/master-data-buku', 'Admin::master_buku');
$routes->get('/admin/input-buku', 'Admin::input_data_buku');
$routes->post('/admin/save-buku', 'Admin::simpan_data_buku');
$routes->get('/admin/edit-buku/(:alphanum)', 'Admin::edit_data_buku/$1');
$routes->post('/admin/update-buku', 'Admin::update_data_buku');
$routes->get('/admin/delete-buku/(:alphanum)', 'Admin::hapus_data_buku/$1');
