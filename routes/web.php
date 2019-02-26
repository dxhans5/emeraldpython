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

    Route::group(['prefix' => 'companies'], function(){
        Route::get('/', 'CompanyController@list')->name('companies');
        Route::match(array('GET', 'POST'), '/create', 'CompanyController@create')->name('create_company');
        Route::get('/delete/{id}', 'CompanyController@trash');
        Route::match(array('GET', 'POST'), '/{id}', 'CompanyController@detail');
    });
    Route::get('dashboard/', 'DashboardController')->name('dashboard');
    Route::get('policies/', 'PolicyController@list')->name('policies');
    Route::get('products/', 'ProductController@list')->name('products');
