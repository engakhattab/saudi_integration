<?php

use App\Models\CountrySetting;
use App\Models\Department;
use App\Models\GeneralSetting;
use Illuminate\Support\Facades\Storage;


if (!function_exists('change_Date_into_arabic')) {
    function change_Date_into_arabic($current_date, $date_type = '')
    {
        // PHP Arabic Date
        // PHP Arabic Date

        error_reporting(E_ALL ^ E_NOTICE);

        $months = array(
            "Jan" => "يناير",
            "Feb" => "فبراير",
            "Mar" => "مارس",
            "Apr" => "أبريل",
            "May" => "مايو",
            "Jun" => "يونيو",
            "Jul" => "يوليو",
            "Aug" => "أغسطس",
            "Sep" => "سبتمبر",
            "Oct" => "أكتوبر",
            "Nov" => "نوفمبر",
            "Dec" => "ديسمبر"
        );

        $your_date = $current_date; // The Current Date

        $en_month = date("M", strtotime($your_date));

        foreach ($months as $en => $ar) {
            if ($en == $en_month) {
                $ar_month = get_lang() == 'en' ? $en : $ar;
            }
        }

        $find = array(

            "Sat",
            "Sun",
            "Mon",
            "Tue",
            "Wed",
            "Thu",
            "Fri"

        );

        $replace = array(

            "السبت",
            "الأحد",
            "الإثنين",
            "الثلاثاء",
            "الأربعاء",
            "الخميس",
            "الجمعة"

        );

        $ar_day_format = date("D", strtotime($your_date)); // The Current Day

        $ar_day = str_replace($find, $replace, $ar_day_format);


        header('Content-Type: text/html; charset=utf-8');
        $standard = array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");

        $eastern_arabic_symbols =  array("0", "1", "2", "3", "4", "5", "6", "7", "8", "9");

        if ( get_lang() == 'ar' )
        {
            $eastern_arabic_symbols = array("٠", "١", "٢", "٣", "٤", "٥", "٦", "٧", "٨", "٩");
        }



        $current_date = $ar_day . ' - ' . date("d", strtotime($your_date)) . ' / ' . $ar_month . ' / ' . date("Y", strtotime($your_date));

        if ($date_type != '') {
            $current_date = date("d", strtotime($your_date)) . ' / ' . $ar_month . ' / ' . date("Y", strtotime($your_date));
        }

        if ($date_type == 'full') {
            $current_date = date("d", strtotime($your_date)) . ' / ' . $ar_month . ' / ' . date("Y", strtotime($your_date));
        }

        if ($date_type == 'time_ar') {
//           H:i:s
            $current_date = date("H", strtotime($your_date)) . ':' . date("i", strtotime($your_date))/*.":".date("s", strtotime($your_date))*/;
        }

        if ($date_type == 'time_ar_pm_am') {
//           H:i:s
            $am_pm_date = ' ص ';
            if (date("A", strtotime($your_date)) == 'PM') {
                $am_pm_date = ' م ';
            }
            $current_date = date("H", strtotime($your_date)) . ':' . date("i", strtotime($your_date)) . $am_pm_date;
        }

        $arabic_date = str_replace($standard, $eastern_arabic_symbols, $current_date);

        // Echo Out the Date

        return $arabic_date;
    }
}


//get current lang
if (!function_exists('get_lang')) {
    function get_lang()
    {
        return Request()->segment(1);
    }
}

if (!function_exists('getPriceBeforDiscount')) {
    function getPriceBeforDiscount($price = 0 ,$have_offer = 'no' , $offer_type = 'per' , $offer_value = 0 , $offer_min = 0 , $offer_bonus = 0)
    {

        if($have_offer == "yes"){

            if($offer_type == "per"){
                $discount = ( $price *  $offer_value  ) / 100 ;
                return  ($price + $discount );
            }
            elseif ($offer_value == "val"){
                return  ($price + $offer_value );
            }
            elseif ($offer_value == "amount"){
                return  $price ;
            }

        }

        return $price;
    }
}

if (!function_exists('empty_text_validate')) {
    function empty_text_validate($option = '')
    {
        $data = [
            '' => '#',
            'empty' => '',
            'full' => '',
        ];
        return $data[$option];
    }
}


