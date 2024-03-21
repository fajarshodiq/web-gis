<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Dashboard::index');
$routes->get('dashboard', 'Dashboard::index');
$routes->get('/form/createdata', 'Form::createdata');
$routes->post('/form/simpan', 'Form::simpan');
$routes->get('/form/datasanggar', 'Form::datasanggar');
$routes->get('/form/hapus/(:num)', 'Form::hapus/$1');
$routes->get('/form/update/(:segment)', 'Form::update/$1');
$routes->post('/form/prosesupdate/(:segment)', 'Form::prosesupdate/$1');

