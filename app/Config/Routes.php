<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
// Default route - redirect to login
$routes->get('/', 'Auth::login');

// Authentication routes
$routes->get('login', 'Auth::login');
$routes->post('auth/authenticate', 'Auth::authenticate');
$routes->get('auth/logout', 'Auth::logout');

// Protected routes (require login)
$routes->group('', ['filter' => 'auth'], function($routes) {
    $routes->get('dashboard', 'Dashboard::index');
    
    // Beneficiary routes
    $routes->get('beneficiaries', 'Beneficiaries::index');
    $routes->get('beneficiaries/create', 'Beneficiaries::create');
    $routes->post('beneficiaries/store', 'Beneficiaries::store');
    $routes->get('beneficiaries/view/(:num)', 'Beneficiaries::view/$1');
    $routes->get('beneficiaries/baseline/(:num)', 'Beneficiaries::baseline/$1');
    $routes->post('beneficiaries/baseline/(:num)', 'Beneficiaries::saveBaseline/$1');
    $routes->post('beneficiaries/case-notes/(:num)', 'Beneficiaries::addCaseNote/$1');
    $routes->post('beneficiaries/referrals/(:num)', 'Beneficiaries::addReferral/$1');
    $routes->get('beneficiaries/edit/(:num)', 'Beneficiaries::edit/$1');
    $routes->post('beneficiaries/update/(:num)', 'Beneficiaries::update/$1');
    $routes->post('beneficiaries/delete/(:num)', 'Beneficiaries::delete/$1');
    
    // Household routes
    $routes->get('households', 'Households::index');
    $routes->get('households/create', 'Households::create');
    $routes->post('households/store', 'Households::store');
    $routes->get('households/view/(:num)', 'Households::view/$1');
    $routes->get('households/edit/(:num)', 'Households::edit/$1');
    $routes->post('households/update/(:num)', 'Households::update/$1');
    
    // Project routes
    $routes->get('projects', 'Projects::index');
    $routes->get('projects/create', 'Projects::create');
    $routes->post('projects/store', 'Projects::store');
    $routes->get('projects/view/(:num)', 'Projects::view/$1');
    $routes->post('projects/enroll/(:num)', 'Projects::enroll/$1');
    $routes->post('projects/interventions/(:num)', 'Projects::addIntervention/$1');
    $routes->get('projects/edit/(:num)', 'Projects::edit/$1');
    $routes->post('projects/update/(:num)', 'Projects::update/$1');
    
    // Monitoring routes
    $routes->get('monitoring', 'Monitoring::index');
    $routes->get('monitoring/attendance', 'Monitoring::attendance');
    $routes->post('monitoring/attendance', 'Monitoring::storeAttendance');
    
    // Alert routes
    $routes->get('alerts', 'Alerts::index');
    $routes->post('alerts/generate', 'Alerts::generate');
    $routes->post('alerts/resolve/(:num)', 'Alerts::resolve/$1');
});
