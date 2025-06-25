@extends('Admin/layouts/master')

@section('title')
    {{$setting->title}} | Edit Role
@endsection
@section('page_name')
    Edit Role
@endsection
@section('css')
    @include('layouts.loader.formLoader.loaderCss')
@endsection
@section('content')
    @if(count($errors) > 0 )
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <ul class="p-0 m-0" style="list-style: none;">
                @foreach($errors->all() as $error)
                    <li><i class="fa fa-times-circle"></i> {{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Role & Permissions Of {{$role->name}}</h3>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{route('roles.update',$role->id)}}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Role Name</label>
                                    <input type="text" class="form-control" name="name"
                                           placeholder="Enter Name Of The Role" value="{{$role->name}}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Permissions</label>
                                    <div class="selectgroup selectgroup-pills">
                                        @foreach($permissions as $permission)
                                            <div class="col-4">
                                                <label class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input"
                                                           name="permission[]"
                                                           value="{{$permission->id}}" {{in_array($permission->id, $rolePermissions) ? 'checked' : ''}}>
                                                    <span class="custom-control-label">{{$permission->name}}</span>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="text-align: center">
                                <button type="submit" class="btn btn-success">Update <i class="fe fe-check"></i> </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