//get current lang
if (!function_exists('session_lang')) {
    function session_lang()
    {

        $lang = 'ar';

        if (session()->get('lang') && in_array(session()->get('lang'), ['ar', 'en'])) {
            $lang = session()->get('lang') ? session()->get('lang') : 'default';
        }

        if ( get_lang() && in_array(get_lang() , ['ar', 'en'])) {
            $lang = get_lang();
        }

        if (request()->get('lang') && in_array(request()->get('lang'), ['ar', 'en'])) {
            $lang = request()->get('lang');
        }

        if (request()->post('lang') && in_array(request()->post('lang'), ['ar', 'en'])) {
            $lang = request()->post('lang');
        }

        if (request()->header('lang') && in_array(request()->header('lang'), ['ar', 'en'])) {
            $lang = request()->header('lang');
        }
        return $lang;
    }
}

if (!function_exists('GenerateDefaultImage')) {
    function GenerateDefaultImage($option = '')
    {
        $option = isset($option) && $option != '' ? $option : 'D I';
        \Storage::put("default_images\default_images_" . time() . ".png", \DefaultProfileImage::create($option)->encode());
        return "default_images\default_images_" . time() . ".png";
    }
}

// change language and get current url
if (!function_exists('change_language')) {
    function change_language($lang)
    {
        return LaravelLocalization::getLocalizedURL($lang);
    }
}


// prefix language before route
if (!function_exists('l_url')) {
    function l_url($url)
    {
        return LaravelLocalization::setLocale() . '/' . $url;;
    }
}


// ----------------------------- site text ------------------------------------


if (!function_exists('site_text')) {
    function site_text($id)
    {
        $site = \App\Models\SiteText::where('id', $id);
        if ($site->count() > 0) {
            return $site->first();
        }
        return 0;
    }
}


// ----------------------------- site text ------------------------------------


if (!function_exists('right_redirect')) {
    function right_redirect($url)
    {

//            function startsWith ($string, $startString)
//            {
        $len = strlen('h');
//                return (substr($url, 0, $len) === 'h');
//            }

        if (substr($url, 0, $len) === 'h') {
            return $url;
        }

        return '#';
    }

}


// ----------------------------- site text ------------------------------------




if (!function_exists('generalSetting')) {
    function generalSetting()
    {
      return GeneralSetting::first();
    }
}


if (!function_exists('user_by_keyword')) {
    function user_by_keyword( $keyword = '')
    {
        return auth()->user() && auth()->user()->$keyword ? auth()->user()->$keyword : null;
    }
}


if (!function_exists('department_sub_departments')) {
    function department_sub_departments()
    {
        $data  = Department::where("is_shown","yes")
            ->where("level",0)
            ->with(["department_trans_fk",'sub_departments.department_trans_fk'])->get();
        return $data;
    }
}



if (!function_exists('site_text')) {
    function site_text()
    {
        return \App\Models\SiteText::orderBy('id', 'asc')->get();
    }
}


if (!function_exists('bands')) {
    function bands()
    {
        return \App\Models\SiteText::orderBy('id', 'asc')->first();
    }
}


// -------------------------------  ++++++++++++++++ -------------------------------


// GetImg
if (!function_exists('GetImg')) {
    function GetImg($img_src)
    {

        if (filter_var($img_src, FILTER_VALIDATE_URL)) {
            $img = $img_src;
        } else if ( Storage::exists( $img_src ) ) {
            $img = url('storage/') . '/' . $img_src;
        } else {
            $img = url('/') . '/empty.png';
        }

        return $img;
    }
}

// -------------------------------  ++++++++++++++++ -------------------------------


// -------------------------------  Upload Image -------------------------------


if (!function_exists('upload_image')) {
    function upload_image($path_ = '', $img, $plus, $file_name = '', $delete_file = '')
    {
        // delete old file
        $delete_file != '' ? Storage::delete($delete_file) : '';
        $path = $img->store($path_);
        return $path;
    }
}

if (!function_exists('delete_image')) {
    function delete_image($img)
    {
        // delete old file
        $img != '' ? Storage::delete($img) : '';
    }
}


if (!function_exists('upload_multi_images')) {
    function upload_multi_images($image = '', $id = '', $path = '')
    {

        $data['size'] = $image->getSize();
        $data['mime_type'] = $image->getMimeType();
        $data['name'] = $image->getClientOriginalName();
        $data['hashname'] = $image->hashName();
        $image->store($path);
        return $data;


    }

}


