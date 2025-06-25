@extends('sales.layouts.master')
@section('page_title')
    Kidsstation | Exit
@endsection
@section('css')
    @include('layouts.loader.formLoader.loaderCss')
@endsection
@section('content')
    <h2 class="MainTiltle mb-5 ms-4"> Exit </h2>
    <div class="card py-4 w-100 w-sm-80 m-auto ">
        <form method="get" action="{{route('exit.index')}}" class="card-body ">
            <label class="form-label fs-4"> <i class="fas fa-ticket-alt me-2"></i>phone , bracelet number or ticket number</label>
            <div class="d-flex">
                <input type="text" class="form-control" name="search" value="{{count($models)?$_GET['search']:''}}" id="searchValue" placeholder="Type here...">
                <button type="submit" id="searchBtn" class="input-group-text ms-2 bg-gradient-primary px-4 text-body"><i
                        class="fas fa-search text-white"></i></button>
            </div>
        </form>
    </div>
    @if(count($models))
        <div class="card p-2 py-4 mt-3"   id="result">
            <div class="screens p-3 row">
                <div class="screen col">
                    <span>total</span>
                    <strong> {{collect($models)->count()}} </strong>
                </div>
                <div class="screen col">
                    <span>still</span>
                    <strong> {{collect($models)->where('temp_status','in')->count()}} </strong>
                </div>
                <div class="screen col">
                    <span>migrated</span>
                    <strong> {{collect($models)->where('temp_status','out')->count()}} </strong>
                </div>
                <div class="screen col">
                    <span>topUp</span>
                    <strong> {{$ticket->total_top_up_price??0}} SAR </strong>
                </div>
                @if($ticket->total_top_down_price != 0)
                <div class="screen col">
                    <span>Canceled</span>
                    <strong> {{$ticket->total_top_down_price??0}} SAR </strong>
                </div>
                @endif
            </div>



                @if($hours)
                <div class=" topUp w-100 w-md-80 m-auto p-3 mb-5 ">
                    <div class="alert alert-primary alert-dismissible fade show text-white bg-gradient-primary" role="alert">
                        <span class="alert-text"><strong>TopUp ! </strong> Access Time Is {{date('h:i A',strtotime($ticket->models[0]->start_at))}}, Exit Time is {{date('h:i A')}},TopUp {{$hours}} hours </span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true"><i class="fal fa-times  fs-4"></i></span>
                        </button>
                    </div>
                    <label class="form-label ">payment method</label>
                    <div class="paymentMethods">
                        <button class="btn" style="width:17%" type="button" data-bs-toggle="collapse" data-bs-target="#payCash" aria-expanded="false"
                                aria-controls="payCash">
                            <img src="{{asset('assets/sales/img/cash.svg')}}" style="width: 35%;">
                            <span> cash </span> </button>
                        <button class="btn" style="width:17%" type="button" data-bs-toggle="collapse" data-bs-target="#payCash" aria-expanded="false"
                                aria-controls="payCash">
                            <img src="{{asset('assets/sales/img/visa.svg')}}" style="width: 35%;">

                            <span> visa </span> </button>
                        <button class="btn" style="width:22%" type="button" data-bs-toggle="collapse" data-bs-target="#payCash" aria-expanded="false"
                                aria-controls="payCash">
                            <img src="{{asset('assets/sales/img/masterCard.svg')}}" style="width: 35%;">
                            <span> mastercard </span> </button>

                        <button class="btn" style="width:25%" type="button" data-bs-toggle="collapse" data-bs-target="#payCash" aria-expanded="false"
                                aria-controls="payCash">
                            <img src="{{asset('assets/sales/img/meeza.svg')}}" style="width: 35%;">
                            <span> Meeza </span> </button>
                        <!-- payCash -->
                        <div class="collapse pt-3  " id="payCash">
                            <div class="row align-items-end">
                                <div class="col-8 col-md-9 p-2 ">
                                    <label> Amount </label>
                                    <input class="form-control" type="number" />
                                </div>
                                <div class="col-4 col-md-3 p-2">
                                    <button type="button" class="btn w-100 btn-success"> Pay </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        @endif

            <!-- table -->
            <table class=" customDataTable table table-bordered nowrap">
                <thead>
                <tr>
                    <th>Group ID</th>
                    <th>Ticket Number</th>
                    <th>Bracelet Number </th>
                    <th>Type</th>
                    <th>Name</th>
                    <th>age</th>
                    <th>start</th>
                    <th>end</th>
                    <th>TopUp</th>
                    <th>Customer Name</th>
                    <th>contact number</th>
                    <th>actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($models as $model)
                    @php
                        $age = date_diff(date_create($model->birthday??date('Y-m-d')), date_create(date('Y-m-d')));

                        if ($model->shift_end <= '24:00:00') {
                            $formatted_end = Carbon\Carbon::createFromFormat('H:i:s', $model->shift_end)->format('h:i A'); // Format as 12-hour time if end time is before or equal to 24:00:00
                        } else {
                            $formatted_end = Carbon\Carbon::createFromFormat('H:i:s', $model->shift_end)->subDay()->format('h:i A'); // Format as 12-hour time if end time is after 24:00:00
                        }
                    @endphp
                    <tr>
                        <td>{{'#' . $ticket->id ?? ''}}</td>
                        <td>{{'#' .$customId}}</td>
                        <td>{{'#' .$model->bracelet_number ?? ''}}</td>
                        <td>{{'#' .$model->type->title ?? ''}}</td>
                        <td>{{$model->name ?? ''}}</td>
                        @if($age->format("%y"))
                            <td>{{$age->format("%y")}}</td>
                        @else
                            <td></td>
                        @endif
                        <td>{{date('hA',strtotime($model->shift_start))}}</td>
                        <td>{{ $formatted_end }}</td>
                        <td><i class="fas fa-alarm-plus me-1 fa-1x color1"></i> {{$model->top_up_hours}}</td>
                        <td>{{$name}}</td>
                        <td>{{$phone}}</td>
                        <td><span class="controlIcons" id="exitActions{{$model->id}}">{!! $returnArray[$model->id] !!}</span></td>

                    </tr>
                @endforeach
                </tbody>
            </table>

            <div class=" p-4">
                <label class="form-label fs-5"><i class="fas fa-feather-alt me-1"></i> Note</label>
                <textarea name="" id="" class="form-control" rows="6" placeholder="Add Note..."></textarea>
            </div>

            <div class="text-center d-flex justify-content-center">
                <button type="button"
                        class="btn bg-gradient-primary m-3 mb-0" id="print"
                        data-url="{{$type=='rev'?route('reservations.show',$ticket->id):route('ticket.edit',$ticket->id)}}">Reprint</button>
                <a href="{{route('exit-all',$_GET['search']??'')}}" type="button" class="btn btn-dark m-3 mb-0"> final exit </a>
            </div>

            <!-- topUp Modal -->
            <div class="modal fade" id="topUp" tabindex="-1" role="dialog" aria-labelledby="topUp" aria-hidden="true">
                <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title" id="modal-title-topUp"> Edit Time </h6>

                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fal fa-times text-dark fs-4"></i>
                            </button>

                        </div>
                        <div class="modal-body text-center" id="topUpBody">

                        </div>

                    </div>
                </div>
            </div>



            <!-- Print Modal -->
            <div class="modal fade" id="modal-print" tabindex="-1" role="dialog" aria-labelledby="modal-print"
                 aria-hidden="true">
                <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h6 class="modal-title" id="modal-title-print">Print Ticket</h6>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                <i class="fal fa-times text-dark fs-4"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="py-3 text-center">
                                <i class="fad fa-print fa-4x"></i>
                                <h5 class="text-gradient text-dark mt-4">Is receipt printed correctly ?</h5>
                                <!-- <p>Is receipt printed correctly ?</p> -->
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" data-bs-dismiss="modal">Yes</button>
                            <button type="button" id="print"
                                    data-url="{{$type=='rev'?route('reservations.show',$ticket->id):route('ticket.edit',$ticket->id)}}" class="btn btn-link text-dark ml-auto">No</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.print.iframe')
    @endif
@endsection
@section('js')
    {{--================= custom js ==================--}}
    @include('sales.layouts.customJs.exit')
@endsection
