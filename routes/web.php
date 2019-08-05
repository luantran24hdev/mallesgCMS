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

Route::get('/', 'DashboardController@index')->name('home');
Route::get('/dashboard', 'DashboardController@index')->name('home');

// Registration and Login Routes
Route::group(['namespace' => 'Auth'], function () {

    //Authentication Routes
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login');
    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'ResetPasswordController@reset')->name('password.update');
    Route::get('logout', 'LoginController@logout')->name('logout')->middleware('auth');

});
 
// Authenticated Routes
Route::group(['middleware' => ['auth'] ], function(){

    //malls
    Route::get('malls/search/{name?}', 'MallController@search')->name('malls.search');


    //merchants
    Route::resource('merchants', 'MerchantController', ['names' => [
        'index' => 'merchants'
    ]]);
    Route::get('merchants/search/{name?}', 'MerchantController@search')->name('merchants.search');

    //promotions
    Route::resource('promotions', 'PromotionController', ['names' => [
        'index' => 'promotions'
    ]]);
    Route::get('promotions/search/{name?}', 'PromotionController@search')->name('promotions.search');
    Route::get('promotions/{promotions}/{promo_id?}', 'PromotionController@show')->name('promotions.show');


    //locations
    Route::resource('locations', 'LocationController', ['names' => [
        'index' => 'locations'
    ]]);

    //promo tags
    Route::resource('promo-tags', 'PromotionTagController', ['names' => [
        'index' => 'promo-tags'
    ]]);
    Route::get('promo-tags/search/{name?}', 'PromotionTagController@search')->name('promo-tags.search');


});