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
    Route::post('malls/logodeleteimage/{id}', 'MallController@logodeleteimage')->name('malls.logodeleteimage');
    Route::post('malls/deletemallimage/{id}', 'MallController@deletemallimage')->name('malls.deletemallimage');
    Route::get('malls/level/{id}', 'MallController@mallLevel')->name('malls.level');
    Route::post('malls/level/', 'MallController@storeMallLevel')->name('malls.storeMallLevel');
    Route::delete('malls/level/delete/{id}', 'MallController@mallLevelDestroy')->name('malls.level.destroy');



    Route::get('mall-merchant/info/{id}', 'MallController@mallMerchantInfo')->name('mall.merchant.info');
    Route::post('malls/getCityMall', 'MallController@getCityMall')->name('malls.getcitymall');
    Route::post('malls/getTownMall', 'MallController@getTownMall')->name('malls.gettownmall');

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
    Route::post('merchants-list/deletelogoimage/{id}', 'MerchantController@deletelogoimage')->name('merchants.deletelogoimage');


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
    Route::post('locations/uploadimage', 'LocationController@uploadimage')->name('locations.uploadimage');
    Route::post('locations/deleteimage/{id}', 'LocationController@deleteimage')->name('locations.deleteimage');

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

    Route::get('preference-tags/search/{name?}', 'PreferenceMasterController@search')->name('preference.tag.search');
    Route::post('preference-tags/uploadimage', 'PreferenceMasterController@uploadimage')->name('preference.tag.uploadimage');
    Route::post('preference-tags/deleteimage/{id}', 'PreferenceMasterController@deleteimage')->name('preference.tag.deleteimage');

    //Promotion Prefernece
    Route::post('promotion-preference/store', 'PreferenceMasterController@promotionPreferenceStore')->name('promotion.preference.store');
    Route::delete('promotion-preference/destroy/{id?}', 'PreferenceMasterController@promotionPreferenceDestroy')->name('promotion.preference.destroy');
    Route::post('promotion-preference/set-primary/{id?}', 'PreferenceMasterController@setPrimary')->name('promotion.preference.setprimary');

    //Promotion Age Group
    Route::post('promotion-age-group/store', 'ManageAgeController@promotionAgeStore')->name('promotion.agegroup.store');
    Route::delete('promotion-age-group/destroy/{id?}', 'ManageAgeController@promotionAgeDestroy')->name('promotion.agegroup.destroy');
    Route::post('promotion-age-group/set-primary/{id?}', 'ManageAgeController@setPrimary')->name('promotion.agegroup.setprimary');

    //Promotion Meal Group
    Route::post('promotion-meal-group/store', 'MealgroupController@promotionMealStore')->name('promotion.mealgroup.store');
    Route::delete('promotion-meal-group/destroy/{id?}', 'MealgroupController@promotionMealDestroy')->name('promotion.mealgroup.destroy');
    Route::post('promotion-meal-group/set-primary/{id?}', 'MealgroupController@setPrimary')->name('promotion.mealgroup.setprimary');

    //Discount tags
    Route::resource('discount-tags', 'DiscountController', ['names' => [
        'index' => 'discount-tags'
    ]]);
    Route::get('tag/search/{name?}', 'DiscountController@search')->name('tag.search');
    Route::post('tag/uploadimage', 'DiscountController@uploadimage')->name('tag.uploadimage');
    Route::post('tag/deleteimage/{id}', 'DiscountController@deleteimage')->name('tag.deleteimage');
    Route::post('tag/column-update/{id?}', 'DiscountController@columnUpdate')->name('tag.column-update');

    //Category tags
    Route::resource('category-tags', 'CategoryController', ['names' => [
        'index' => 'category-tags'
    ]]);
    Route::get('tags/search/{name?}', 'CategoryController@search')->name('category.tag.search');
    Route::post('tags/uploadimage', 'CategoryController@uploadimage')->name('category.tag.uploadimage');
    Route::post('tags/deleteimage/{id}', 'CategoryController@deleteimage')->name('category.tag.deleteimage');

    Route::get('category-header', 'CategoryController@categoryHeader')->name('category.header');
    Route::post('category-header/store', 'CategoryController@categoryHeaderStore')->name('category.header.store');
    Route::delete('category-header/delete/{id}', 'CategoryController@categoryHeaderDelete')->name('category.header.delete');

    Route::patch('category-header/update/{id}', 'CategoryController@headerUpdate')->name('category.header.update');
    Route::get('category-header/search/{name?}', 'CategoryController@headerSearch')->name('category.header.search');
    Route::post('category-header/uploadimage', 'CategoryController@headerUploadimage')->name('category.header.uploadimage');
    Route::post('category-header/deleteimage/{id}', 'CategoryController@headerDeleteimage')->name('category.header.deleteimage');


    Route::get('manage/inquiry', 'EnquiryController@getInquiry')->name('manage.inquiry');
    Route::get('manage/shoppers', 'ShopperController@getShoppers')->name('manage.shoppers');
    Route::get('manage/editshoppers/{id}', 'ShopperController@editShoppers')->name('manage.edit.shoppers');
    Route::patch('manage/updateshoppers/{id}', 'ShopperController@updateShoppers')->name('manage.update.shoppers');
    Route::post('shopper/uploadimage', 'ShopperController@uploadimage')->name('shopper.image.uploadimage');
    Route::post('shopper/deleteimage/{id}', 'ShopperController@deleteimage')->name('shopper.image.deleteimage');
    Route::delete('shopper/delete/{id}', 'ShopperController@destroy')->name('shopper.delete');

    //Mall Events
    Route::resource('mall-events', 'EventController', ['names' => [
        'index' => 'mall-events'
    ]]);
    Route::post('events/column-update/{id?}', 'EventController@columnUpdate')->name('events.column-update');
    Route::post('events/uploadimage', 'EventController@uploadimage')->name('events.uploadimage');
    Route::post('events/deleteimage/{id}', 'EventController@deleteimage')->name('events.deleteimage');

    //Mall Offes
    Route::resource('mall-offers', 'OfferController', ['names' => [
        'index' => 'mall-offers'
    ]]);
    Route::post('offers/column-update/{id?}', 'OfferController@columnUpdate')->name('offers.column-update');
    Route::post('offers/uploadimage', 'OfferController@uploadimage')->name('offers.uploadimage');
    Route::post('offers/deleteimage/{id}', 'OfferController@deleteimage')->name('offers.deleteimage');

    Route::resource('mall-parking', 'ParkingController', ['names' => [
        'index' => 'mall-parking'
    ]]);
    Route::post('parking/uploadimage', 'ParkingController@uploadimage')->name('parking.uploadimage');
    Route::post('parking/deleteimage/{id}', 'ParkingController@deleteimage')->name('parking.deleteimage');

    Route::resource('mall-type', 'MallTypeController', ['names' => [
        'index' => 'mall-type'
    ]]);
    Route::post('malltype/uploadimage', 'MallTypeController@uploadimage')->name('malltype.uploadimage');
    Route::post('malltype/deleteimage/{id}', 'MallTypeController@deleteimage')->name('malltype.deleteimage');

    Route::resource('merchant-type', 'MerchantTypeController', ['names' => [
        'index' => 'merchant-type'
    ]]);
    Route::post('merchant-type/uploadimage', 'MerchantTypeController@uploadimage')->name('merchanttype.uploadimage');
    Route::post('merchant-type/deleteimage/{id}', 'MerchantTypeController@deleteimage')->name('merchanttype.deleteimage');

    Route::resource('country', 'CountryController', ['names' => [
        'index' => 'country'
    ]]);
    Route::resource('city', 'CityController', ['names' => [
        'index' => 'city'
    ]]);
    Route::resource('town', 'TownController', ['names' => [
        'index' => 'town'
    ]]);
    Route::resource('merchant-contact', 'MerchantContactController', ['names' => [
        'index' => 'merchant-contact'
    ]]);

    Route::resource('mall-owner', 'MallOwnerController', ['names' => [
        'index' => 'mall-owner'
    ]]);
    Route::get('mall-owner/search/{name?}', 'MallOwnerController@search')->name('mall-owner.search');

    Route::resource('level', 'LevelController', ['names' => [
        'index' => 'level'
    ]]);
    Route::post('level/uploadimage', 'LevelController@uploadimage')->name('level.uploadimage');
    Route::post('level/deleteimage/{id}', 'LevelController@deleteimage')->name('level.deleteimage');


    Route::resource('merchant-company', 'MerchantCompanyController', ['names' => [
        'index' => 'merchant-company'
    ]]);
    Route::get('merchant-company/search/{name?}', 'MerchantCompanyController@search')->name('merchant-company.search');

    Route::resource('manage-age', 'ManageAgeController', ['names' => [
        'index' => 'manage-age'
    ]]);
    Route::post('manage-age/uploadimage', 'ManageAgeController@uploadimage')->name('manageage.uploadimage');
    Route::post('manage-age/deleteimage/{id}', 'ManageAgeController@deleteimage')->name('manageage.deleteimage');

    Route::resource('meal-group', 'MealgroupController', ['names' => [
        'index' => 'meal-group'
    ]]);
    Route::post('meal-group/uploadimage', 'MealgroupController@uploadimage')->name('mealgroup.uploadimage');
    Route::post('meal-group/deleteimage/{id}', 'MealgroupController@deleteimage')->name('mealgroup.deleteimage');
});
