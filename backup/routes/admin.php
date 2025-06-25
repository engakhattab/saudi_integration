<?php

use Illuminate\Support\Facades\Route;




Route::group(['prefix'=>'admin','middleware'=>'auth:admin','namespace'=>'Admin'],function (){

    Route::get('/','HomeController@index')->name('adminHome');


    #### Admins ####
    Route::resource('admins','AdminController');
    Route::POST('admins.delete','AdminController@delete')->name('admins.delete');
    Route::get('my_profile','AdminController@myProfile')->name('myProfile');

    #### Categories ####
    Route::resource('category','CategoryController');
    Route::POST('category.delete','CategoryController@delete')->name('category.delete');

    #### Coupons ####
    Route::resource('coupons','CouponController');
    Route::POST('coupon.delete','CouponController@delete')->name('coupon.delete');

    #### couponsVisitors ####
    Route::GET('couponsVisitors/{id}','CouponController@show')->name('couponsVisitors');
    Route::GET('AddCouponsVisitor/{id}','CouponController@AddCouponsVisitor')->name('AddCouponsVisitor');
    Route::GET('EditCouponsVisitor/{id}','CouponController@EditCouponsVisitor')->name('EditCouponsVisitor');
    Route::GET('printCoupon/{id}','CouponController@print')->name('printCoupon');
    Route::POST('couponsVisitor.store','CouponController@storeCouponsVisitor')->name('couponsVisitor.store');
    Route::POST('couponsVisitor.update','CouponController@updateCouponsVisitor')->name('couponsVisitor.update');
    Route::POST('couponsVisitors.delete','CouponController@deleteVisitor')->name('couponsVisitors.delete');


    #### Products ####
    Route::resource('product','ProductController');
    Route::POST('product.delete','ProductController@delete')->name('product.delete');

    #### Bracelets ####
    Route::resource('bracelet','BraceletsController');
    Route::POST('bracelet.delete','BraceletsController@delete')->name('bracelet.delete');

    #### Discount ####
    Route::resource('discount','DiscountController');
    Route::POST('discount.delete','DiscountController@delete')->name('discount.delete');


    #### References ####
    Route::resource('reference','RefernceController');
    Route::POST('reference.delete','RefernceController@delete')->name('reference.delete');

    #### Timing ####
    Route::resource('timing','TimingController');
    Route::POST('timing.delete','TimingController@delete')->name('timing.delete');

    #### Timing ####
    Route::resource('visitors','VisitorsController');
    Route::POST('visitors.delete','VisitorsController@delete')->name('visitors.delete');

    #### Users ####
    Route::resource('users','UsersController');
    Route::POST('users.delete','UsersController@delete')->name('users.delete');

    #### Roles ####
    Route::resource('roles','RoleController');
    Route::POST('role.delete','RoleController@delete')->name('roles.delete');

    #### Capacity ####
    Route::resource('capacities','CapacityController');
    Route::POST('capacities.delete','CapacityController@delete')->name('capacities.delete');

    #### Clients ####
    Route::resource('clients','ClientsController');
    Route::POST('client.delete','ClientsController@delete')->name('client.delete');

    #### Sliders ####
    Route::resource('sliders','SlidersController');
    Route::POST('slider.delete','SlidersController@delete')->name('slider.delete');

    #### About Us ####
    Route::resource('about_us','AboutUsController');
    Route::POST('about_us.delete','AboutUsController@delete')->name('about_us.delete');

    #### Activities ####
    Route::resource('activity','ActivityController');
    Route::POST('activity.delete','ActivityController@delete')->name('activity.delete');

    #### Offers ####
    Route::resource('offers','OfferController');
    Route::POST('offer.delete','OfferController@delete')->name('offer.delete');

    #### Offers Items ####
    Route::resource('items','OfferItemsController');
    Route::POST('items.delete','OfferItemsController@delete')->name('items.delete');


    #### Contact Us ####
    Route::resource('contact_us','ContactUsController');
    Route::POST('contact_us.delete','ContactUsController@delete')->name('contact_us.delete');
    Route::POST('read_message','ContactUsController@read_message')->name('read_message');
    Route::get('getCount','ContactUsController@getCount')->name('getCount');


    #### Setting ####
    Route::get('general_setting','SettingController@index')->name('general_setting.index');
    Route::POST('edit_setting','SettingController@edit')->name('admin.edit.setting');
    Route::get('getLogo','SettingController@getLogo')->name('getLogo');

    ### Group ####
    Route::resource('group','GroupController');
    Route::POST('group-delete','GroupController@destroy')->name('group.delete');


    ### Sales ####
    Route::get('sales','SaleController@index')->name('sales.index');
    Route::get('sales/cancel','SaleController@cancel')->name('admin.sales.cancel');//???????????????
    Route::post('sales/cancelUpdateMethod','SaleController@cancelUpdateMethod')->name('admin.sales.cancelUpdateMethod');//???????????????

    Route::get('detailsOfTicket/{id}','SaleController@detailsOfTicket')->name('detailsOfTicket');
    Route::get('detailsOfReservation/{id}','SaleController@detailsOfReservation')->name('detailsOfReservation');
    Route::get('reservationSale','SaleController@reservationSale')->name('reservationSale');//??????????????
    Route::get('productSales','SaleController@productSales')->name('productSales');
    Route::get('totalCashierSales','SaleController@totalCashierSales')->name('totalCashierSales');//??????????????????
    Route::get('totalProductsSales','SaleController@totalProductsSales')->name('totalProductsSales');
    Route::get('discountReport','SaleController@discountReport')->name('discountReport');
    Route::get('reservationReport','SaleController@discountReservationsReport')->name('reservationReport');
    Route::get('attendanceReport','SaleController@attendanceReport')->name('attendanceReport');


    #### Auth ####
    Route::get('logout', 'AuthController@logout')->name('admin.logout');


    /////////////////////////// prices slider /////////////////////////////////
    Route::resource('pricesSlider','PricesSliderController');
    Route::POST('pricesSlider-delete','PricesSliderController@delete')->name('pricesSlider.delete');

    /////////////////////////// Obstacle Courses /////////////////////////////////
    Route::resource('obstacleCourses','ObstacleCoursesController');
    Route::POST('obstacleCourses-delete','ObstacleCoursesController@delete')->name('obstacleCourses.delete');


    //////////////////   elsdodey /////////////////////

    Route::get('get/cashierAndPayment','UsersController@getCashierByPayment')->name('admin.getCashierByPayment');

});

Route::group(['prefix'=>'admin','namespace'=>'Admin'],function (){

    Route::get('login', 'AuthController@index')->name('admin.login');
    Route::POST('login', 'AuthController@login')->name('admin.login');
});






