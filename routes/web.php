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
Route::group(['middleware' => ['auth', 'checkRole:petugas,anggota']], function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');
    Route::resource('/buku', 'Admin\BukuController')->only('show');
    Route::resource('/petugas', 'Admin\PetugasController')->only('show');
    Route::resource('/pinjam', 'Admin\PinjamController')->only('show');
});

Route::group(['middleware' => ['auth', 'checkRole:petugas'], 'namespace' => 'Admin'], function () {
    Route::get('/pengarang/json', 'PengarangController@json');
    Route::get('/penerbit/json', 'PenerbitController@json');
    Route::get('/kategori/json', 'KategoriController@json');
    Route::get('/anggota/json', 'AnggotaController@json');
    Route::get('/petugas/json', 'PetugasController@json');
    Route::get('/rak/json', 'RakController@json');
    Route::get('/buku/json', 'BukuController@json');
    Route::get('/peraturan/json', 'PeraturanController@json');
    Route::get('/pinjam/json', 'PinjamController@json');
    Route::get('/pengembalian/json', 'PengembalianController@json');

    Route::get('/pinjam/get-buku/{bukuIid}/{anggotaId}', 'PinjamController@getListBook');
    Route::get('/pinjam/getbyanggotaid/{id}', 'PinjamController@getbyanggotaid');
    Route::get('identitas-web', 'IdentitasController@index')->name('identitas');
    Route::post('identitas-web', 'IdentitasController@update')->name('identitas.update');

    Route::get('export-excel/{table}', 'ExportController@excel')->name('export-excel');
    Route::get('export-pdf/{table}', 'ExportController@pdf')->name('export-pdf');
    Route::post('import-excel/{table}', 'ImportController@index')->name('import-excel');

    Route::resource('/petugas', 'PetugasController')->except('show');
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

Route::group(['middleware' => ['auth', 'checkRole:anggota'], 'namespace' => 'Anggota'], function () {
    Route::get('/list-peminjaman/json', 'PinjamController@json');
    Route::get('/list-peminjaman', 'PinjamController@index')->name('anggota.pinjam');
});

Auth::routes();

