<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\PhotoTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class UsersController extends Controller
{
    use PhotoTrait;

    public function __construct()
    {
       
        $this->middleware('adminPermission:CS');
    }

    public function index(request $request)
    {
        if ($request->ajax()) {
            $users = User::latest()->get();
            return Datatables::of($users)
                ->addColumn('action', function ($users) {
                    return '
                            <button type="button" data-id="' . $users->id . '" class="btn btn-pill btn-info-light editBtn"><i class="fa fa-edit"></i></button>

                       ';
//                    echo ' <button class="btn btn-pill btn-danger-light" data-toggle="modal" data-target="#delete_modal"
//                                    data-id="' . $users->id . '" data-title="' . $users->name . '">
//                                    <i class="fas fa-trash"></i>
//                            </button>';
                })
                ->addColumn('role', function ($users) {
                    $value = [];
                    foreach ($users->roles as $role){
                        $value[] .= "<span class='badge badge-success'>$role->name</span>";
                    }
                    return $value;
                })
                ->editColumn('status', function ($admins) {
                    if($admins->status == 0)
                        return '<span class="badge badge-danger br-7">inactive</span>';
                    else
                        return '<span class="badge badge-success br-7">active</span>';
                })
                ->editColumn('created_at', function ($users) {
                    return $users->created_at->diffForHumans();
                })
                ->editColumn('photo', function ($users) {
                    return '
                    <img alt="image" class="avatar avatar-md rounded-circle" src="' . get_user_photo($users->photo) . '">
                    ';
                })
                ->escapeColumns([])
                ->make(true);
        } else {
            return view('Admin/users/index');
        }
    }


    public function delete(Request $request)
    {
        $users = User::where('id', $request->id)->first();
        if (file_exists($users->photo)) {
            unlink($users->photo);
        }
        $users->delete();
        return response(['message' => 'Data Deleted Successfully', 'status' => 200], 200);
    }

    public function create()
    {
        $roles = Role::all();
        return view('Admin/users.parts.create',compact('roles'));
    }

    public function store(request $request): \Illuminate\Http\JsonResponse
    {
        $inputs = $request->validate([
            'user_name' => 'required|unique:users',
            'name'      => 'required',
            'status' => 'nullable',
            'password'  => 'required|min:6|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/',
            'roles'     => 'required',
            'photo'     => 'nullable',
        ]);
        if ($request->has('photo')) {
            $file_name = $this->saveImage($request->photo, 'assets/uploads/users');
            $inputs['photo'] = 'assets/uploads/users/' . $file_name;
        }
        $inputs['password'] = Hash::make($request->password);
        unset($inputs['roles']);
        $user = User::create($inputs);
        if ($user->assignRole($request->roles))
            return response()->json(['status' => 200]);
        else
            return response()->json(['status' => 405]);
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        $rolePermissions = DB::table("model_has_roles")->where("model_id",$user->id)
            ->pluck('model_has_roles.role_id')
            ->all();
        return view('Admin/users.parts.edit', compact('user','roles','rolePermissions'));
    }

    public function update(request $request)
    {
        $inputs = $request->validate([
            'id'        => 'required|exists:users,id',
            'user_name' => 'required|unique:users,user_name,' . $request->id,
            'name'      => 'required',
            'status' => 'nullable',
            'photo'     => 'nullable',
            'password'  => 'nullable|min:6|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/',
            'roles'     => 'required',
        ]);
//        dd($request->all());

        if ($request->has('photo')) {
            $file_name = $this->saveImage($request->photo, 'assets/uploads/users');
            $inputs['photo'] = 'assets/uploads/users/' . $file_name;
        }
        if ($request->has('password') && $request->password != null)
            $inputs['password'] = Hash::make($request->password);
        else
            unset($inputs['password']);

        unset($inputs['roles']);
        $user = User::findOrFail($request->id);
        DB::table('model_has_roles')->where('model_id',$user->id)->delete();
        $user->assignRole($request->roles);
        if ($user->update($inputs)){
            updatedUploadedModel($user);
            return response()->json(['status' => 200]);
        }else{
            return response()->json(['status' => 405]);
        }


    }





}
