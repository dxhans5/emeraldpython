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

    Auth::routes(['register' => false]);
    Route::match(array('GET', 'POST'), 'login/', 'AuthController@login')->name('login');
    Route::get('logout/', 'AuthController@logout')->name('logout');

    Route::get('', 'DashboardController');

    Route::group(['prefix' => 'categories'], function(){
        Route::get('/', 'CategoryController@list');
        Route::match(array('GET', 'POST'), '/create', 'CategoryController@create');
        Route::get('/edit/{id}', 'CategoryController@edit');
        Route::get('/ebay-update', 'CategoryController@ebayUpdate');
    });
    Route::group(['prefix' => 'companies'], function(){
        Route::get('/', 'CompanyController@list');
        Route::match(array('GET', 'POST'), '/create', 'CompanyController@create');
        Route::get('/delete/{id}', 'CompanyController@trash');
        Route::match(array('GET', 'POST'), '/{id}', 'CompanyController@detail');
    });
    Route::get('dashboard/', 'DashboardController');
    Route::group(['prefix' => 'policies'], function(){
        Route::get('/', 'PolicyController@list');
        Route::match(array('GET', 'POST'), '/create', 'PolicyController@create');
        Route::get('/edit/{id}', 'PolicyController@edit');
    });
    Route::group(['prefix' => 'products'], function(){
        Route::get('/', 'ProductController@list');
        Route::match(array('GET', 'POST'), '/create', 'ProductController@create');
        Route::post('/submit', 'ProductController@submit');
        Route::get('/edit/{id}', 'ProductController@edit');
        Route::get('/toggle-status/{id}', 'ProductController@toggleStatus');
        Route::get('/ebay-ad/{id}', 'ProductController@ebayAd');
    });
