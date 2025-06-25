<?php

use Illuminate\Support\Facades\Route;

    //==================================== Family ================================
    Route::resource('client', 'ClientController');
    Route::get('client-search', 'ClientController@search')->name('client.search');

    // Ticket
    Route::resource('ticket', 'TicketController');
    Route::get('printInvoice/{id}', 'TicketController@printInvoice')->name('printInvoice');
    Route::get('checkChange', 'TicketController@checkChange')->name('checkChange');
    Route::get('tickets', 'TicketController@search')->name('ticket.search');
    Route::get('searchForTickets', 'TicketController@searchForTicket')->name('searchForTickets');
    Route::get('detailsTicket/{id}', 'TicketController@details')->name('detailsTicket');
    Route::get('updateTicket/{id}', 'TicketController@updateTicket')->name('updateTicket');
    Route::get('edit_ticket/{id}', 'TicketController@editTicket')->name('edit_ticket');
    Route::post('editTicketInfo', 'TicketController@editTicketInfo')->name('editTicketInfo');
    Route::POST('restoreTicket', 'TicketController@restoreTicket')->name('restoreTicket');
    Route::POST('storeModels', 'TicketController@storeModels')->name('storeModels');
    Route::POST('delete_ticket', 'TicketController@delete_ticket')->name('delete_ticket');
    Route::POST('storeRevTicket', 'ReservationController@storeRevTicket')->name('storeRevTicket');
    Route::get('familyClients', 'FamilyClientController@index')->name('familyClient.index');
    Route::post('rateClient', 'FamilyClientController@rateClient')->name('rateClient');

#### Reservation ####
    Route::get('searchForReservations', 'ReservationController@searchForReservations')->name('searchForReservations');
    Route::get('update_reservation/{id}', 'ReservationController@update')->name('updateReservation');
    Route::POST('delete_reservation', 'ReservationController@delete_reservation')->name('delete_reservation');
    Route::POST('postUpdateReservation', 'ReservationController@postUpdateReservation')->name('postUpdateReservation');
    Route::POST('update_reservation', 'ReservationController@update_reservation')->name('update_reservation');
    Route::get('editReservation/{id}', 'ReservationController@editReservation')->name('editReservation');
    Route::get('detailsReservation/{id}', 'ReservationController@detailsReservation')->name('detailsReservation');

#### Coupons ####
    Route::get('sales/coupons','CouponController@index')->name('sales.coupons');
    Route::post('sales.coupons.store','CouponController@store')->name('sales.store.coupon');
    Route::get('sales.coupons.edit/{id}','CouponController@edit')->name('sales.coupons.edit');
    Route::post('sales.coupons.update','CouponController@update')->name('sales.coupons.update');
    Route::POST('sales.coupon.delete','CouponController@delete')->name('sales.delete_coupon');
    #### couponsVisitors ####
    Route::GET('sales/couponsVisitors/{id}','CouponController@show')->name('sales.couponsVisitors');
    Route::GET('sales.AddCouponsVisitor/{id}','CouponController@AddCouponsVisitor')->name('sales.AddCouponsVisitor');
    Route::GET('sales.EditCouponsVisitor/{id}','CouponController@EditCouponsVisitor')->name('sales.EditCouponsVisitor');
    Route::GET('sales.printCoupon/{id}','CouponController@print')->name('printCoupon');
    Route::POST('sales.couponsVisitor.store','CouponController@storeCouponsVisitor')->name('sales.couponsVisitor.store');
    Route::POST('sales.couponsVisitor.update','CouponController@updateCouponsVisitor')->name('sales.couponsVisitor.update');
    Route::POST('sales.couponsVisitors.delete','CouponController@deleteVisitor')->name('sales.couponsVisitors.delete');

//==================================== Group ================================
    Route::resource('familyAccess', 'FamilyAccessController');//.......
    Route::POST('updateAmount', 'FamilyAccessController@updateAmount')->name('ticket.updateAmount');


//==================================== Group ================================
    Route::resource('reservations', 'ReservationController');
    Route::get('printRev/{id}', 'ReservationController@printRev')->name('printRev');
    Route::resource('capacity', 'CapacityController');
    Route::resource('groupAccess', 'GroupAccessController');
    Route::get('groupAccess-checkIfBraceletFree', 'GroupAccessController@checkIfBraceletFree')->name('groupAccess.checkIfBraceletFree');
    Route::get('capacity-anotherMonth', 'CapacityController@anotherMonth')->name('capacity.anotherMonth.index');
    Route::POST('getBracelets', 'GroupAccessController@getBracelets')->name('capacity.getBracelets');
    Route::POST('updateRevAmount', 'GroupAccessController@updateRevAmount')->name('updateRevAmount');


#################################### Exit =======================================
    Route::resource('exit', 'ExitController');
    Route::get('exit-{search}', 'ExitController@all')->name('exit-all');
    Route::put('topDown/{id}', 'ExitController@topDown')->name('topDown');
    Route::get('showTopDown/{id}', 'ExitController@showTopDown')->name('showTopDown');



//    ############################ print  /////////////////////////////////
//        Route::get('reservations')
