<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
Auth::routes();



Route::group(['middleware'=>'auth'],function()
{
    Route::get('/', function () { return view('index');});
    // Route::get('/home', 'HomeController@index')->name('home');

    Route::resource('guru','GuruController');
    Route::resource('siswa','SiswaController');
    Route::resource('mapel','MapelController');
    Route::resource('tingkat','TingkatController');
    Route::get('rekap/import-excel','RekapController@importExcel');
    Route::resource('rekap','RekapController');
    Route::get('rekap/{url_custom}/download-pdf-rekap-kelas','RekapController@downloadPdfRekapKelas');

    // Route::get('rekap','RekapController@index');
    // Route::get('/rekap/{url_custom}/edit','RekapController@edit');
    // Route::post('/rekap','RekapController@store');
});

// Route::get('/article','ArticleController@index');
// Route::get('/article/create','ArticleController@create');
// Route::get('/article/{id}','ArticleController@id');
// Route::get('/article/{id}/edit','ArticleController@edit');
// Route::post('/article','ArticleController@store');
// Route::put('/article/{id}','ArticleController@update');
// Route::delete('/article/{id}','ArticleController@destroy');


