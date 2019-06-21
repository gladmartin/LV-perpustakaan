<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('site.home');
});

Route::group(['middleware' => ['auth', 'checkRole:petugas'], 'namespace' => 'Admin'], function () {
    Route::get('/pengarang/json', 'PengarangController@json');
    Route::get('/penerbit/json', 'PenerbitController@json');
    Route::get('/kategori/json', 'KategoriController@json');
    Route::get('/anggota/json', 'AnggotaController@json');
    Route::get('/petugas/json', 'PetugasController@json');
    Route::get('/rak/json', 'RakController@json');
    Route::get('/buku/json', 'BukuController@json');
    Route::get('/pinjam/get-buku/{bukuIid}/{anggotaId}', 'PinjamController@getListBook');
    Route::get('/peraturan/json', 'PeraturanController@json');
    Route::get('/pinjam/json', 'PinjamController@json');
    Route::get('/pinjam/getbyanggotaid/{id}', 'PinjamController@getbyanggotaid');
    Route::get('/pengembalian/json', 'PengembalianController@json');
    Route::get('identitas-web', 'IdentitasController@index')->name('identitas');
    Route::post('identitas-web', 'IdentitasController@update')->name('identitas.update');
    Route::resource('/petugas', 'PetugasController')->except('show');
    Route::get('/petugas/export-pdf', 'PetugasController@exportPdf');
    Route::get('/petugas/export-excel', 'PetugasController@exportExcel');
    Route::get('/petugas/import-excel', 'PetugasController@import');
    Route::resource('/buku', 'BukuController')->except('show');
    Route::resource('/anggota', 'AnggotaController');
    Route::resource('/rak', 'RakController');
    Route::resource('/pengarang', 'PengarangController');
    Route::resource('/kategori', 'KategoriController');
    Route::resource('/penerbit', 'PenerbitController');
    Route::resource('/peraturan', 'PeraturanController');
    Route::resource('/pinjam', 'PinjamController')->except('show');
    Route::resource('/pengembalian', 'PengembalianController');
});

Route::group(['middleware' => ['auth', 'checkRole:petugas,anggota']], function () {
    Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
    Route::resource('/buku', 'BukuController')->only('show');
    Route::resource('/petugas', 'PetugasController')->only('show');
    Route::resource('/pinjam', 'PinjamController')->only('show');
});

Route::group(['middleware' => ['auth', 'checkRole:anggota'], 'namespace' => 'Anggota'], function () {
    Route::get('/list-peminjaman/json', 'PinjamController@json');
    Route::get('/list-peminjaman', 'PinjamController@index')->name('anggota.pinjam');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
