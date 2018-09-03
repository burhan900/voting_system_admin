<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::get('/', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
Route::get('/register', 'Auth\AdminLoginController@showRegisterForm')->name('admin.register');
Route::post('/register', 'Auth\AdminLoginController@create')->name('admin.register.submit');
Route::get('/logout', 'AdminController@logout')->name('admin.login');

Route::group(['prefix' => 'admin'], function () {
    Route::get('/dashboard', 'AdminController@index')->name('admin.dashboard');
    Route::get('/reports', 'AdminController@dailyReports')->name('admin.report');
    Route::get('/poll', 'PollController@index')->name('poll.show');
    Route::get('/poll/ajax/{offset}', 'PollController@ajaxPoll')->name('poll.show.ajax');
    Route::get('/poll/create', 'PollController@create')->name('poll.create');
    Route::post('/poll/store', 'PollController@store')->name('poll.store');
    Route::get('/poll/destroy/{id}', 'PollController@destroy')->name('poll.destroy');
    Route::get('/poll/edit/{id}', 'PollController@edit')->name('poll.edit');
    Route::patch('/poll/update/{id}', 'PollController@update')->name('poll.edit');
});
Route::group(['prefix' => 'api'], function () {
    Route::post('/register-user', 'ApiController@regeisterUser');
    Route::post('/login', 'ApiController@userLogin');
});
Route::group(['prefix' => 'api/poll'], function () {
    Route::get('/', 'ApiController@getPolls');
    Route::post('/vote', 'ApiController@vote');
});

