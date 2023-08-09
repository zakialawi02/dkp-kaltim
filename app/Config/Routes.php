<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (is_file(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Data');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Data::index');
$routes->get('/noaccess', 'Data::noaccess');
$routes->match(['get', 'post'], 'admin/getDataAjaxRemote', 'Admin::getDataAjaxRemote');

$routes->get('/map', 'Data::map');
$routes->get('/kontak', 'Data::kontak');
$routes->get('/dashboard', 'Admin::index', ['filter' => 'role:SuperAdmin,Admin,User']);
$routes->get('/admin/pending', 'Admin::pending', ['filter' => 'role:SuperAdmin,Admin']);

$routes->get('/admin/setting', 'Admin::setting', ['filter' => 'role:SuperAdmin,Admin']);

$routes->get('/admin/geojson', 'Admin::geojson', ['filter' => 'role:SuperAdmin,Admin']);
$routes->get('/admin/features', 'Admin::geojson', ['filter' => 'role:SuperAdmin,Admin']);
$routes->get('/admin/features/tambah', 'Admin::tambahGeojson', ['filter' => 'role:SuperAdmin,Admin']);
$routes->get('/admin/features/edit/(:num)', 'Admin::editGeojson/$1', ['filter' => 'role:SuperAdmin,Admin']);
$routes->delete('/admin/delete_Geojson/(:num)', 'Admin::delete_Geojson/$1', ['filter' => 'role:SuperAdmin,Admin']);

$routes->get('/admin/DataPerizinan', 'Admin::DataPerizinan', ['filter' => 'role:SuperAdmin,Admin']);
$routes->get('/admin/data/data-perizinan', 'Admin::DataPerizinan', ['filter' => 'role:SuperAdmin,Admin']);
$routes->get('/data-perizinan/(:num)/detail', 'Data::detail/$1');
$routes->get('/data-perizinan/(:num)/edit/', 'Admin::editPerizinan/$1', ['filter' => 'role:SuperAdmin,Admin,User']);
$routes->get('/admin/kegiatan/', 'Admin::kegiatan', ['filter' => 'role:SuperAdmin,Admin']);
$routes->get('/admin/kegiatan/tambah', 'Admin::tambahKegiatan', ['filter' => 'role:SuperAdmin,Admin']);
$routes->get('/admin/data/zonasi/(:num)/edit/', 'Admin::editStatusZonasi/$1', ['filter' => 'role:SuperAdmin,Admin']);
$routes->get('/admin/data/zonasi/(:num)/add/', 'Admin::dumpAddStatusZonasi/$1', ['filter' => 'role:SuperAdmin,Admin']);

$routes->post('/data/tambahAjuan', 'Data::tambahAjuan', ['filter' => 'role:SuperAdmin,Admin,User']);
$routes->delete('/admin/delete_izin/(:num)', 'Admin::delete_izin/$1', ['filter' => 'role:SuperAdmin,Admin,User']);

$routes->get('/user/manajemen', 'User::manajemen', ['filter' => 'role:SuperAdmin,Admin']);

$routes->get('/map1', 'Data::mapCopy');


/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
