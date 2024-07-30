<?php

namespace Config;

$routes = Services::routes();

if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

$routes->group('auth', function ($routes) {
    $routes->post('registration/relawan', 'Auth::registrationRelawan');
    $routes->post('registration/pemilih', 'Auth::registrationPemilih');
    $routes->post('login', 'Auth::login');
    $routes->post('logout', 'Auth::logout');
    $routes->post('validate', 'Auth::validateToken');

});

$routes->group('relawan', ['filter' => 'jwt:relawan,admin'], function ($routes) {
    $routes->post('completion', 'Relawan::completionRegistration');
    $routes->post('completion', 'Relawan::completionRegistration');
});

$routes->group('pemilih', ['filter' => 'jwt:pemilih,admin'], function ($routes) {
    $routes->post('completion', 'Pemilih::completionRegistration');
});

$routes->group('attachment', ['filter' => 'jwt:relawan,pemilih,admin'], function ($routes) {
    $routes->post('upload', 'Attachment::uploadAttachment');
});

$routes->group('search', ['filter' => 'jwt'], function ($routes) {
    $routes->post('user', 'Auth::getUsers');
    $routes->post('userByID', 'Auth::getUserByID');
});

if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
