<?php

//
//namespace App\Http\Controllers\Sales\Auth;
//
//use App\Http\Controllers\Controller;
//use App\Models\Admin;
//use App\Models\Bracelets;
//use App\Models\Category;
//use App\Models\DiscountReason;
//use App\Models\Payment;
//use App\Models\Product;
//use App\Models\User;
//use App\Models\VisitorTypes;
//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\File;
//use Illuminate\Support\Facades\Hash;
//use Ifsnop\Mysqldump as IMysqldump;
//use App\Classes\Import;
//use mysqli;
//
//class AuthController extends Controller
//{
//    public function __construct()
//    {
//        //99999999999
//        ini_set("max_execution_time", 1000);
//        $this->middleware('auth')->only('logout');
//    }
//
//    public function view()
//    {
//        if (auth()->check()) {
//            return redirect('/sales');
//        }
//        return view('sales.auth.login');
//    }//end fun
//
//    /**
//     * @param Request $request
//     * @return \Illuminate\Http\JsonResponse
//     */
//    public function login(Request $request)
//    {
//
//        $data = $request->validate([
//            'user_name' => 'required|exists:users',
//            'password' => 'required'
//        ]);
//
//
//        if (auth()->attempt($data)) {
//            return response()->json(200);
//        }
//        return response()->json(405);
//    }//end fun
//
//    public function logout()
//    {
//        auth()->logout();
//        toastr()->info('logged out successfully');
//        return redirect('login');
//    }//end fun
//
//
//    public function uploadData(Request $request)
//    {
////         if (!$this->is_connected()) {
////             return false;
////         }
//
//
//        $clients = \App\Models\Clients::get();
//        $tickets = \App\Models\Ticket::get();
//        $reservations = \App\Models\Reservations::get();
//        $discount_reasons = \App\Models\DiscountReason::get();
//// //        $bracelets = \App\Models\Bracelets::where('uploaded', false)->get();
//        $products = \App\Models\Product::get();
//        $payments = \App\Models\Payment::get();
//        $users = \App\Models\User::get();
//        $admins = \App\Models\Admin::get();
//        $categories = \App\Models\Category::get();
//        $visitors = \App\Models\VisitorTypes::get();
//
//
////        $clients = \App\Models\Clients::where('uploaded', false)->get();
////        $tickets = \App\Models\Ticket::where('uploaded', false)->with('models', 'products')->get();
////        $reservations = \App\Models\Reservations::where('uploaded', false)->with('models', 'products')->get();
////        $discount_reasons = \App\Models\DiscountReason::where('uploaded', false)->get();
////// //        $bracelets = \App\Models\Bracelets::where('uploaded', false)->get();
////        $products = \App\Models\Product::where('uploaded', false)->get();
////        $payments = \App\Models\Payment::where('uploaded', false)->get();
////        $users = \App\Models\User::get();
////        $admins = \App\Models\Admin::where('uploaded', false)->get();
////        $categories = \App\Models\Category::where('uploaded', false)->get();
////        $visitors = \App\Models\VisitorTypes::where('uploaded', false)->get();
//
//
//        \App\Models\Clients::where('uploaded', false)->update(['uploaded' => true]);
//        \App\Models\Ticket::where('uploaded', false)->update(['uploaded' => true]);
//        \App\Models\Reservations::where('uploaded', false)->update(['uploaded' => true]);
//        DiscountReason::where('uploaded', false)->update(['uploaded' => true]);
////                Bracelets::where('uploaded', false)->update(['uploaded' => true]);
//        Product::where('uploaded', false)->update(['uploaded' => true]);
//        Payment::where('uploaded', false)->update(['uploaded' => true]);
//        User::where('uploaded', false)->update(['uploaded' => true]);
//        Admin::where('uploaded', false)->update(['uploaded' => true]);
//        Category::where('uploaded', false)->update(['uploaded' => true]);
//        VisitorTypes::where('uploaded', false)->update(['uploaded' => true]);
//
//        DB::purge('mysql');
//        DB::setDefaultConnection('online');
//
////        DB::purge('offline');
////        DB::setDefaultConnection('online');
//        foreach ($clients as $client) {
//            $storeClientData = [];
//            $storeClientData['name'] = $client->name;
//            $storeClientData['phone'] = $client->phone;
//            $storeClientData['email'] = $client->email;
//            $storeClientData['gender'] = $client->gender;
//            $storeClientData['rate'] = $client->rate;
//            $storeClientData['note'] = $client->note;
//            $storeClientData['gov_id'] = $client->gov_id;
//            $storeClientData['city_id'] = $client->city_id;
//            $storeClientData['ref_id'] = $client->ref_id;
//            $storeClientData['family_size'] = $client->family_size;
//            $storeClientData['uploaded'] = 1;
//
//            \App\Models\Clients::updateOrCreate(['id' => $client->id], $storeClientData);
//        }
//        foreach ($tickets as $ticket) {
//            $storeTicketData = [];
//            $storeTicketData['add_by'] = $ticket->add_by;
//            $storeTicketData['ticket_num'] = $ticket->ticket_num;
//            $storeTicketData['visit_date'] = $ticket->visit_date;
//            $storeTicketData['shift_id'] = $ticket->shift_id;
//            $storeTicketData['client_id'] = $ticket->client_id;
//            $storeTicketData['hours_count'] = $ticket->hours_count;
//            $storeTicketData['total_price'] = $ticket->total_price;
//            $storeTicketData['total_top_up_hours'] = $ticket->total_top_up_hours;
//            $storeTicketData['total_top_up_price'] = $ticket->total_top_up_price;
//            $storeTicketData['total_top_down_price'] = $ticket->total_top_down_price;
//            $storeTicketData['payment_method'] = $ticket->payment_method;
//            $storeTicketData['payment_status'] = $ticket->payment_status;
//            $storeTicketData['note'] = $ticket->note;
//            $storeTicketData['discount_type'] = $ticket->discount_type;
//            $storeTicketData['discount_value'] = $ticket->discount_value;
//            $storeTicketData['discount_id'] = $ticket->discount_id;
//            $storeTicketData['ticket_price'] = $ticket->ticket_price;
//            $storeTicketData['ent_tax'] = $ticket->ent_tax;
//            $storeTicketData['vat'] = $ticket->vat;
//            $storeTicketData['grand_total'] = $ticket->grand_total;
//            $storeTicketData['paid_amount'] = $ticket->paid_amount;
//            $storeTicketData['rem_amount'] = $ticket->rem_amount;
//            $storeTicketData['status'] = $ticket->status;
//            $storeTicketData['created_at'] = $ticket->created_at;
//            $storeTicketData['updated_at'] = $ticket->updated_at;
//            $storeTicketData['uploaded'] = 1;
//
//            $storeTicket = \App\Models\Ticket::updateOrCreate(['id' => $ticket->id], $storeTicketData);
//
//            foreach ($ticket->models as $model) {
//                $smallModelTicket = [];
//                $smallModelTicket['visitor_type_id'] = $model->visitor_type_id;
//                $smallModelTicket['coupon_num'] = $model->coupon_num;
//                $smallModelTicket['day'] = $model->day;
//                $smallModelTicket['price'] = $model->price;
//                $smallModelTicket['bracelet_id'] = $model->bracelet_id;
//                $smallModelTicket['bracelet_number'] = $model->bracelet_number;
//                $smallModelTicket['name'] = $model->name;
//                $smallModelTicket['birthday'] = $model->birthday;
//                $smallModelTicket['gender'] = $model->gender;
//                $smallModelTicket['status'] = $model->status;
//                $smallModelTicket['top_up_hours'] = $model->top_up_hours;
//                $smallModelTicket['top_up_price'] = $model->top_up_price;
//                $smallModelTicket['start_at'] = $model->start_at;
//                $smallModelTicket['end_at'] = $model->end_at;
//                $smallModelTicket['shift_start'] = $model->shift_start;
//                $smallModelTicket['shift_end'] = $model->shift_end;
//                $smallModelTicket['temp_status'] = $model->temp_status;
//                $storeTicket->models()->updateOrCreate(['id' => $model->id], $smallModelTicket);
//            }
//            foreach ($ticket->products as $product) {
//                $smallProductTicket = [];
//                $smallProductTicket['category_id'] = $product->category_id;
//                $smallProductTicket['product_id'] = $product->product_id;
//                $smallProductTicket['qty'] = $product->qty;
//                $smallProductTicket['price'] = $product->price;
//                $smallProductTicket['total_price'] = $product->total_price;
//                $storeTicket->products()->updateOrCreate(['id' => $product->id], $smallProductTicket);
//            }
//
//        }
//
//        foreach ($reservations as $reservation) {
//            $storeReservationData = [];
//            $storeReservationData['add_by'] = $reservation->add_by;
//            $storeReservationData['ticket_num'] = $reservation->ticket_num;
//            $storeReservationData['custom_id'] = $reservation->custom_id;
//            $storeReservationData['day'] = $reservation->day;
//            $storeReservationData['client_name'] = $reservation->client_name;
//            $storeReservationData['phone'] = $reservation->phone;
//            $storeReservationData['email'] = $reservation->email;
//            $storeReservationData['gender'] = $reservation->gender;
//            $storeReservationData['gov_id'] = $reservation->gov_id;
//            $storeReservationData['city_id'] = $reservation->city_id;
//            $storeReservationData['event_id'] = $reservation->event_id;
//            $storeReservationData['shift_id'] = $reservation->shift_id;
//            $storeReservationData['hours_count'] = $reservation->hours_count;
//            $storeReservationData['total_price'] = $reservation->total_price;
//            $storeReservationData['total_top_up_hours'] = $reservation->total_top_up_hours;
//            $storeReservationData['total_top_up_price'] = $reservation->total_top_up_price;
//            $storeReservationData['total_top_down_price'] = $reservation->total_top_down_price;
//            $storeReservationData['payment_method'] = $reservation->payment_method;
//            $storeReservationData['payment_status'] = $reservation->payment_status;
//            $storeReservationData['note'] = $reservation->note;
//            $storeReservationData['discount_type'] = $reservation->discount_type;
//            $storeReservationData['discount_value'] = $reservation->discount_value;
//            $storeReservationData['discount_id'] = $reservation->discount_id;
//            $storeReservationData['ticket_price'] = $reservation->ticket_price;
//            $storeReservationData['ent_tax'] = $reservation->ent_tax;
//            $storeReservationData['vat'] = $reservation->vat;
//            $storeReservationData['grand_total'] = $reservation->grand_total;
//            $storeReservationData['paid_amount'] = $reservation->paid_amount;
//            $storeReservationData['rem_amount'] = $reservation->rem_amount;
//            $storeReservationData['status'] = $reservation->status;
//            $storeReservationData['is_coupon'] = $reservation->is_coupon;
//            $storeReservationData['coupon_start'] = $reservation->coupon_start;
//            $storeReservationData['coupon_end'] = $reservation->coupon_end;
//            $storeReservationData['uploaded'] = 1;
//
//            $storeReservation = \App\Models\Reservations::updateOrCreate(['id' => $reservation->id], $storeReservationData);
//
//            foreach ($reservation->models as $model) {
//                $smallModelReservation = [];
//                $smallModelReservation['visitor_type_id'] = $model->visitor_type_id;
//                $smallModelReservation['coupon_num'] = $model->coupon_num;
//                $smallModelReservation['day'] = $model->day;
//                $smallModelReservation['price'] = $model->price;
//                $smallModelReservation['bracelet_id'] = $model->bracelet_id;
//                $smallModelReservation['bracelet_number'] = $model->bracelet_number;
//                $smallModelReservation['name'] = $model->name;
//                $smallModelReservation['birthday'] = $model->birthday;
//                $smallModelReservation['gender'] = $model->gender;
//                $smallModelReservation['status'] = $model->status;
//                $smallModelReservation['top_up_hours'] = $model->top_up_hours;
//                $smallModelReservation['top_up_price'] = $model->top_up_price;
//                $smallModelReservation['start_at'] = $model->start_at;
//                $smallModelReservation['end_at'] = $model->end_at;
//                $smallModelReservation['shift_start'] = $model->shift_start;
//                $smallModelReservation['shift_end'] = $model->shift_end;
//                $smallModelReservation['temp_status'] = $model->temp_status;
//                $storeReservation->models()->updateOrCreate(['id' => $model->id], $smallModelReservation);
//            }
//            foreach ($reservation->products as $product) {
//                $smallProductReservation = [];
//                $smallProductReservation['category_id'] = $product->category_id;
//                $smallProductReservation['product_id'] = $product->product_id;
//                $smallProductReservation['qty'] = $product->qty;
//                $smallProductReservation['price'] = $product->price;
//                $smallProductReservation['total_price'] = $product->total_price;
//                $storeReservation->products()->updateOrCreate(['id' => $product->id], $smallProductReservation);
//            }
//
//        }
//
//        foreach ($discount_reasons as $reason) {
//            $storeReasonData = [];
//            $storeReasonData['desc'] = $reason->desc;
//            $storeReasonData['uploaded'] = 1;
//            DiscountReason::updateOrCreate(['id' => $reason->id], $storeReasonData);
//        }
//
//        foreach ($products as $product) {
//            $storeProductData = [];
//            $storeProductData['title'] = $product->title;
//            $storeProductData['category_id'] = $product->category_id;
//            $storeProductData['status'] = $product->status;
//            $storeProductData['vat'] = $product->vat;
//            $storeProductData['price_before_vat'] = $product->price_before_vat;
//            $storeProductData['price'] = $product->price;
//            $storeProductData['uploaded'] = 1;
//            Product::updateOrCreate(['id' => $product->id], $storeProductData);
//        }
//
//        foreach ($payments as $payment) {
//            $storePaymentData = [];
//            $storePaymentData['rev_id'] = $payment->rev_id;
//            $storePaymentData['ticket_id'] = $payment->ticket_id;
//            $storePaymentData['cashier_id'] = $payment->cashier_id;
//            $storePaymentData['payment_method'] = $payment->payment_method;
//            $storePaymentData['day'] = $payment->day;
//            $storePaymentData['amount'] = $payment->amount;
//            $storePaymentData['uploaded'] = 1;
//            Payment::updateOrCreate(['id' => $payment->id], $storePaymentData);
//        }
//
//
//        foreach ($users as $user) {
//
//            $storeUserData = [];
//            $storeUserData['name'] = $user->name;
//            $storeUserData['user_name'] = $user->user_name;
//            $storeUserData['password'] = $user->password;
//            $storeUserData['uploaded'] = 1;
//
//            \App\Models\User::updateOrCreate(['id' => $user->id], $storeUserData);
//        }
//
//
//        foreach ($admins as $admin) {
//
//            $storeAdminData = [];
//            $storeAdminData['name'] = $admin->name;
//            $storeAdminData['password'] = $admin->password;
//            $storeAdminData['email'] = $admin->email;
//            $storeAdminData['uploaded'] = 1;
//            \App\Models\Admin::updateOrCreate(['id' => $admin->id], $storeAdminData);
//        }
//
//
//        foreach ($categories as $category) {
//
//            $storeCategoryData = [];
//            $storeCategoryData['title'] = $category->title;
//            $storeCategoryData['uploaded'] = 1;
//
//
//            \App\Models\Category::updateOrCreate(['id' => $category->id], $storeCategoryData);
//        }
//
//
//        foreach ($visitors as $visitor) {
//
//            $storeVisitorData = [];
//            $storeVisitorData['title'] = $visitor->title;
//            $storeVisitorData['event_id'] = $visitor->event_id;
//            $storeVisitorData['1_hours'] = $visitor['1_hours'];
//            $storeVisitorData['2_hours'] = $visitor['2_hours'];
//            $storeVisitorData['3_hours'] = $visitor['3_hours'];
//            $storeVisitorData['4_hours'] = $visitor['4_hours'];
//            $storeVisitorData['5_hours'] = $visitor['5_hours'];
//            $storeVisitorData['uploaded'] = 1;
//
//
//            \App\Models\VisitorTypes::updateOrCreate(['id' => $visitor->id], $storeVisitorData);
//        }
//
//
////        $dump = new IMysqldump\Mysqldump('mysql:host=2.57.89.1;dbname=u657893346_kidsstation', 'u657893346_kidsstation', 'kidsstation@2022Pass');
//        $dump = new IMysqldump\Mysqldump('mysql:host=2.57.89.1;dbname=u657893346_kidstest', 'u657893346_kidstest', 'Hyaadodo@1010');
//        if (file_exists('database/' . date('Y-m-d') . '-u657893346_kidstest.sql')) {
//            unlink('database/' . date('Y-m-d') . '-u657893346_kidstest.sql');
//        }
//        $dump->start('database/' . date('Y-m-d') . '-u657893346_kidstest.sql');
//
//        $dbFile = public_path('database/' . date('Y-m-d') . '-u657893346_kidstest.sql');
//
//
//        $dropMysqli = new mysqli('localhost', 'root', '', 'u657893346_kidsstation');
//        $dropMysqli->query('SET foreign_key_checks = 0');
//        if ($result = $dropMysqli->query("SHOW TABLES")) {
//            while ($row = $result->fetch_array(MYSQLI_NUM)) {
//                $dropMysqli->query('DROP TABLE IF EXISTS `' . $row[0] . '`');
//            }
//        }
//
//        $dropMysqli->query('SET foreign_key_checks = 1');
//        $dropMysqli->close();
//        new Import($dbFile, 'root', '', 'u657893346_kidsstation', 'localhost');
//        DB::purge('online');
//        DB::setDefaultConnection('mysql');
////        DB::purge('online');
////        DB::setDefaultConnection('offline');
//
//        toastr()->success('تم تحديث قاعده البيانات بنجاح');
//        return redirect()->back();
////        return response()->json(['status' => 200]);
//
//    }//end fun
//
//
//    private function is_connected()
//    {
//        $connected = @fsockopen("www.example.com", 80);
//        //website, port  (try 80 or 443)
//        if ($connected) {
//            $is_conn = true; //action when connected
//            fclose($connected);
//        } else {
//            $is_conn = false; //action in connection failure
//        }
//        return $is_conn;
//
//    }//end fun
//}//end class





