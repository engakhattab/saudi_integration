<?php
use Illuminate\Support\Facades\Route;

Route::group(['namespace'=>'Sales\Auth'],function(){

    Route::get('login', 'AuthController@view')->name('login');
    Route::post('login', 'AuthController@login')->name('login');
    Route::get('logout', 'AuthController@logout')->name('logout');
});
