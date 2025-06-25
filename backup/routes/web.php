<?php

use Illuminate\Support\Facades\Route;

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


Route::get('/', 'Site\HomeController@index')->name('/')->middleware('auth:admin');
Route::get('offer_details/{id}', 'Site\HomeController@offerDetails')->name('offer_details');

// safety
Route::get('safety', 'Site\HomeController@safety')->name('safety');
Route::get('cities/{id}', 'Site\HomeController@cities');//?????


## About
Route::get('about_us', 'Site\HomeController@about')->name('about_us');

## Terms
Route::get('terms', 'Site\HomeController@terms')->name('terms');
Route::view('privacy', 'site.privacy')->name('privacy');
Route::view('refund-policy', 'site.refund_privacy')->name('refund-policy');

## Groups
Route::get('groups', 'Site\HomeController@groups')->name('groups');

## ExistAll
Route::get('ExistAllPeople', 'Site\HomeController@ExistAllPeople')->name('ExistAllPeople');
Route::get('ExistAllTicketRev', 'Sales\TicketController@ExistAllTicketRev')->name('ExistAllTicketRev');


## Activities
Route::get('activities', 'Site\HomeController@activities')->name('activities');

## Contact
Route::get('contact_us', 'Site\HomeController@contact')->name('contact_us');
Route::post('storeContact', 'Site\HomeController@storeContact')->name('storeContact');


#### create Capacity 33333
Route::get('createCapacity', 'Site\CapacityController@createCapacity')->name('createCapacity');
Route::POST('storeTicket', 'Site\CapacityController@storeTicket')->name('storeTicket');

Route::get('/clear/route', function (){
    \Artisan::call('optimize:clear');
//    \Artisan::call('config:cache');

    return 'done';
});


require __DIR__.'/sales/auth.php';


Route::group(['middleware'=>'auth','namespace'=>'Sales'],function(){



//================================ Home ====================================
    Route::get('/sales','HomeController@index')->name('sales');

    require __DIR__.'/sales/CRUD.php';

});
Route::group(['namespace'=>'Sales'],function(){

    //=========================== visitor Types Prices ============================
    Route::get('visitorTypesPrices','VisitorTypesPricesController@visitorTypesPrices')->name('visitorTypesPrices');

});

/////////////////////// un auth ////////
Route::get('getShifts', 'Sales\TicketController@getShifts')->name('getShifts');
Route::get('calcCapacity', 'Sales\TicketController@calcCapacity')->name('calcCapacity');
Route::get('getProductsPrices', 'Sales\TicketController@getProductsPrices')->name('getProductsPrices');
Route::get('printTicket/{id}','Sales\TicketController@edit')->name('printTicket');

//================================ Admin Dashboard ====================================
require __DIR__.'/admin.php';



//Route::get('/mySal',function(){
//    $dir_1 = public_path() . '/databases/table-u657893346_kidstest.sql';
//   return exec("mysqldump --user=u657893346_kidstest --password=Hyaadodo@1010 --host=localhost u657893346_kidstest --result-file={$dir_1} 2>&1", $output_1);
//});


//Route::get('uploadData',[\App\Http\Controllers\Sales\Auth\AuthController::class,'uploadData']);

Route::post('changeDbConnection', 'Sales\Auth\AuthController@uploadData')->name('changeDbConnection');
//Route::get('forceupdate', 'Sales\Auth\AuthController@uploadData')->name('forceupdate');


//Route::get('/mySal',function(){
//    $dir_1 = public_path() . '/table-skypark.sql';
//    return exec("mysqldump --user=u657893346_skyparkunittes --password=Hyaadodo@1010 --host=45.84.204.1 u657893346_skyparkunittes --result-file={$dir_1} 2>&1", $output_1);
//});

Route::post('changeDbConnection', 'Sales\Auth\AuthController@uploadData')->name('changeDbConnection');
//Route::get('forceupdate', 'Sales\Auth\AuthController@uploadData')->name('forceupdate');


//Route::get('/mySal',function(){
//    $dir_1 = public_path() . '/table-skypark.sql';
//    return exec("mysqldump --user=u657893346_skyparkunittes --password=Hyaadodo@1010 --host=45.84.204.1 u657893346_skyparkunittes --result-file={$dir_1} 2>&1", $output_1);
//});

Route::get('/ResetTicketUpdate', function () {
    $carbon = \Carbon\Carbon::now()->format('h:i A');

    //? get all children Tickets pluck them for Array
    $children_ids = \App\Models\TicketRevModel::query()->where('status', '=', 'in')->pluck('id');

    //? Get All Tickets and update status for [out] tickets
    foreach ($children_ids as $id) {
        \App\Models\TicketRevModel::query()->where('id', '=', $id)
            ->whereDay('day', '<', Carbon\Carbon::now())
            ->update([
                'status' => 'out',
            ]);
    } // end foreach

    return 'Success Out All Tickets Before Day :  ' . \Carbon\Carbon::now()->format('Y-m-d');

})->name('ResetTicketUpdate');
