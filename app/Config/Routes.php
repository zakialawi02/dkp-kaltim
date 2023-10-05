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
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);
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
$routes->get('/', 'Home::index');
$routes->get('/data/petaPreview', 'Data::petaPreview');
$routes->get('/noaccess', 'Data::noaccess');
$routes->get('/kontak', 'Data::kontak');

$routes->get('/dashboard', 'Admin::index', ['filter' => 'role:SuperAdmin,Admin,User']);

// MyProfile
$routes->get('/MyProfile', 'MyProfile::index', ['filter' => 'role:SuperAdmin,Admin,User']);
$routes->post('/MyProfile/UpdateMyData/(:num)', 'MyProfile::UpdateMyData/$1', ['filter' => 'role:SuperAdmin,Admin,User']);
$routes->post('/MyProfile/updatePassword', 'MyProfile::updatePassword', ['filter' => 'role:SuperAdmin,Admin,User']);
$routes->delete('/MyProfile/delete/(:num)/(:any)', 'MyProfile::delete/$1/$2', ['filter' => 'role:SuperAdmin,Admin,User']);

// kelola user
$routes->get('/user/kelola', 'User::kelola', ['filter' => 'role:SuperAdmin,Admin']);
$routes->post('/user/tambah', 'User::tambah', ['filter' => 'role:SuperAdmin']);
$routes->post('/user/updateUser', 'User::updateUser', ['filter' => 'role:SuperAdmin']);
$routes->delete('/user/delete/(:num)/(:any)', 'User::delete/$1/$2', ['filter' => 'role:SuperAdmin']);

// setting Map
$routes->get('/admin/setting', 'Admin::setting', ['filter' => 'role:SuperAdmin,Admin']);
$routes->post('/admin/UpdateSetting', 'Admin::UpdateSetting', ['filter' => 'role:SuperAdmin,Admin']);

// modul
$routes->get('/data/modul', 'Data::modul');
$routes->get('/admin/dataModul', 'Admin::dataModul', ['filter' => 'role:SuperAdmin']);
$routes->get('/admin/tambahModul', 'Admin::tambahModul', ['filter' => 'role:SuperAdmin']);
$routes->match(['get', 'post'], '/admin/editModul/(:num)', 'Admin::editModul/$1', ['filter' => 'role:SuperAdmin']);
$routes->post('/admin/tambah_modul', 'Admin::tambah_modul', ['filter' => 'role:SuperAdmin']);
$routes->post('/admin/update_modul/(:num)', 'Admin::update_modul/$1', ['filter' => 'role:SuperAdmin']);
$routes->delete('/admin/delete_modul/(:num)', 'Admin::delete_modul/$1', ['filter' => 'role:SuperAdmin']);

// Cek Kesesuaian
$routes->get('/peta', 'Data::peta');
$routes->match(['get', 'post'], '/data/cekStatus', 'Data::cekStatus');
$routes->match(['get', 'post'], '/data/cekData', 'Data::cekData');
$routes->get('/data/pengajuan', 'Data::pengajuan');
$routes->post('/data/isiAjuan', 'Data::isiAjuan');

