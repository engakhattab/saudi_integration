@extends('Admin/layouts/master')
@section('title') {{$setting->title}} | Settings @endsection
@section('page_name') Settings @endsection
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
        <div class="col-md-12">
            <form action="{{route('admin.edit.setting')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0 card-title">{{$setting->title}} General Settings</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Family Vat(%)</label>
                                    <input type="number" class="form-control" name="family_tax" required
                                           placeholder="%" value="{{$setting->family_tax}}" min="0" max="100">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Family Ent Vat(%)</label>
                                    <input type="number" class="form-control" name="family_ent" required
                                           placeholder="%" value="{{$setting->family_ent}}" min="0" max="100">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Phone</label>
                                    <input type="text" class="form-control" name="phone"
                                           placeholder="Enter A Phone Number" value="{{$setting->phone}}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">{{$setting->title}} Team</label>
                                    <input type="text" class="form-control" name="Team_phone"
                                           placeholder="Enter A Phone Number" value="{{$setting->Team_phone}}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Group Organization Phone</label>
                                    <input type="text" class="form-control" name="group_organization_phone"
                                           placeholder="Enter A Phone Number"
                                           value="{{$setting->group_organization_phone}}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Information E-mail</label>
                                    <input type="text" class="form-control" name="info_email"
                                           placeholder="email@email.com" value="{{$setting->info_email}}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Sales E-mail</label>
                                    <input type="text" class="form-control" name="sales_email"
                                           placeholder="email@email.com" value="{{$setting->sales_email}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">Reservation Vat(%)</label>
                                    <input type="number" class="form-control" name="rev_tax" required
                                           placeholder="%" value="{{$setting->rev_tax}}" min="0" max="100">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Reservation Ent Tax(%)</label>
                                    <input type="number" class="form-control" name="rev_ent" required
                                           placeholder="%" value="{{$setting->rev_ent}}" min="0" max="100">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Park Capacity</label>
                                    <input type="number" min="0" class="form-control" name="capacity"
                                           placeholder="Default Capacity Of The Park" value="{{$setting->capacity}}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Facebook</label>
                                    <input type="text" class="form-control" name="facebook"
                                           placeholder="https://www.facebook.com/your_id"
                                           value="{{$setting->facebook}}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Instagram</label>
                                    <input type="text" class="form-control" name="instagram"
                                           placeholder="https://www.instagram.com/your_id"
                                           value="{{$setting->instagram}}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Twitter</label>
                                    <input type="text" class="form-control" name="twitter"
                                           placeholder="https://www.twitter.com/your_id" value="{{$setting->twitter}}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Snap Chat</label>
                                    <input type="text" class="form-control" name="snap"
                                           placeholder="https://www.snapchat.com/snap_id" value="{{$setting->snap}}">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="form-label">Exit Time</label>
                                    <input type="time" class="form-control" name="exit_time" required step="any"
                                           placeholder="" value="{{$setting->exit_time}}">
                                </div>
{{--                                @php(dd(\Carbon\Carbon::parse($setting->exit_time)->format('H:i')))--}}

                            </div>
                            <div class="col-md-12 ">
                                <div class="form-group">
                                    <label class="form-label">Logo</label>
                                    <input type="file" class="dropify" name="logo" data-default-file="{{asset($setting->logo)}}" accept="image/png, image/gif, image/jpeg,image/jpg"/>
                                    <span class="form-text text-danger text-center">accept only png, gif, jpeg, jpg</span>
                                </div>
                            </div>
                            <div class="col-md-6 ">
                                <div class="form-group mb-0">
                                    <label class="form-label">Address</label>
{{--                                    {{($errors->has('address')) ? 'is-invalid state-invalid' : ''}}--}}
                                    <input type="text" class="form-control" name="address"
                                           placeholder="Address Of The Park" value="{{$setting->address}}">
{{--                                    @if($errors->has('address'))--}}
{{--                                        <div class="invalid-feedback">{{$errors->first('address')}}</div>--}}
{{--                                    @endif--}}
                                </div>
                            </div>
                            <div class="col-md-6 ">
                                <div class="form-group mb-0">
                                    <label class="form-label">Title</label>
                                    <input type="text" class="form-control" name="title"
                                           placeholder="Title Of The Site" value="{{$setting->title}}">
                                </div>
                            </div>
                            <div class="col-md-12 ">
                                <div class="form-group mb-0">
                                    <label class="form-label">Terms</label>
                                    <textarea class="form-control" name="terms" rows="7"
                                              placeholder="text here..">{{$setting->terms}}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12 ">
                                <div class="form-group mb-0">
                                    <label class="form-label">Main Information About SkyPark</label>
                                    <textarea class="form-control" name="about" rows="7"
                                              placeholder="text here..">{{$setting->about}}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12 ">
                                <div class="form-group mb-0">
                                    <label class="form-label">Privacy</label>
                                    <textarea class="form-control" name="privacy" rows="7"
                                              placeholder="text here..">{{$setting->privacy}}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12 ">
                                <div class="form-group mb-0">
                                    <label class="form-label">Refund Policy</label>
                                    <textarea class="form-control" name="refund_privacy" rows="7"
                                              placeholder="text here..">{{$setting->refund_privacy}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-left">
                        <button type="submit" class="btn btn-primary">Updated</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://cdn.ckeditor.com/4.19.0/full/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'terms' );
        CKEDITOR.replace( 'about' );
        CKEDITOR.replace( 'privacy' );
        CKEDITOR.replace( 'refund_privacy' );
    </script>
@endsection
