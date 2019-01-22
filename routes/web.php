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

Route::group(['middleware' => 'no.ssl'], function () {
    Auth::routes(['register' => false]);
    Route::get('logout/', 'Auth\LoginController@logout');
    Route::get('', 'DashboardController');
    Route::get('dashboard/', 'DashboardController');
    Route::get('admin/', 'Admin\DashboardController');
    Route::get('register-user-token', 'Auth\RegisterUserTokenController@register');

    Route::resource('admin/account/fulfillment-policy', 'Admin\FulfillmentPolicyController');
    Route::resource('admin/logistics/shipping-service', 'Admin\ShippingServiceController');
});