// -------------------------------  Upload Image -------------------------------


if (!function_exists('up')) {
    function up()
    {
        return new \App\Http\Controllers\Upload;
    }
}

if (!function_exists('aurl')) {
    function aurl($url = null)
    {
        return url('admin/' . $url);
    }
}


if (!function_exists('durl')) {
    function durl($url = null)
    {
        return url('driver/' . $url);
    }
}

if (!function_exists('admin')) {
    function admin()
    {
        return auth()->guard('admin');
    }
}



if (!function_exists('delivery')) {
    function delivery()
    {
        return auth()->guard('delivery');
    }
}

if (!function_exists('get_admin_auth')) {
    function get_admin_auth()
    {
        return auth();
    }
}


if (!function_exists('driver')) {
    function driver()
    {
        return auth()->guard('driver');
    }
}

if (!function_exists('active_menu')) {
    function active_menu($link)
    {
        if (preg_match('/' . $link . '/i', Request::segment(2))) {
            return ['m-menu__item--open', 'display:block'];
        } else {
            return ['', ''];
        }
    }
}


if (!function_exists('trans_if_web')) {
    function trans_if_web($text, $ar_text = null)
    {
        if ( Request::segment(1)  == 'admin') {
            return $ar_text;
        } else {
            $text = 'web_lang.'.$text;
            return trans( $text );
        }
    }
}

if (!function_exists('cart_count')) {
    function cart_condition()
    {
        if (auth()->user()) {
            return ['user_id', '=', (auth()->user() ? auth()->user()->id : null)];
        }
        $session = request()->session()->get('offline_cart');
        $session_id = (isset($session) && isset($session["session_id"]) ? $session["session_id"] : 'no_session');
        return ['session_id', '=', $session_id];
    }

}

if (!function_exists('cart_count')) {
    function cart_count()
    {
        return \App\Models\CartDetail::where([cart_condition()])->count();
    }
}


if (!function_exists('datatable_lang')) {
    function datatable_lang()
    {
        return ['sProcessing' => trans('admin.sProcessing'),
            'sLengthMenu' => trans('admin.sLengthMenu'),
            'sZeroRecords' => trans('admin.sZeroRecords'),
            'sEmptyTable' => trans('admin.sEmptyTable'),
            'sInfo' => trans('admin.sInfo'),
            'sInfoEmpty' => trans('admin.sInfoEmpty'),
            'sInfoFiltered' => trans('admin.sInfoFiltered'),
            'sInfoPostFix' => trans('admin.sInfoPostFix'),
            'sSearch' => trans('admin.sSearch'),
            'sUrl' => trans('admin.sUrl'),
            'sInfoThousands' => trans('admin.sInfoThousands'),
            'sLoadingRecords' => trans('admin.sLoadingRecords'),
            'oPaginate' => [
                'sFirst' => trans('admin.sFirst'),
                'sLast' => trans('admin.sLast'),
                'sNext' => trans('admin.sNext'),
                'sPrevious' => trans('admin.sPrevious'),
            ],
            'oAria' => [
                'sSortAscending' => trans('admin.sSortAscending'),
                'sSortDescending' => trans('admin.sSortDescending'),
            ],
        ];
    }
}

/////// Validate Helper Functions ///////
if (!function_exists('v_image')) {
    function v_image($ext = null)
    {
        if ($ext === null) {
            return 'image|mimes:jpg,jpeg,png,gif,bmp';
        } else {
            return 'image|mimes:' . $ext;
        }
    }
}
/////// Validate Helper Functions ///////





if (!function_exists('change_session_country')) {
    function change_session_country($country_code)
    {
        $counties_codes = CountrySetting::pluck('code')->toArray();

        if(in_array($country_code, $counties_codes )){
            if(session()->has('country_code')){
                session()->forget('country_code');
            }
            session()->put('country_code',$country_code);
        }else { // end of array
            if(session()->has('currency')){
                session()->forget('country_code');
            }
            session()->put('country_code', $country_code);
        }
    }
}


