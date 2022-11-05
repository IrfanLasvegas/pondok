<?php

namespace Config;

use App\Controllers\Coba;

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
// $routes->get('/', 'Home::index',['filter' => 'login']);
// $routes->get('/', 'Home::index', ['filter' => 'role:administrator, user']);
// $routes->get('/', 'Home::index', ['filter' => 'role:super admin']);
$routes->get('/', 'Home::index');


// coba- penulisan dengan style ini perlu memanggil controller contoh use App\Controllers\Pegawai
// $routes->get('product/(:num)/(:num)', [Product::class, 'index']);
// // The above code is the same as the following:
// $routes->get('product/(:num)/(:num)', 'Product::index/$1/$2');
$routes->get('cb', [Coba::class, 'index']);
$routes->get('cb-show/(:any)/(:num)', [Coba::class, 'index']);

// $routes->get('cb-show/(:num)/(:num)', [[Coba::class, 'index'], '$1/$2']);






// coba- penulisan dengan style ini tidak perlu memanggil controller contoh use App\Controllers\Pegawai
$routes->get('/pegawai', 'Pegawai::index');
$routes->get('/pegawai/create', 'Pegawai::create');
$routes->post('/pegawai/store', 'Pegawai::store');
$routes->get('pegawai/edit/(:num)', 'Pegawai::edit/$1');
$routes->put('pegawai/update/(:num)', 'Pegawai::update/$1');
$routes->delete('pegawai/delete/(:num)', 'Pegawai::destroy/$1');



// manage user
$routes->get('manage-user', 'ManageUserController::index', ['filter' => 'role:super admin']);
$routes->get('manage-user/create', 'ManageUserController::create', ['filter' => 'role:super admin']);
$routes->post('manage-user/store', 'ManageUserController::store', ['filter' => 'role:super admin']);
$routes->get('manage-user/edit/(:num)', 'ManageUserController::edit/$1', ['filter' => 'role:super admin']);
$routes->put('manage-user/update/(:num)', 'ManageUserController::update/$1', ['filter' => 'role:super admin']);
$routes->delete('manage-user/delete/(:num)', 'ManageUserController::destroy/$1', ['filter' => 'role:super admin']);
$routes->post('manage-user/changest', 'ManageUserController::changest', ['filter' => 'role:super admin']);

// manage mhs
$routes->get('manage-mahasiswa', 'ManageMahasiswaController::index', ['filter' => 'role:super admin']);
$routes->get('manage-mahasiswa/edit/(:num)', 'ManageMahasiswaController::edit/$1', ['filter' => 'role:super admin']);
$routes->put('manage-mahasiswa/update/(:num)', 'ManageMahasiswaController::update/$1', ['filter' => 'role:super admin']);
$routes->delete('manage-mahasiswa/delete/(:num)', 'ManageMahasiswaController::destroy/$1', ['filter' => 'role:super admin']);




// manage orang tua
$routes->get('manage-orang-tua', 'ManageOrangTuaController::index', ['filter' => 'role:super admin']);
$routes->get('manage-orang-tua/edit/(:num)', 'ManageOrangTuaController::edit/$1', ['filter' => 'role:super admin']);
$routes->put('manage-orang-tua/update/(:num)', 'ManageOrangTuaController::update/$1', ['filter' => 'role:super admin']);
$routes->delete('manage-orang-tua/delete/(:num)', 'ManageOrangTuaController::destroy/$1', ['filter' => 'role:super admin']);


// mhs ortu
$routes->get('manage-take-parent/(:num)', 'MhsOrtuController::takeParent/$1', ['filter' => 'role:super admin']);
$routes->get('manage-take-student/(:num)', 'MhsOrtuController::takeStudent/$1', ['filter' => 'role:super admin']);
$routes->post('manage-mhsortu/delete', 'MhsOrtuController::destroy', ['filter' => 'role:super admin']);
$routes->post('manage-mhsortu/create', 'MhsOrtuController::create', ['filter' => 'role:super admin']);
$routes->post('manage-ortumhs/delete2', 'MhsOrtuController::destroy2', ['filter' => 'role:super admin']);
$routes->post('manage-ortumhs/create2', 'MhsOrtuController::create2', ['filter' => 'role:super admin']);


//berita
$routes->get('manage-berita', 'ManageBeritaController::index');
$routes->get('manage-berita/create', 'ManageBeritaController::create');
$routes->post('manage-berita/store', 'ManageBeritaController::store');
$routes->get('manage-berita/edit/(:num)', 'ManageBeritaController::edit/$1');
$routes->put('manage-berita/update/(:num)', 'ManageBeritaController::update/$1');
$routes->delete('manage-berita/delete/(:num)', 'ManageBeritaController::destroy/$1');
$routes->get('manage-berita/show/(:num)', 'ManageBeritaController::show/$1');


$routes->get('manage-komentar/show/(:num)', 'ManageKomentarController::show/$1');
$routes->post('manage-komentar/store', 'ManageKomentarController::store');
$routes->post('manage-komentar/delete', 'ManageKomentarController::destroy');


$routes->get('manage-galeri', 'ManageGaleriController::index');
$routes->get('manage-galeri/create', 'ManageGaleriController::create');
$routes->post('manage-galeri/store', 'ManageGaleriController::store');
$routes->get('manage-galeri/edit/(:num)', 'ManageGaleriController::edit/$1');
$routes->put('manage-galeri/update/(:num)', 'ManageGaleriController::update/$1');
$routes->delete('manage-galeri/delete/(:num)', 'ManageGaleriController::destroy/$1');


// keuangan
$routes->get('manage-keuangan', 'ManageKeuanganController::index');
$routes->get('manage-keuangan/create', 'ManageKeuanganController::create');
$routes->post('manage-keuangan/store', 'ManageKeuanganController::store');
$routes->get('manage-keuangan/edit/(:num)', 'ManageKeuanganController::edit/$1');
$routes->put('manage-keuangan/update/(:num)', 'ManageKeuanganController::update/$1');
$routes->delete('manage-keuangan/delete/(:num)', 'ManageKeuanganController::destroy/$1');
// $routes->get('manage-keuangan/all', 'ManageKeuanganController::all');


//keuangan detail 
$routes->get('manage-detail-keuangan', 'ManageKeuanganDetailController::index');
$routes->get('manage-detail-keuangan/create', 'ManageKeuanganDetailController::create');
$routes->post('manage-detail-keuangan/store', 'ManageKeuanganDetailController::store');
$routes->get('manage-detail-keuangan/edit/(:num)', 'ManageKeuanganDetailController::edit/$1');
$routes->put('manage-detail-keuangan/update/(:num)', 'ManageKeuanganDetailController::update/$1');
$routes->delete('manage-detail-keuangan/delete/(:num)', 'ManageKeuanganDetailController::destroy/$1');
$routes->post('manage-detail-keuangan/changest', 'ManageKeuanganDetailController::changest', ['filter' => 'role:super admin']);



// $t=[["met"=>"get","url"=>'/manage-user', "cont"=>'ManageUserController::index'],    
//     ["met"=>"get","url"=>'/manage-user2', "cont"=>'ManageUserController::index'],    
//     ["met"=>"get","url"=>'/manage-user3', "cont"=>'ManageUserController::index'],    ];
// foreach ($t as $key) {
//     // echo $key["url"].'<br>';
//     # code...

//     $routes->get ($key["url"], 'ManageUserController::index');
// }






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