// DATA AJUAN
$routes->post('/data/tambahAjuan', 'Data::tambahAjuan', ['filter' => 'role:SuperAdmin,Admin,User']);
$routes->post('/data/updateAjuan/(:num)', 'Data::updateAjuan/$1', ['filter' => 'role:SuperAdmin,Admin,User']);
$routes->get('/data/permohonan/(:num)/edit/', 'Data::editPengajuan/$1', ['filter' => 'role:SuperAdmin,Admin,User']);
$routes->delete('/data/delete_pengajuan/(:num)', 'Data::delete_pengajuan/$1', ['filter' => 'role:SuperAdmin,Admin,User']);
$routes->get('/admin/data/(:any)/lihat/(:num)/(:any)', 'Admin::periksaDataPermohonan/$1/$2/$3', ['filter' => 'role:SuperAdmin,Admin,User']);
$routes->get('/admin/data/permohonan/disetujui/semua', 'Admin::DataDisetujuiSemua', ['filter' => 'role:SuperAdmin,Admin']);
$routes->get('/admin/data/permohonan/disetujui/terlampir', 'Admin::DataDisetujuiDenganLampiran', ['filter' => 'role:SuperAdmin,Admin']);
$routes->get('/admin/data/permohonan/disetujui/', 'Admin::DataDisetujuiTanpaLampiran', ['filter' => 'role:SuperAdmin,Admin']);
$routes->get('/admin/data/permohonan/tidak-disetujui/semua', 'Admin::DataTidakDisetujui', ['filter' => 'role:SuperAdmin,Admin']);
// doc upload
$routes->post('/data/loadDoc/(:any)', 'Data::loadDoc/$1', ['filter' => 'role:SuperAdmin,Admin,User']);
$routes->post('/data/uploadDoc', 'Data::uploadDoc', ['filter' => 'role:SuperAdmin,Admin,User']);
$routes->post('/data/revertDoc', 'Data::revertDoc', ['filter' => 'role:SuperAdmin,Admin,User']);
$routes->match(['delete', 'post'], '/data/delete_file', 'Data::delete_file', ['filter' => 'role:SuperAdmin,Admin,User']);
// pending
$routes->get('/admin/data/permohonan/masuk', 'Admin::pending', ['filter' => 'role:SuperAdmin,Admin']);
$routes->post('/admin/kirimTindakan/(:num)', 'Admin::kirimTindakan/$1', ['filter' => 'role:SuperAdmin,Admin,User']);

// P. kegiatan
$routes->get('/admin/kegiatan/', 'Admin::kegiatan', ['filter' => 'role:SuperAdmin']);
$routes->get('/admin/loadKegiatan/', 'Admin::loadKegiatan', ['filter' => 'role:SuperAdmin']);
$routes->match(['get', 'post'], '/admin/datakegiatan/(:num)', 'Admin::datakegiatan/$1', ['filter' => 'role:SuperAdmin']);
$routes->post('/admin/tambahKegiatan', 'Admin::tambahKegiatan', ['filter' => 'role:SuperAdmin']);
$routes->post('/admin/updatekegiatan/(:num)', 'Admin::updatekegiatan/$1', ['filter' => 'role:SuperAdmin']);
$routes->delete('/admin/delete_kegiatan/(:num)', 'Admin::delete_kegiatan/$1', ['filter' => 'role:SuperAdmin']);

$routes->get('/admin/zona/', 'Admin::zona', ['filter' => 'role:SuperAdmin']);

// P. kawasan
$routes->get('/admin/kawasan/', 'Admin::kawasan', ['filter' => 'role:SuperAdmin']);
$routes->get('/admin/kawasanByZona/(:num)', 'Admin::kawasanByZona/$1', ['filter' => 'role:SuperAdmin']);
$routes->get('/admin/dataKawasan/(:num)', 'Admin::dataKawasan/$1', ['filter' => 'role:SuperAdmin']);
$routes->post('/admin/tambahKawasan', 'Admin::tambahKawasan', ['filter' => 'role:SuperAdmin']);
$routes->post('/admin/updateKawsan/(:num)', 'Admin::updateKawsan/$1', ['filter' => 'role:SuperAdmin']);
$routes->delete('/admin/delete_kawasan/(:num)', 'Admin::delete_kawasan/$1', ['filter' => 'role:SuperAdmin']);

// P. kesesuaian
$routes->get('/admin/kesesuaian/', 'Admin::kesesuaian', ['filter' => 'role:SuperAdmin']);
$routes->get('/admin/kesesuaianByZona/', 'Admin::kesesuaianByZona', ['filter' => 'role:SuperAdmin']);
$routes->get('/admin/dataKesesuaian/(:num)', 'Admin::dataKesesuaian/$1', ['filter' => 'role:SuperAdmin']);
$routes->post('/admin/tambahAturanKesesuaian/', 'Admin::tambahAturanKesesuaian', ['filter' => 'role:SuperAdmin']);
$routes->post('/admin/updateAturanKesesuaian/(:num)', 'Admin::updateAturanKesesuaian/$1', ['filter' => 'role:SuperAdmin']);
$routes->delete('/admin/delete_kesesuaian/(:num)', 'Admin::delete_kesesuaian/$1', ['filter' => 'role:SuperAdmin']);







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