if (!function_exists('session_country')) {
    function session_country()
    {

        $country_code = 'eg';
        $inArray = \App\Models\CountrySetting::pluck("code")->toArray();

        if (session()->get('country_code') && in_array(session()->get('country_code'),$inArray)) {
            $country_code = session()->get('country_code') ? session()->get('country_code') : 'default';
        }

        /*if (Request()->segment(3) && in_array(Request()->segment(3), $inArray)) {
            $country_code = Request()->segment(3);
        }*/

        if (request()->get('country_code') && in_array(request()->get('country_code'),$inArray)) {
            $country_code = request()->get('country_code');
        }

        if (request()->post('country_code') && in_array(request()->post('country_code'), $inArray)) {
            $country_code = request()->post('country_code');
        }

        if (request()->header('country_code') && in_array(request()->header('country_code'), $inArray)) {
            $country_code = request()->header('country_code');
        }
        return $country_code;
    }
}


if (!function_exists('random_code')) {
    function random_code($length = 10) {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = "" ;
        for ($i = 0; $i < $length; $i++) {
            $n = rand(0, strlen($alphabet)-1);
            $pass .= $alphabet[$n];
        }
        return $pass;
    }
}

if (!function_exists('create_qr_code')) {
    function create_qr_code($id,$folder_id) {
        $code = $folder_id. "-".$id ."-". random_code(5) ;
        $qrcode = \QrCode::format('png')->size(200)->errorCorrection('H')->generate($code);
        $output_file = '/qr-code/' . $folder_id . '/img-' . time() . '.png';
        Storage::disk('local')->put($output_file, $qrcode);
        //public/storage/qr-code/img-2222333.png
        return ["code"=>$code,"image"=>$output_file];
    }
}


if (!function_exists('get_old_price')) {
    function get_old_price($price ,$productObj ) {
      if($productObj->have_offer == "yes"){
          if($productObj->offer_type == "per"){
              $discount = ( $price *  $productObj->offer_value  ) / 100 ;
              return  ($price - $discount );
          }
          elseif ($productObj->offer_type == "val"){
              return  ($price - $productObj->offer_value );
          }
          elseif ($productObj->offer_type == "amount"){
              return  $price ;
          }
      }
      return $price;
    }
}


if (!function_exists('all_order_count')) {
    function all_order_count() {
        $order_count = \App\Models\Bills::count();
      return $order_count;
    }
}

if (!function_exists('new_order_count')) {
    function new_order_count() {
        $order_count = \App\Models\Bills::where([['status','=', 'new']])->count();
      return $order_count;
    }
}

if (!function_exists('preparing_order_count')) {
    function preparing_order_count() {
        $order_count = \App\Models\Bills::where([['status','=', 'preparing']])->count();
      return $order_count;
    }
}

if (!function_exists('ready_order_count')) {
    function ready_order_count() {
        $order_count = \App\Models\Bills::where([['status','=', 'ready']])->count();
      return $order_count;
    }
}

if (!function_exists('finish_order_count')) {
    function finish_order_count() {
        $order_count = \App\Models\Bills::where([['status','=', 'finish']])->count();
        return $order_count;
    }
}


if (!function_exists('cancel_order_count')) {
    function cancel_order_count() {
        $order_count = \App\Models\Bills::where([['status','=', 'cancel']])->count();
      return $order_count;
    }
}
if (!function_exists('helperJson')) {
    function helperJson($data=null,$message='',$code=200,$status=200) {
        $json = response()->json(['data'=>$data,'message'=>$message,'code'=>$code],$status);
      return $json;
    }
}
if (!function_exists('get_file')) {
    function get_file($image) {

        if ($image!= null){
            if (!file_exists($image)){
                return asset('assets/default/img/empty.png');
            }else{
                return asset($image);
            }
        }else{
            return asset('assets/default/img/empty.png');
        }
    }
}

if (!function_exists('loggedAdmin')) {
    function loggedAdmin($field = null){
        return auth()->guard('admin')->user()->$field;
    }
}

if (!function_exists('get_user_photo')) {
    function get_user_photo($image): string
    {
        if ($image!= null){
            if (!file_exists($image)){
                return asset('assets/uploads/avatar.gif');
            }else{
                return asset($image);
            }
        }else{
            return asset('assets/uploads/avatar.gif');
        }
    }
}

if (!function_exists('optionForEach')) {
    function optionForEach($array=[] , $of,$name='' , $eq=''){
        $option = '';
        foreach ($array as $key => $item){
            $selected = $item->$of == $eq ?'selected' :'';
            $option .='<option value="'.$item->$of.'" '.$selected.'>'.$item->$name.'</option>';
        }
        return $option;
    }
}
