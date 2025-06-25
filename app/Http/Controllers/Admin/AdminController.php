<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Product;
use App\Traits\PhotoTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;

class AdminController extends Controller
{
    use PhotoTrait;

    public function __construct()
    {
        $this->middleware('adminPermission:Master');
    }

    public function index(request $request)
    {

        if ($request->ajax()) {
//            DB::connection('mysql');
            $admins = Admin::latest()->get();
            return Datatables::of($admins)
                ->addColumn('action', function ($admins) {
                    return '
                            <button type="button" data-id="' . $admins->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>
                            <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
                                    data-id="' . $admins->id . '" data-title="' . $admins->name . '">
                                    <i class="fas fa-trash"></i>
                            </button>
                       ';
                })
                ->editColumn('status', function ($admins) {
                    if($admins->status == 0)
                        return '<span class="badge badge-danger br-7">inactive</span>';
                    else
                        return '<span class="badge badge-success br-7">active</span>';
                })
                ->addColumn('permission', function ($admin) {
                    $value = '';
                    foreach ($admin->permissions as $permission) {  // Fixed the typo here (permissionsas -> permissions)
                        $value .= "<span class='badge badge-success'>" . e($permission->name) . "</span> ";  // Escape output to prevent XSS
                    }
                    return $value;
                })

                ->editColumn('created_at', function ($admins) {
                    return $admins->created_at->diffForHumans();
                })
                ->editColumn('photo', function ($admins) {
                    return '
                    <img alt="image" class="avatar avatar-md rounded-circle" src="' . get_user_photo($admins->photo) . '">
                    ';
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('Admin/admin/index');
        }
    }


    public function delete(Request $request)
    {
        $admin = Admin::where('id', $request->id)->first();
        if ($admin == auth()->guard('admin')->user()) {
            return response(['message' => "You Can't Delete The Logged Admin !", 'status' => 501], 200);
        } else {
            if (file_exists($admin->photo)) {
                unlink($admin->photo);
            }
            $admin->delete();
            return response(['message' => 'Data Deleted Successfully', 'status' => 200], 200);
        }
    }

    public function myProfile()
    {
        $admin = auth()->guard('admin')->user();
        return view('Admin/admin/profile', compact('admin'));
    }//end fun


    public function create()
    {
        $permissions = Permission::where('guard_name', 'admin')->get();
        return view('Admin/admin.parts.create', compact('permissions'));
    }

    public function store(request $request): \Illuminate\Http\JsonResponse
    {
        $inputs = $request->validate([
            'email' => 'required|unique:admins',
            'name' => 'required',
            'status' => 'nullable',
            'password' => 'required|min:6|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/',
            'photo' => 'nullable|mimes:jpeg,jpg,png,gif',
        ]);
        if ($request->has('photo')) {
            $file_name = $this->saveImage($request->photo, 'assets/uploads/admins');
            $inputs['photo'] = 'assets/uploads/admins/' . $file_name;
        }
        $inputs['password'] = Hash::make($request->password);
        $admin = Admin::create($inputs);
        $admin->givePermissionTo($request->permissions);

        if ($admin)
            return response()->json(['status' => 200]);
        else
            return response()->json(['status' => 405]);
    }

    public function edit(Admin $admin)
    {

        $adminPermissions = DB::table("model_has_permissions")->where("model_id",$admin->id)
            ->where('model_type','App\Models\Admin')
            ->pluck('model_has_permissions.permission_id')
            ->all();
        $permissions = Permission::where('guard_name', 'admin')->get();
        return view('Admin/admin.parts.edit', compact('admin','adminPermissions','permissions'));
    }

    public function update(request $request)
    {
        $inputs = $request->validate([
            'id' => 'required|exists:admins,id',
            'email' => 'required|unique:admins,email,' . $request->id,
            'name' => 'required',
            'status' => 'nullable',
            'photo' => 'nullable',
            'password' => 'nullable|min:6|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/',

        ]);

        // Handle the status field
        $inputs['status'] = ($request->status == 'on') ? '1' : '0';

        // Handle photo upload if exists
        if ($request->has('photo')) {
            $file_name = $this->saveImage($request->photo, 'assets/uploads/admins');
            $inputs['photo'] = 'assets/uploads/admins/' . $file_name;
        }

        // Handle password update if it's provided
        if ($request->filled('password')) {
            $inputs['password'] = Hash::make($request->password);
        } else {
            unset($inputs['password']);
        }

        // Find the admin and update the permissions
        $admin = Admin::findOrFail($request->id);

        // Revoke existing permissions if there are new permissions
        if ($request->has('permissions') && count($request->permissions)) {
            $names = $admin->getPermissionNames();
            foreach ($names as $name) {
                $admin->revokePermissionTo($name);
            }

            // Assign new permissions
            $admin->givePermissionTo($request->permissions);
        }

        // Update the admin record
        if ($admin->update($inputs)) {
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['status' => 405]);
        }
    }

}//end class
