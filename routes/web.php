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
    return view('welcome');
})->name('/');

Auth::routes();
Route::get('/verifyemail/{token}', 'Auth\RegisterController@verify');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/info', 'HomeController@info')->name('info');
Route::post('/add', ['uses' => 'HomeController@addPC', 'as' => 'add.form']);
Route::post('/send', ['uses' => 'HomeController@sendAction', 'as' => 'send.form']);
Route::post('/open', ['uses' => 'HomeController@openWeb', 'as' => 'open.form']);
Route::post('/sendonly', ['uses' => 'HomeController@sendActionOnly', 'as' => 'sendonly.form']);
Route::post('/openonly', ['uses' => 'HomeController@openWebOnly', 'as' => 'openonly.form']);
Route::post('/del', ['uses' => 'HomeController@deletePC', 'as' => 'del.form']);
Route::post('/senddata', ['uses' => 'HomeController@senddata', 'as' => 'data.form']);
Route::post('/senddataonly', ['uses' => 'HomeController@senddataonly', 'as' => 'dataonly.form']);
Route::get('/online/{date}', 'HomeController@checkonline')->name('online');


Route::get('/loginapp/{user}/{mail}/{pass}', 'LoginController@login')->name('loginapp');
Route::get('/sendonline/{user}/{mail}/{pass}/{token}', 'LoginController@updateonline')->name('uponline');
Route::get('/getwebstart/{user}/{mail}/{pass}/{token}/{id}', 'LoginController@getwebstart')->name('getwebstart');
Route::get('/optsistem/{user}/{mail}/{pass}/{token}/{id}', 'LoginController@optsistem')->name('optsistem');
Route::get('/getoptall/{user}/{mail}/{pass}/{token}/{id}', 'LoginController@getoptall')->name('getoptall');
Route::get('/getoptonly/{user}/{mail}/{pass}/{token}/{id}', 'LoginController@getoptonly')->name('getoptonly');
Route::get('/test/{req}', ['uses' => 'LoginController@test', 'as' => 'test.form']);