// =============================================================================================================================================================


//namespace App\Http\Controllers\Sales\Auth;
//
//use App\Http\Controllers\Controller;
//use App\Models\Admin;
//use App\Models\Bracelets;
//use App\Models\Category;
//use App\Models\DiscountReason;
//use App\Models\Payment;
//use App\Models\Product;
//use App\Models\User;
//use App\Models\VisitorTypes;
//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB;
//use Illuminate\Support\Facades\File;
//use Illuminate\Support\Facades\Hash;
//use Ifsnop\Mysqldump as IMysqldump;
//use App\Classes\Import;
//use mysqli;
//
//class AuthController extends Controller
//{
//    public function __construct()
//    {
//        //99999999999
//        ini_set("max_execution_time", 1000);
//        $this->middleware('auth')->only('logout');
//    }
//
//    public function view()
//    {
//        if (auth()->check()) {
//            return redirect('/sales');
//        }
//        return view('sales.auth.login');
//    }//end fun
//
//    /**
//     * @param Request $request
//     * @return \Illuminate\Http\JsonResponse
//     */
//    public function login(Request $request)
//    {
//
//        $data = $request->validate([
//            'user_name' => 'required|exists:users',
//            'password' => 'required'
//        ]);
//
//
//        if (auth()->attempt($data)) {
//            return response()->json(200);
//        }
//        return response()->json(405);
//    }//end fun
//
//    public function logout()
//    {
//        auth()->logout();
//        toastr()->info('logged out successfully');
//        return redirect('login');
//    }//end fun
//
//
//    public function uploadData(Request $request)
//    {
////         if (!$this->is_connected()) {
////             return false;
////         }
//
//
//        $clients = \App\Models\Clients::where('uploaded', false)->get();
//        $tickets = \App\Models\Ticket::where('uploaded', false)->with('models', 'products')->get();
//        $reservations = \App\Models\Reservations::where('uploaded', false)->with('models', 'products')->get();
//        $discount_reasons = \App\Models\DiscountReason::where('uploaded', false)->get();
//// //        $bracelets = \App\Models\Bracelets::where('uploaded', false)->get();
//        $products = \App\Models\Product::where('uploaded', false)->get();
//        $payments = \App\Models\Payment::where('uploaded', false)->get();
//        $users = \App\Models\User::where('uploaded', false)->get();
//        $admins = \App\Models\Admin::where('uploaded', false)->get();
//        $categories = \App\Models\Category::where('uploaded', false)->get();
//        $visitors = \App\Models\VisitorTypes::where('uploaded', false)->get();
//
//
//        \App\Models\Clients::where('uploaded', false)->update(['uploaded' => true]);
//        \App\Models\Ticket::where('uploaded', false)->update(['uploaded' => true]);
//        \App\Models\Reservations::where('uploaded', false)->update(['uploaded' => true]);
//        DiscountReason::where('uploaded', false)->update(['uploaded' => true]);
////                Bracelets::where('uploaded', false)->update(['uploaded' => true]);
//        Product::where('uploaded', false)->update(['uploaded' => true]);
//        Payment::where('uploaded', false)->update(['uploaded' => true]);
//        User::where('uploaded', false)->update(['uploaded' => true]);
//        Admin::where('uploaded', false)->update(['uploaded' => true]);
//        Category::where('uploaded', false)->update(['uploaded' => true]);
//        VisitorTypes::where('uploaded', false)->update(['uploaded' => true]);
//
//        DB::purge('mysql');
//        DB::setDefaultConnection('online');
//
////        DB::purge('offline');
////        DB::setDefaultConnection('online');
//        foreach ($clients as $client) {
//            $storeClientData = [];
//            $storeClientData['name'] = $client->name;
//            $storeClientData['phone'] = $client->phone;
//            $storeClientData['email'] = $client->email;
//            $storeClientData['gender'] = $client->gender;
//            $storeClientData['rate'] = $client->rate;
//            $storeClientData['note'] = $client->note;
//            $storeClientData['gov_id'] = $client->gov_id;
//            $storeClientData['city_id'] = $client->city_id;
//            $storeClientData['ref_id'] = $client->ref_id;
//            $storeClientData['family_size'] = $client->family_size;
//            $storeClientData['uploaded'] = 1;
//
//            \App\Models\Clients::updateOrCreate($storeClientData);
//        }
//        foreach ($tickets as $ticket) {
//            $storeTicketData = [];
//            $storeTicketData['add_by'] = $ticket->add_by;
//            $storeTicketData['ticket_num'] = $ticket->ticket_num;
//            $storeTicketData['visit_date'] = $ticket->visit_date;
//            $storeTicketData['shift_id'] = $ticket->shift_id;
//            $storeTicketData['client_id'] = $ticket->client_id;
//            $storeTicketData['hours_count'] = $ticket->hours_count;
//            $storeTicketData['total_price'] = $ticket->total_price;
//            $storeTicketData['total_top_up_hours'] = $ticket->total_top_up_hours;
//            $storeTicketData['total_top_up_price'] = $ticket->total_top_up_price;
//            $storeTicketData['total_top_down_price'] = $ticket->total_top_down_price;
//            $storeTicketData['payment_method'] = $ticket->payment_method;
//            $storeTicketData['payment_status'] = $ticket->payment_status;
//            $storeTicketData['note'] = $ticket->note;
//            $storeTicketData['discount_type'] = $ticket->discount_type;
//            $storeTicketData['discount_value'] = $ticket->discount_value;
//            $storeTicketData['discount_id'] = $ticket->discount_id;
//            $storeTicketData['ticket_price'] = $ticket->ticket_price;
//            $storeTicketData['ent_tax'] = $ticket->ent_tax;
//            $storeTicketData['vat'] = $ticket->vat;
//            $storeTicketData['grand_total'] = $ticket->grand_total;
//            $storeTicketData['paid_amount'] = $ticket->paid_amount;
//            $storeTicketData['rem_amount'] = $ticket->rem_amount;
//            $storeTicketData['status'] = $ticket->status;
//            $storeTicketData['created_at'] = $ticket->created_at;
//            $storeTicketData['updated_at'] = $ticket->updated_at;
//            $storeTicketData['uploaded'] = 1;
//
//            $storeTicket = \App\Models\Ticket::updateOrCreate($storeTicketData);
//
//            foreach ($ticket->models as $model) {
//                $smallModelTicket = [];
//                $smallModelTicket['visitor_type_id'] = $model->visitor_type_id;
//                $smallModelTicket['coupon_num'] = $model->coupon_num;
//                $smallModelTicket['day'] = $model->day;
//                $smallModelTicket['price'] = $model->price;
//                $smallModelTicket['bracelet_id'] = $model->bracelet_id;
//                $smallModelTicket['bracelet_number'] = $model->bracelet_number;
//                $smallModelTicket['name'] = $model->name;
//                $smallModelTicket['birthday'] = $model->birthday;
//                $smallModelTicket['gender'] = $model->gender;
//                $smallModelTicket['status'] = $model->status;
//                $smallModelTicket['top_up_hours'] = $model->top_up_hours;
//                $smallModelTicket['top_up_price'] = $model->top_up_price;
//                $smallModelTicket['start_at'] = $model->start_at;
//                $smallModelTicket['end_at'] = $model->end_at;
//                $smallModelTicket['shift_start'] = $model->shift_start;
//                $smallModelTicket['shift_end'] = $model->shift_end;
//                $smallModelTicket['temp_status'] = $model->temp_status;
//                $storeTicket->models()->create($smallModelTicket);
//            }
//            foreach ($ticket->products as $product) {
//                $smallProductTicket = [];
//                $smallProductTicket['category_id'] = $product->category_id;
//                $smallProductTicket['product_id'] = $product->product_id;
//                $smallProductTicket['qty'] = $product->qty;
//                $smallProductTicket['price'] = $product->price;
//                $smallProductTicket['total_price'] = $product->total_price;
//                $storeTicket->products()->create($smallProductTicket);
//            }
//
//        }
//
//        foreach ($reservations as $reservation) {
//            $storeReservationData = [];
//            $storeReservationData['add_by'] = $reservation->add_by;
//            $storeReservationData['ticket_num'] = $reservation->ticket_num;
//            $storeReservationData['custom_id'] = $reservation->custom_id;
//            $storeReservationData['day'] = $reservation->day;
//            $storeReservationData['client_name'] = $reservation->client_name;
//            $storeReservationData['phone'] = $reservation->phone;
//            $storeReservationData['email'] = $reservation->email;
//            $storeReservationData['gender'] = $reservation->gender;
//            $storeReservationData['gov_id'] = $reservation->gov_id;
//            $storeReservationData['city_id'] = $reservation->city_id;
//            $storeReservationData['event_id'] = $reservation->event_id;
//            $storeReservationData['shift_id'] = $reservation->shift_id;
//            $storeReservationData['hours_count'] = $reservation->hours_count;
//            $storeReservationData['total_price'] = $reservation->total_price;
//            $storeReservationData['total_top_up_hours'] = $reservation->total_top_up_hours;
//            $storeReservationData['total_top_up_price'] = $reservation->total_top_up_price;
//            $storeReservationData['total_top_down_price'] = $reservation->total_top_down_price;
//            $storeReservationData['payment_method'] = $reservation->payment_method;
//            $storeReservationData['payment_status'] = $reservation->payment_status;
//            $storeReservationData['note'] = $reservation->note;
//            $storeReservationData['discount_type'] = $reservation->discount_type;
//            $storeReservationData['discount_value'] = $reservation->discount_value;
//            $storeReservationData['discount_id'] = $reservation->discount_id;
//            $storeReservationData['ticket_price'] = $reservation->ticket_price;
//            $storeReservationData['ent_tax'] = $reservation->ent_tax;
//            $storeReservationData['vat'] = $reservation->vat;
//            $storeReservationData['grand_total'] = $reservation->grand_total;
//            $storeReservationData['paid_amount'] = $reservation->paid_amount;
//            $storeReservationData['rem_amount'] = $reservation->rem_amount;
//            $storeReservationData['status'] = $reservation->status;
//            $storeReservationData['is_coupon'] = $reservation->is_coupon;
//            $storeReservationData['coupon_start'] = $reservation->coupon_start;
//            $storeReservationData['coupon_end'] = $reservation->coupon_end;
//            $storeReservationData['uploaded'] = 1;
//
//            $storeReservation = \App\Models\Reservations::updateOrCreate($storeReservationData);
//
//            foreach ($reservation->models as $model) {
//                $smallModelReservation = [];
//                $smallModelReservation['visitor_type_id'] = $model->visitor_type_id;
//                $smallModelReservation['coupon_num'] = $model->coupon_num;
//                $smallModelReservation['day'] = $model->day;
//                $smallModelReservation['price'] = $model->price;
//                $smallModelReservation['bracelet_id'] = $model->bracelet_id;
//                $smallModelReservation['bracelet_number'] = $model->bracelet_number;
//                $smallModelReservation['name'] = $model->name;
//                $smallModelReservation['birthday'] = $model->birthday;
//                $smallModelReservation['gender'] = $model->gender;
//                $smallModelReservation['status'] = $model->status;
//                $smallModelReservation['top_up_hours'] = $model->top_up_hours;
//                $smallModelReservation['top_up_price'] = $model->top_up_price;
//                $smallModelReservation['start_at'] = $model->start_at;
//                $smallModelReservation['end_at'] = $model->end_at;
//                $smallModelReservation['shift_start'] = $model->shift_start;
//                $smallModelReservation['shift_end'] = $model->shift_end;
//                $smallModelReservation['temp_status'] = $model->temp_status;
//                $storeReservation->models()->updateOrCreate($smallModelReservation);
//            }
//            foreach ($reservation->products as $product) {
//                $smallProductReservation = [];
//                $smallProductReservation['category_id'] = $product->category_id;
//                $smallProductReservation['product_id'] = $product->product_id;
//                $smallProductReservation['qty'] = $product->qty;
//                $smallProductReservation['price'] = $product->price;
//                $smallProductReservation['total_price'] = $product->total_price;
//                $storeReservation->products()->updateOrCreate($smallProductReservation);
//            }
//
//        }
//
//        foreach ($discount_reasons as $reason) {
//            $storeReasonData = [];
//            $storeReasonData['desc'] = $reason->desc;
//            $storeReasonData['uploaded'] = 1;
//            DiscountReason::updateOrCreate($storeReasonData);
//        }
//
//        foreach ($products as $product) {
//            $storeProductData = [];
//            $storeProductData['title'] = $product->title;
//            $storeProductData['category_id'] = $product->category_id;
//            $storeProductData['status'] = $product->status;
//            $storeProductData['vat'] = $product->vat;
//            $storeProductData['price_before_vat'] = $product->price_before_vat;
//            $storeProductData['price'] = $product->price;
//            $storeProductData['uploaded'] = 1;
//            Product::updateOrCreate($storeProductData);
//        }
//
//        foreach ($payments as $payment) {
//            $storePaymentData = [];
//            $storePaymentData['rev_id'] = $payment->rev_id;
//            $storePaymentData['ticket_id'] = $payment->ticket_id;
//            $storePaymentData['cashier_id'] = $payment->cashier_id;
//            $storePaymentData['payment_method'] = $payment->payment_method;
//            $storePaymentData['day'] = $payment->day;
//            $storePaymentData['amount'] = $payment->amount;
//            $storePaymentData['uploaded'] = 1;
//            Payment::updateOrCreate($storePaymentData);
//        }
//
//
//        foreach ($users as $user) {
//
//            $storeUserData = [];
//            $storeUserData['name'] = $user->name;
//            $storeUserData['user_name'] = $user->user_name;
//            $storeUserData['password'] = $user->password;
//            $storeUserData['uploaded'] = 1;
//
//            \App\Models\User::updateOrCreate($storeUserData);
//        }
//
//
//        foreach ($admins as $admin) {
//
//            $storeAdminData = [];
//            $storeAdminData['name'] = $admin->name;
//            $storeAdminData['password'] = $admin->password;
//            $storeAdminData['email'] = $admin->email;
//            $storeAdminData['uploaded'] = 1;
//            \App\Models\Admin::updateOrCreate($storeAdminData);
//        }
//
//
//        foreach ($categories as $category) {
//
//            $storeCategoryData = [];
//            $storeCategoryData['title'] = $category->title;
//            $storeCategoryData['uploaded'] = 1;
//
//
//            \App\Models\Category::updateOrCreate($storeCategoryData);
//        }
//
//
//        foreach ($visitors as $visitor) {
//
//            $storeVisitorData = [];
//            $storeVisitorData['title'] = $visitor->title;
//            $storeVisitorData['event_id'] = $visitor->event_id;
//            $storeVisitorData['1_hours'] = $visitor['1_hours'];
//            $storeVisitorData['2_hours'] = $visitor['2_hours'];
//            $storeVisitorData['3_hours'] = $visitor['3_hours'];
//            $storeVisitorData['4_hours'] = $visitor['4_hours'];
//            $storeVisitorData['5_hours'] = $visitor['5_hours'];
//            $storeVisitorData['uploaded'] = 1;
//
//
//            \App\Models\VisitorTypes::updateOrCreate($storeVisitorData);
//        }
//
//
////        $dump = new IMysqldump\Mysqldump('mysql:host=2.57.89.1;dbname=u657893346_kidsstation', 'u657893346_kidsstation', 'kidsstation@2022Pass');
//        $dump = new IMysqldump\Mysqldump('mysql:host=2.57.89.1;dbname=u657893346_kidstest', 'u657893346_kidstest', 'Hyaadodo@1010');
//        if (file_exists('database/' . date('Y-m-d') . '-u657893346_kidstest.sql')) {
//            unlink('database/' . date('Y-m-d') . '-u657893346_kidstest.sql');
//        }
//        $dump->start('database/' . date('Y-m-d') . '-u657893346_kidstest.sql');
//
//        $dbFile = public_path('database/' . date('Y-m-d') . '-u657893346_kidstest.sql');
//
//
//        $dropMysqli = new mysqli('localhost', 'root', '', 'u657893346_kidsstation');
//        $dropMysqli->query('SET foreign_key_checks = 0');
//        if ($result = $dropMysqli->query("SHOW TABLES")) {
//            while ($row = $result->fetch_array(MYSQLI_NUM)) {
//                $dropMysqli->query('DROP TABLE IF EXISTS `' . $row[0] . '`');
//            }
//        }
//
//        $dropMysqli->query('SET foreign_key_checks = 1');
//        $dropMysqli->close();
//        new Import($dbFile, 'root', '', 'u657893346_kidsstation', 'localhost');
//        DB::purge('online');
//        DB::setDefaultConnection('mysql');
////        DB::purge('online');
////        DB::setDefaultConnection('offline');
//
//        toastr()->success('تم تحديث قاعده البيانات بنجاح');
//        return redirect()->back();
////        return response()->json(['status' => 200]);
//
//    }//end fun
//
//
//    private function is_connected()
//    {
//        $connected = @fsockopen("www.example.com", 80);
//        //website, port  (try 80 or 443)
//        if ($connected) {
//            $is_conn = true; //action when connected
//            fclose($connected);
//        } else {
//            $is_conn = false; //action in connection failure
//        }
//        return $is_conn;
//
//    }//end fun
//}//end class
