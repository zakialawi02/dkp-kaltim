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
$routes->get('/peta', 'Data::peta');
$routes->get('/kontak', 'Data::kontak');

$routes->get('/dashboard', 'Admin::index', ['filter' => 'role:SuperAdmin,Admin,User']);
$routes->get('/admin/setting', 'Admin::setting', ['filter' => 'role:SuperAdmin,Admin']);
$routes->get('/user/kelola', 'User::manajemen', ['filter' => 'role:SuperAdmin,Admin']);
$routes->get('/admin/data/permohonan/masuk', 'Admin::pending', ['filter' => 'role:SuperAdmin,Admin']);
$routes->get('/admin/pending', 'Admin::pending', ['filter' => 'role:SuperAdmin,Admin']);


$routes->post('/data/tambahAjuan', 'Data::tambahAjuan', ['filter' => 'role:SuperAdmin,Admin,User']);
$routes->post('/data/updateAjuan/(:num)', 'Data::updateAjuan/$1', ['filter' => 'role:SuperAdmin,Admin,User']);
$routes->post('/data/editPengajuan/(:num)', 'Data::editPengajuan/$1', ['filter' => 'role:SuperAdmin,Admin,User']);
$routes->get('/data/permohonan/(:num)/edit/', 'Data::editPengajuan/$1', ['filter' => 'role:SuperAdmin,Admin,User']);
$routes->delete('/data/delete_pengajuan/(:num)', 'Data::delete_pengajuan/$1', ['filter' => 'role:SuperAdmin,Admin,User']);
$routes->get('/admin/data/(:any)/lihat/(:num)/(:any)', 'Admin::periksaDataPermohonan/$1/$2/$3', ['filter' => 'role:SuperAdmin,Admin,User']);
$routes->get('/admin/DataDisetujuiSemua', 'Admin::DataDisetujuiSemua', ['filter' => 'role:SuperAdmin,Admin']);
$routes->get('/admin/data/permohonan/disetujui/semua', 'Admin::DataDisetujuiSemua', ['filter' => 'role:SuperAdmin,Admin']);
$routes->get('/admin/DataDisetujuiDenganLampiran', 'Admin::DataDisetujuiDenganLampiran', ['filter' => 'role:SuperAdmin,Admin']);
$routes->get('/admin/data/permohonan/disetujui/terlampir', 'Admin::DataDisetujuiDenganLampiran', ['filter' => 'role:SuperAdmin,Admin']);
$routes->get('/admin/DataDisetujuiTanpaLampiran', 'Admin::DataDisetujuiTanpaLampiran', ['filter' => 'role:SuperAdmin,Admin']);
$routes->get('/admin/data/permohonan/disetujui/', 'Admin::DataDisetujuiTanpaLampiran', ['filter' => 'role:SuperAdmin,Admin']);
$routes->get('/admin/DataTidakDisetujui', 'Admin::DataTidakDisetujui', ['filter' => 'role:SuperAdmin,Admin']);
$routes->get('/admin/data/permohonan/tidak-disetujui/semua', 'Admin::DataTidakDisetujui', ['filter' => 'role:SuperAdmin,Admin']);


$routes->get('/admin/kegiatan/', 'Admin::kegiatan', ['filter' => 'role:SuperAdmin']);

$routes->get('/admin/zona/', 'Admin::zona', ['filter' => 'role:SuperAdmin']);

$routes->get('/admin/kawasan/', 'Admin::kawasan', ['filter' => 'role:SuperAdmin']);
$routes->get('/admin/kawasanByZona/(:num)', 'Admin::kawasanByZona/$1', ['filter' => 'role:SuperAdmin']);
$routes->post('/admin/tambahKawasan', 'Admin::tambahKawasan', ['filter' => 'role:SuperAdmin']);
$routes->delete('/admin/delete_kawasan/(:num)', 'Admin::delete_kawasan/$1', ['filter' => 'role:SuperAdmin']);

$routes->get('/admin/kesesuaian/', 'Admin::kesesuaian', ['filter' => 'role:SuperAdmin']);
$routes->get('/admin/kesesuaianByZona/', 'Admin::kesesuaianByZona', ['filter' => 'role:SuperAdmin']);
$routes->get('/admin/dataKesesuaian/(:num)', 'Admin::dataKesesuaian/$1', ['filter' => 'role:SuperAdmin']);
$routes->post('/admin/tambahAturanKesesuaian/', 'Admin::tambahAturanKesesuaian', ['filter' => 'role:SuperAdmin']);
$routes->post('/admin/updateAturanKesesuaian/(:num)', 'Admin::updateAturanKesesuaian/$1', ['filter' => 'role:SuperAdmin']);
$routes->delete('/admin/delete_kesesuaian/(:num)', 'Admin::delete_kesesuaian/$1', ['filter' => 'role:SuperAdmin']);



$routes->match(['get', 'post'], '/data/cekStatus', 'Data::cekStatus');
$routes->match(['get', 'post'], '/data/cekData', 'Data::cekData');



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
