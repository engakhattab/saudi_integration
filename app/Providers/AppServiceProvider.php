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
    View::share('generatorPNG', $generatorPNG);
    
    try {
        // Only share these if the tables exist
        View::share('setting', GeneralSetting::first() ?? new GeneralSetting());
        View::share('contacts', ContactUs::latest()->take(3)->get());
    } catch (\Exception $e) {
        // Tables don't exist yet (during migrations)
        View::share('setting', new GeneralSetting());
        View::share('contacts', []);
    }





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
