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
Route::group(['middleware' => 'auth'], function () {

    //mallspromotions.location
    Route::resource('malls', 'MallController', ['names' => [
        'index' => 'malls'
    ]]);
    Route::get('malls/search/{name?}', 'MallController@search')->name('malls.search');
    Route::get('malls/search-with/{name?}', 'MallController@searchWith')->name('malls.searchwith');
    Route::post('malls/column-update/{id?}', 'MallController@columnUpdate')->name('malls.column-update');
    Route::post('malls/getCity', 'MallController@getCity')->name('malls.getcity');
    Route::post('malls/getType', 'MallController@getType')->name('malls.getType');
    Route::post('malls/getTown', 'MallController@getTown')->name('malls.getTown');
    Route::get('malls/images/{id}', 'MallController@mallImages')->name('malls.images');
    Route::post('malls/uploadimage', 'MallController@uploadimage')->name('malls.uploadimage');
    Route::post('malls/webdeleteimage/{id}', 'MallController@webdeleteimage')->name('malls.webdeleteimage');
    Route::post('malls/deletemallimage/{id}', 'MallController@deletemallimage')->name('malls.deletemallimage');


    Route::get('mall/info/{id}', 'MallController@mallInfo')->name('mall.info');

    //merchants
    Route::resource('merchants', 'MerchantController', ['names' => [
        'index' => 'merchants'
    ]]);

    Route::get('merchants/search/{name?}', 'MerchantController@search')->name('merchants.search');
    Route::get('merchants-list/', 'MerchantController@merchantList')->name('merchants.list');
    Route::get('merchants-list/{id?}', 'MerchantController@merchantListShow')->name('merchants.list.show');
    Route::post('merchants-list/column-update/{id?}', 'MerchantController@columnUpdate')->name('merchants.column-update');

    Route::get('merchants-list/images/{id}', 'MerchantController@merchantImages')->name('merchants.images');
    Route::post('merchants-list/uploadimage', 'MerchantController@uploadimage')->name('merchants.uploadimage');
    Route::post('merchants-list/webdeleteimage/{id}', 'MerchantController@webdeleteimage')->name('merchants.webdeleteimage');
    Route::post('merchants-list/deletemallimage/{id}', 'MerchantController@deletemallimage')->name('merchants.deletemallimage');


    //promotions

    Route::resource('promotions', 'PromotionController', ['names' => [
        'index' => 'promotions'
    ]]);
    Route::get('promotions/search/{name?}', 'PromotionController@search')->name('promotions.search');
    Route::get('promotions/{promotions}/{promo_id?}', 'PromotionController@show')->name('promotions.show');
    Route::post('promotions/uploadimage', 'PromotionController@uploadimage')->name('promotions.uploadimage');
    Route::post('promotions/deleteimage/{id}', 'PromotionController@deleteimage')->name('promotions.deleteimage');

    Route::post('promotions/getlocation', 'PromotionController@getLocation')->name('promotions.location');
    Route::post('promotions/column', 'PromotionController@activeUp')->name('promotions.col');


    //locations
    Route::resource('locations', 'LocationController', ['names' => [
        'index' => 'locations'
    ]]);

    //promo tags
    Route::resource('promo-tags', 'PromotionTagController', ['names' => [
        'index' => 'promo-tags'
    ]]);
    Route::get('promo-tags/search/{name?}', 'PromotionTagController@search')->name('promo-tags.search');
    Route::post('promo-tags/set-primary/{id?}', 'PromotionTagController@setPrimary')->name('promo-tags.setprimary');

    //promo days
    Route::resource('promodays', 'PromotionDayController', ['names' => [
        'index' => 'promodays'
    ]]);

    Route::resource('promo-outlets', 'PromotionOutletsController', ['names' => [
        'index' => 'promo-outlets'
    ]]);

    Route::resource('promo-category', 'PromotionCategoryController', ['names' => [
        'index' => 'promo-category'
    ]]);
    Route::post('promo-category/set-primary/{id?}', 'PromotionCategoryController@setPrimary')->name('promo-category.setprimary');

    Route::post('promo-outlets/updateOutlates', 'PromotionOutletsController@updateOutlate')->name('promo.update.outlate');
    Route::post('promo-outlets-day/storepromOutlates', 'PromotionOutletsController@storePromOutlate')->name('promo.outlate.store');
    Route::delete('promo-outlets-day/deleteProOutDay/{id?}', 'PromotionOutletsController@deleteProOutDay')->name('promo.outlate.day.destroy');

    Route::post('promo-outlets-time/storepromOutlatesTime', 'PromotionOutletsController@storePromOutlateTime')->name('promo.outlate.time.store');
    Route::delete('promo-outlets-time/deleteProOutTime/{id?}', 'PromotionOutletsController@deleteProOutTime')->name('promo.outlate.time.destroy');

    Route::resource('promo-outlets-days', 'PromotionOutletsDaysController', ['names' => [
        'index' => 'promo-outlets-days'
    ]]);

    //promo tags
    Route::resource('time-tags', 'TimeTagController', ['names' => [
        'index' => 'time-tags'
    ]]);
    Route::get('timetag', 'TimeTagController@timeTags')->name('timetag.tags');
    Route::post('time-tags/tags/store', 'TimeTagController@timeTagStore')->name('time-tags.tags.store');
    Route::delete('time-tags/tags/destroy/{id?}', 'TimeTagController@timeTagDestroy')->name('timetags.tags.destroy');

    Route::get('timetaggroup', 'TimeTagController@timeTagsGrouping')->name('timetag.tags.group');
    Route::post('timetaggroup/store', 'TimeTagController@timeTagGroupingStore')->name('timetaggroup.tags.store');
    Route::delete('timetaggroup/destroy/{id?}', 'TimeTagController@timeTagGroupingDestroy')->name('timetags.tags.destroy');


    //Preference tags
    Route::resource('preference-tags', 'PreferenceMasterController', ['names' => [
        'index' => 'preference-tags'
    ]]);

    //Promotion Prefernece
    Route::post('promotion-preference/store', 'PreferenceMasterController@promotionPreferenceStore')->name('promotion.preference.store');
    Route::delete('promotion-preference/destroy/{id?}', 'PreferenceMasterController@promotionPreferenceDestroy')->name('promotion.preference.destroy');
    Route::post('promotion-preference/set-primary/{id?}', 'PreferenceMasterController@setPrimary')->name('promotion.preference.setprimary');

    //Discount tags
    Route::resource('discount-tags', 'DiscountController', ['names' => [
        'index' => 'discount-tags'
    ]]);
    Route::get('tag/search/{name?}', 'DiscountController@search')->name('tag.search');
    Route::post('tag/uploadimage', 'DiscountController@uploadimage')->name('tag.uploadimage');
    Route::post('tag/deleteimage/{id}', 'DiscountController@deleteimage')->name('tag.deleteimage');

    //Category tags
    Route::resource('category-tags', 'CategoryController', ['names' => [
        'index' => 'category-tags'
    ]]);
    Route::get('tags/search/{name?}', 'CategoryController@search')->name('category.tag.search');
    Route::post('tags/uploadimage', 'CategoryController@uploadimage')->name('category.tag.uploadimage');
    Route::post('tags/deleteimage/{id}', 'CategoryController@deleteimage')->name('category.tag.deleteimage');

});
