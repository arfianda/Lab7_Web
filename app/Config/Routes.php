<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Default route
$routes->get('/', 'Home::index');

// Public routes
$routes->get('/artikel', 'Artikel::index');
$routes->get('/artikel/(:any)', 'Artikel::detail/$1');

// Static pages
$routes->get('/about', 'Page::about');
$routes->get('/contact', 'Page::contact');
$routes->get('/faqs', 'Page::faqs');

$routes->get('/user', 'User::index');
$routes->match(['get', 'post'], '/user/login', 'User::login');
$routes->get('/user/logout', 'User::logout');

// Admin routes
$routes->group('admin', ['filter' => 'auth'], function ($routes) {
    $routes->get('artikel', 'Artikel::adminIndex');
    $routes->get('artikel/add', 'Artikel::add');
    $routes->post('artikel/store', 'Artikel::store');
    $routes->get('artikel/edit/(:num)', 'Artikel::edit/$1');
    $routes->post('artikel/update/(:num)', 'Artikel::update/$1');
    $routes->get('artikel/delete/(:num)', 'Artikel::delete/$1');
    $routes->get('artikel/search', 'Artikel::search');
});

// Enable auto routing
