<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateSetting;
use App\Models\GeneralSetting;
use App\Models\Setting;
use App\Traits\PhotoTrait;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('adminPermission:Setting');
    }

    use PhotoTrait;
    public function index(){
        $setting = GeneralSetting::first();
        $setting->rev_tax = ($setting->rev_tax - 1) * 100;
        $setting->rev_ent = ($setting->rev_ent - 1) * 100;
        $setting->family_tax = ($setting->family_tax - 1) * 100;
        $setting->family_ent = ($setting->family_ent - 1) * 100;
        return view('Admin/setting/index',compact('setting'));
    }

    public function edit(UpdateSetting $request){
        $input = $request->except('_token');
        if($request->has('logo')){
            $file_name = $this->saveImage($request->logo,'assets/uploads');
            $input['logo'] = 'assets/uploads/'.$file_name;
        }
        $input['rev_tax']    = $input['rev_tax']/100 + 1 ;
        $input['rev_ent']    = $input['rev_ent']/100 + 1 ;
        $input['family_tax'] = $input['family_tax']/100 + 1 ;
        $input['family_ent'] = $input['family_ent']/100 + 1 ;
        GeneralSetting::first()->update($input);
        toastr()->success('Data Updated Successfully');
        return back();
    }

    public function getLogo(){
        return asset(GeneralSetting::first()->logo);
    }
}
