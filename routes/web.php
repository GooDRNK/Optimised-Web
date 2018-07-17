<?php
Route::get('/', function () {return view('welcome');})->name('/');
Auth::routes();
Route::get('/verifyemail/{token}', 'Auth\RegisterController@verify');
Route::get('/home', 'HomeController@index')->name('home');
Route::group(array('prefix' => 'api/'), function()
{

    Route::get('loginapp/{key}/', 'Client@login')->name('loginapp');
    Route::get('sendonline/{key}/{token}', 'Client@updateonline')->name('uponline');
    Route::get('setinfo/{key}/{token}/{ip}/{mac}/{win}/{localip}','Client@setinfo');
    Route::get('notify/{key}/{token}/{notify}/{other?}','Client@notify');
    Route::get('closeprocs/{key}/{token}/{id}','Client@closeproc');
    Route::get('setmainproc/{key}/{token}/{pid}/{hwnd}/{proc}/','Client@setmainproc');
    Route::get('report/{key}/{token}/{id}/{email}/{nume}/{mesaj}','Client@Report');

    Route::post('delete', ['uses' => 'HomeController@deletePC', 'as' => 'del.form']);
    Route::post('openurlonly', ['uses' => 'HomeController@openWebOnly', 'as' => 'openonly.form']);
    Route::post('closeproc',['uses' => 'HomeController@closeProc', 'as' => 'close.form']);
    Route::post('clearall', ['uses' => 'HomeController@sendData', 'as' => 'data.form']);
    Route::post('clearonly', ['uses' => 'HomeController@sendDataOnly', 'as' => 'dataonly.form']);
    Route::post('actionall', ['uses' => 'HomeController@sendAction', 'as' => 'send.form']);
    Route::post('actiononly', ['uses' => 'HomeController@sendActionOnly', 'as' => 'sendonly.form']);
    Route::post('openurlallonline', ['uses' => 'HomeController@openWeb', 'as' => 'open.form']);
    Route::post('add', ['uses' => 'HomeController@addPC', 'as' => 'add.form']);
    Route::get('users/{online?}','HomeController@GetUsers');    
    Route::get('logs', 'HomeController@logs')->name('logs');
    Route::post('senddataonly', ['uses' => 'HomeController@sendDataOnly', 'as' => 'dataonly.form']);
    Route::get('online/{date}', 'HomeController@checkonline')->name('online');
    Route::post('deletelogs', 'HomeController@DeleteLogs')->name('deletelogs');
    Route::post('fixedreports', 'HomeController@fixedReports')->name('fixedreports');
});