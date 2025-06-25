<?php

namespace App\Providers;

use App\Models\ContactUs;
use App\Models\GeneralSetting;
use Illuminate\Support\ServiceProvider;
use Picqer\Barcode\BarcodeGeneratorPNG;
use View;
use \Illuminate\Support\Facades\DB;
class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        DB::setDefaultConnection('mysql');
        $generatorPNG = new BarcodeGeneratorPNG();
        View::share('generatorPNG',$generatorPNG);
        View::share('setting',GeneralSetting::first());
        View::share('contacts',ContactUs::latest()->take(3)->get());
    }
   private function is_connected()
    {
        $connected = @fsockopen("www.example.com", 80);
        //website, port  (try 80 or 443)
        if ($connected){
            $is_conn = true; //action when connected
            fclose($connected);
        }else{
            $is_conn = false; //action in connection failure
        }
        return $is_conn;

    }
}
