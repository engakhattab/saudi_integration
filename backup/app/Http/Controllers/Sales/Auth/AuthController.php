<?php
namespace App\Http\Controllers\Sales\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Bracelets;
use App\Models\Category;
use App\Models\DiscountReason;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use App\Models\VisitorTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Ifsnop\Mysqldump as IMysqldump;
use App\Classes\Import;
use Illuminate\Support\Facades\Schema;
use mysqli;
use PDO;

class AuthController extends Controller
{
    public function __construct()
    {
        ini_set("max_execution_time", 1000);
        $this->middleware('auth')->only('logout');
    }

    public function view()
    {
        if (auth()->check()) {
            return redirect('/sales');
        }
        return view('sales.auth.login');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {

        $data = $request->validate([
            'user_name' => 'required|exists:users',
            'password' => 'required'
        ]);

        $data['status'] = 1;

        if (auth()->attempt($data)) {
            return response()->json(200);
        }
        return response()->json(405);
    }

    public function logout()
    {
        auth()->logout();
        toastr()->info('logged out successfully');
        return redirect('login');
    }


    public function uploadData(Request $request)
    {
//         if (!$this->is_connected()) {
//             return false;
//         }


//        $dump = new IMysqldump\Mysqldump('mysql:host=2.57.89.1;dbname=u657893346_kidsstation', 'u657893346_kidsstation', 'kidsstation@2022Pass');
         $dump = new IMysqldump\Mysqldump('mysql:host=localhost;dbname=u657893346_kidsstation', 'root', '');//local
        if (file_exists('database/' . date('Y-m-d') . '-u657893346_kidstest.sql')) {
            unlink('database/' . date('Y-m-d') . '-u657893346_kidstest.sql');
        }
        $dump->start('database/' . date('Y-m-d') . '-u657893346_kidstest.sql');

        $dbFile = public_path('database/' . date('Y-m-d') . '-u657893346_kidstest.sql');

        $dropMysqli = new mysqli('2.57.89.1', 'u657893346_kidstest', 'Hyaadodo@1010', 'u657893346_kidstest');//online

        $dropMysqli->query('SET foreign_key_checks = 0');
        if ($result = $dropMysqli->query("SHOW TABLES")) {
            while ($row = $result->fetch_array(MYSQLI_NUM)) {
                $dropMysqli->query('DROP TABLE IF EXISTS `' . $row[0] . '`');
            }
        }
        $dropMysqli->query('SET foreign_key_checks = 1');
        $dropMysqli->close();
        new Import($dbFile, 'u657893346_kidstest', 'Hyaadodo@1010', 'u657893346_kidstest', '2.57.89.1');//online

        DB::purge('online');
        DB::setDefaultConnection('mysql');

        return response()->json(['status' => 200]);


    }//end fun

    private function is_connected()
    {
        $connected = @fsockopen("www.example.com", 80);

        if ($connected) {
            $is_conn = true;
            fclose($connected);
        } else {
            $is_conn = false;
        }
        return $is_conn;

    }

    //===================================================================================================================

    //public function naserCity(Request $request){
        //DB: u657893346_nasrcity
        //username: u657893346_nasrcity
        //password: Nasrcity@123

        //.env

        /*
         *
           DB_CONNECTION=offline
           DB_ONLINE_HOST=2.57.89.1
           DB_ONLINE_PORT=3306
           DB_ONLINE_DATABASE=u657893346_nasrcity
           DB_ONLINE_USERNAME=u657893346_nasrcity
           DB_ONLINE_PASSWORD=Nasrcity@123
         */

        /*
         *
         //start database online to sync offline
        'online' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_ONLINE_HOST', '2.57.89.1'),
            'port' => env('DB_ONLINE_PORT', '3306'),
            'database' => env('DB_ONLINE_DATABASE', 'u657893346_nasrcity'),
            'username' => env('DB_ONLINE_USERNAME', 'u657893346_nasrcity'),
            'password' => env('DB_ONLINE_PASSWORD', 'Nasrcity@123'),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => false,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
            'dump' => [
                'dump_binary_path' => 'D:\server\mysql\bin\\', // only the path, so without `mysqldump` or `pg_dump`
                'use_single_transaction',
                'timeout' => 60 * 5, // 5 minute timeout
            ],
        ],

        //end database online sync offline
         */

//        $dump = new IMysqldump\Mysqldump('mysql:host=localhost;dbname=nasrcity', 'root', '');//local
//        if (file_exists('database/' . date('Y-m-d') . '-u657893346_nasrcity.sql')) {
//            unlink('database/' . date('Y-m-d') . '-u657893346_nasrcity.sql');
//        }
//        $dump->start('database/' . date('Y-m-d') . '-u657893346_nasrcity.sql');
//
//        $dbFile = public_path('database/' . date('Y-m-d') . '-u657893346_nasrcity.sql');
//
//
//        $dropMysqli = new mysqli('2.57.89.1', 'u657893346_nasrcity', 'Nasrcity@123', 'u657893346_nasrcity');//online
//
//        $dropMysqli->query('SET foreign_key_checks = 0');
//        if ($result = $dropMysqli->query("SHOW TABLES")) {
//            while ($row = $result->fetch_array(MYSQLI_NUM)) {
//                $dropMysqli->query('DROP TABLE IF EXISTS `' . $row[0] . '`');
//            }
//        }
//        $dropMysqli->query('SET foreign_key_checks = 1');
//        $dropMysqli->close();
//        new Import($dbFile, 'u657893346_nasrcity', 'Nasrcity@123', 'u657893346_nasrcity', '2.57.89.1');//online
//
//        DB::purge('online');
//        DB::setDefaultConnection('mysql');
//
//        return response()->json(['status' => 200]);


   // }
}



