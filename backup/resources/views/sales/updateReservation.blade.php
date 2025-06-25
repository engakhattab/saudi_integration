{{--@extends('sales.layouts.master')--}}
{{--@section('page_title')--}}
{{--    {{$setting->title}} | Edit Reservation--}}
{{--@endsection--}}
{{--@section('content')--}}
{{--    <h2 class="MainTiltle mb-5 ms-4"> Edit Reservation </h2>--}}

{{--    <div class="multisteps-form">--}}
{{--        <form action="{{route('reservations.update',$rev->id)}}" method="POST" enctype="multipart/form-data"--}}
{{--              class="row">--}}
{{--            @csrf--}}
{{--            @method('PUT')--}}
{{--            <input type="hidden" id="rev_id" name="rev_id" value="{{$rev->id}}">--}}
{{--            <input type="hidden" id="visit_date" name="visit_date" value="{{$rev->day}}">--}}
{{--            <div class="col-lg-9 p-1 ">--}}
{{--                <div class="multisteps-form__progress mb-5">--}}
{{--                    <button type="button"--}}
{{--                            class="multisteps-form__progress-btn ReservationInfo-multisteps-form__progress-btn js-active"--}}
{{--                            title="ReservationInfo"> Reservation Info--}}
{{--                    </button>--}}
{{--                    <button type="button" class="multisteps-form__progress-btn visitors-multisteps-form__progress-btn"--}}
{{--                            title="visitors"> visitors--}}
{{--                    </button>--}}
{{--                    <button type="button" class="multisteps-form__progress-btn products-multisteps-form__progress-btn"--}}
{{--                            title="products"> products--}}
{{--                    </button>--}}
{{--                    <button type="button" class="multisteps-form__progress-btn payment-multisteps-form__progress-btn"--}}
{{--                            title="payment"> payment--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--                <div class="multisteps-form__form mb-2">--}}
{{--                    <!-- step 1 -->--}}
{{--                    <div class="card multisteps-form__panel ReservationInfo-multisteps-form__panel p-3 border-radius-xl bg-white js-active"--}}
{{--                        validate="true" id="ticketTab" data-animation="FadeIn">--}}
{{--                        <h5 class="font-weight-bolder">Reservation Info</h5>--}}
{{--                        <div class="multisteps-form__content">--}}
{{--                            <div class="row mt-3">--}}
{{--                                <div class="col-sm-6 p-2">--}}
{{--                                    <label>Client Name </label>--}}
{{--                                    <input class="form-control" type="text" value="{{$rev->client_name}}"--}}
{{--                                           name="client_name" id="client_name">--}}
{{--                                    <label id="client_nameError" class="text-danger"></label>--}}
{{--                                </div>--}}
{{--                                <div class="col-sm-6 p-2">--}}
{{--                                    <label>Phone </label>--}}
{{--                                    <input class="form-control" type="text" value="{{$rev->phone}}"--}}
{{--                                           name="phone" id="phone">--}}
{{--                                    <label id="phoneError" class="text-danger"></label>--}}
{{--                                </div>--}}
{{--                                <div class="col-sm-12">--}}
{{--                                    <label>Email </label>--}}
{{--                                    <input class="form-control" type="email" value="{{$rev->email}}"--}}
{{--                                           name="email" id="email">--}}
{{--                                    <label id="emailError" class="text-danger"></label>--}}
{{--                                </div>--}}
{{--                                <div class="col-sm-12">--}}
{{--                                    <label class="form-label"> <i class="fas fa-feather-alt me-1"></i> Note </label>--}}
{{--                                    <textarea name="notes" id="note" class="form-control" rows="6"--}}
{{--                                              placeholder="Add Note...">{{$rev->note}}</textarea>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            --}}{{--                            <div class="row mt-3">--}}
{{--                            --}}{{--                                <div class="col-sm-6 p-2">--}}
{{--                            --}}{{--                                    <label style="text-transform: initial !important;">Reservation Duration (h) </label>--}}
{{--                            --}}{{--                                    <input class="form-control" type="number" value="{{$rev->hours_count}}"--}}
{{--                            --}}{{--                                           name="duration" onchange="checkTime()"--}}
{{--                            --}}{{--                                           id="duration" min="1" max="24"--}}
{{--                            --}}{{--                                           onKeyUp="if(this.value>24){this.value='24';}else if(this.value<=0){this.value='1';}$('#durationError').text('')"/>--}}
{{--                            --}}{{--                                    <label id="durationError" class="text-danger"></label>--}}
{{--                            --}}{{--                                </div>--}}
{{--                            --}}{{--                                <input class="form-control" type="hidden" id="date" value="{{$rev->day}}"--}}
{{--                            --}}{{--                                       name="visit_date"/>--}}
{{--                            --}}{{--                                <input type="hidden" id="first_shift_start" value="{{$first_shift_start}}">--}}
{{--                            --}}{{--                                <input type="hidden" id="start" value="">--}}
{{--                            --}}{{--                                <div class="col-sm-6 p-2">--}}
{{--                            --}}{{--                                    <label class="form-label"> shift </label>--}}
{{--                            --}}{{--                                    <select class="form-control" id="choices_times" name="choices_times">--}}

{{--                            --}}{{--                                    </select>--}}
{{--                            --}}{{--                                </div>--}}
{{--                            --}}{{--                                <div class="col-sm-12 p-2">--}}
{{--                            --}}{{--                                    <label class="form-label"> <i class="fas fa-feather-alt me-1"></i> Note </label>--}}
{{--                            --}}{{--                                    <textarea name="notes" id="note" class="form-control" rows="6"--}}
{{--                            --}}{{--                                              placeholder="Add Note...">{{$rev->note}}</textarea>--}}
{{--                            --}}{{--                                </div>--}}
{{--                            --}}{{--                            </div>--}}
{{--                            <div class="button-row d-flex mt-4">--}}
{{--                                <button class="btn bg-gradient-dark ms-auto mb-0 js-btn-next" type="button"--}}
{{--                                        id="firstNext">Next--}}
{{--                                </button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <!-- step 2 -->--}}
{{--                    <div class="card multisteps-form__panel p-3 border-radius-xl bg-white " id="visitorsTab"--}}
{{--                         data-animation="FadeIn">--}}
{{--                        <h5 class="font-weight-bolder">visitors</h5>--}}
{{--                        <div class="multisteps-form__content">--}}
{{--                            <div class="row mt-3">--}}
{{--                                <!-- visitor Type  -->--}}
{{--                                <small class="form-text text-muted mb-1"><i class="fa fa-arrow-right text-warning"></i>--}}
{{--                                    Enter a number to add many rows</small>--}}
{{--                                <div class="col-10 p-2">--}}
{{--                                    @foreach($types as $type)--}}
{{--                                        <div class="visitorType visitorType{{$type->id}}">--}}
{{--                                            <div class="visitorTypeDiv">--}}
{{--                                                <img src="{{get_file($type->photo)}}" alt="{{$type->title}}"--}}
{{--                                                     title="{{$type->title}}">--}}
{{--                                                <span class="visitor">{{$type->title}}</span>--}}
{{--                                                <span--}}
{{--                                                    class="count">{{$models->where('rev_id',$rev->id)->where('visitor_type_id',$type->id)->count()}}</span>--}}
{{--                                                <input type="hidden"--}}
{{--                                                       value="{{($prices->where('visitor_type_id',$type->id)->first()->price) ?? null}}"--}}
{{--                                                       name="price[]" id="price{{$type->id}}">--}}
{{--                                                <input type="hidden" value="{{$type->id}}"--}}
{{--                                                       id="visitor_type_id">--}}
{{--                                            </div>--}}
{{--                                            <div class="countInput">--}}
{{--                                                <input type="text" id="countInput" class="inputCount" min="0" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');"--}}
{{--                                                       value="{{$models->where('rev_id',$rev->id)->where('visitor_type_id',$type->id)->count()}}"/>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    @endforeach--}}
{{--                                </div>--}}
{{--                                <div class="col-2">--}}
{{--                                    <button class="btn btn-danger" type="button" onclick="DeleteRows()"><i--}}
{{--                                            class="fal fa-trash me-2"></i> Clear--}}
{{--                                    </button>--}}
{{--                                </div>--}}
{{--                                <!-- table -->--}}
{{--                                <div class="col-12 p-2 position-relative">--}}
{{--                                    <table class="firstTable  customDataTable table table-bordered nowrap">--}}
{{--                                        <thead>--}}
{{--                                        <tr>--}}
{{--                                            <th>Type</th>--}}
{{--                                            <th>price</th>--}}
{{--                                            <th>Name</th>--}}
{{--                                            <th>Birthday</th>--}}
{{--                                            <th>Gender</th>--}}
{{--                                            <th>Actions</th>--}}
{{--                                        </tr>--}}
{{--                                        </thead>--}}
{{--                                        <tbody id="visitorTable">--}}
{{--                                        @foreach($models as $model)--}}
{{--                                            <tr class="{{$model->type->title}}">--}}
{{--                                                <td><span data-type_id="{{$model->type->id}}"--}}
{{--                                                          id="visitor_type[]">{{$model->type->title}}</span></td>--}}
{{--                                                <td><span data-price="{{$model->price}}"--}}
{{--                                                          id="visitor_price[]">{{$model->price}}</span></td>--}}
{{--                                                <td><input type="text" class="form-control" placeholder="Name"--}}
{{--                                                           name="visitor_name[]" value="{{$model->name}}"></td>--}}
{{--                                                <td><input type="date" class="form-control" name="visitor_birthday[]"--}}
{{--                                                           id="visitor_birthday[]" value="{{$model->birthday}}"></td>--}}
{{--                                                <td>--}}
{{--                                                    <div class="choose">--}}
{{--                                                        <div class="genderOption">--}}
{{--                                                            <input type="radio" class="btn-check gender" name="gender{{$model->id}}"--}}
{{--                                                                   value="male" id="option1{{$model->id}}" {{($model->gender == 'male') ? 'checked' : ''}}>--}}
{{--                                                            <label class=" mb-0 btn btn-outline" for="option1{{$model->id}}">--}}
{{--                                                                <span> <i class="fas fa-male"></i> </span>--}}
{{--                                                            </label>--}}
{{--                                                        </div>--}}
{{--                                                        <div class="genderOption">--}}
{{--                                                            <input type="radio" class="btn-check gender" name="gender{{$model->id}}"--}}
{{--                                                                   value="female" id="option2{{$model->id}}" {{($model->gender == 'female') ? 'checked' : ''}}>--}}
{{--                                                            <label class=" mb-0 btn btn-outline" for="option2{{$model->id}}">--}}
{{--                                                                <span> <i class="fas fa-female"></i> </span>--}}
{{--                                                                <!-- <span> female </span> -->--}}
{{--                                                            </label>--}}
{{--                                                        </div>--}}
{{--                                                    </div>--}}
{{--                                                </td>--}}
{{--                                                <td>--}}
{{--                                                    <span class="controlIcons">--}}
{{--                                                    <span class="icon Delete"--}}
{{--                                                          data-model_id="{{$model->type->id}}"> <i--}}
{{--                                                            class="far fa-trash-alt"></i> </span>--}}
{{--                                                    </span>--}}
{{--                                                </td>--}}
{{--                                            </tr>--}}
{{--                                        @endforeach--}}
{{--                                        </tbody>--}}
{{--                                    </table>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="button-row d-flex mt-4">--}}
{{--                                <button class="btn bg-gradient-secondary mb-0 js-btn-prev" type="button"--}}
{{--                                        id="secondPrev">Prev--}}
{{--                                </button>--}}
{{--                                <button class="btn bg-gradient-dark ms-auto mb-0 js-btn-next" type="button"--}}
{{--                                        id="secondNext">Next--}}
{{--                                </button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <!-- step 3 -->--}}
{{--                    <div class="card multisteps-form__panel p-3 border-radius-xl bg-white " id="productsTab"--}}
{{--                         data-animation="FadeIn">--}}
{{--                        <h5 class="font-weight-bolder">products</h5>--}}
{{--                        <div class="multisteps-form__content">--}}
{{--                            <div class="row mt-3 align-items-end">--}}
{{--                                <div class="col-md-5 p-2">--}}
{{--                                    <label class="form-label"> category </label>--}}
{{--                                    <select class="form-control" id="choices-category">--}}
{{--                                        <option value="" disabled selected>Choose The Category</option>--}}
{{--                                        {!! optionForEach($categories,'id','title') !!}--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                                <div class="col-md-5 p-2">--}}
{{--                                    <label class="form-label"> product </label>--}}
{{--                                    <select class="form-control" id="choices-product">--}}
{{--                                        <option value="" disabled selected>Choose The Product</option>--}}
{{--                                    </select>--}}
{{--                                </div>--}}
{{--                                <div class="col-md-2 p-2">--}}
{{--                                    <button type="button" class="btn btn-success w-100 " id="addBtn"> ADD</button>--}}
{{--                                </div>--}}
{{--                                <div class="col-md-12 p-2  pt-5">--}}
{{--                                    <table class=" customDataTable table table-bordered nowrap" id="myNewTable">--}}
{{--                                        <thead>--}}
{{--                                        <tr>--}}
{{--                                            <th>Type</th>--}}
{{--                                            <th>price</th>--}}
{{--                                            <th>Quantity</th>--}}
{{--                                            <th>Total Price</th>--}}
{{--                                            <th>Actions</th>--}}
{{--                                        </tr>--}}
{{--                                        </thead>--}}
{{--                                        <tbody>--}}
{{--                                        @foreach($products as $product)--}}
{{--                                            <tr class="productrow{{$product->product_id}}">--}}
{{--                                                <td>--}}
{{--                                                    <span id="spanProductId"--}}
{{--                                                          data-product_id="{{$product->product_id}}">{{$product->product->title}}</span>--}}
{{--                                                </td>--}}
{{--                                                <td>--}}
{{--                                                    <span class="price"--}}
{{--                                                          id="price{{$product->product_id}}">{{$product->price}}</span>--}}
{{--                                                </td>--}}
{{--                                                <td>--}}
{{--                                                    <div class="countInput">--}}
{{--                                                        <button type="button" class=" sub" id="subBtn">-</button>--}}
{{--                                                        <input type="number" disabled id="qtyVal{{$product->product_id}}"--}}
{{--                                                               class="qtyVal" value="{{$product->qty}}" min="1"/>--}}
{{--                                                        <button type="button" class=" add plusBtn" id="plusBtn">+--}}
{{--                                                        </button>--}}
{{--                                                    </div>--}}
{{--                                                </td>--}}
{{--                                                <td>--}}
{{--                                                    <span class="productTotalPrice"--}}
{{--                                                          id="productTotalPrice{{$product->product_id}}">{{$product->total_price}}</span>--}}
{{--                                                </td>--}}
{{--                                                <td>--}}
{{--                                                    <span class="controlIcons">--}}
{{--                                                      <span class="icon Delete">--}}
{{--                                                          <i class="far fa-trash-alt"></i>--}}
{{--                                                      </span>--}}
{{--                                                    </span>--}}
{{--                                                </td>--}}
{{--                                            </tr>--}}
{{--                                        @endforeach--}}
{{--                                        </tbody>--}}
{{--                                    </table>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="row">--}}
{{--                            <div class="button-row d-flex mt-4">--}}
{{--                                <button class="btn bg-gradient-secondary mb-0 js-btn-prev" type="button" id="thirdPrev">--}}
{{--                                    Prev--}}
{{--                                </button>--}}
{{--                                <button class="btn bg-gradient-dark ms-auto mb-0 js-btn-next" type="button"--}}
{{--                                        id="thirdNext">Next--}}
{{--                                </button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <!-- step 4 -->--}}
{{--                    <div class="card multisteps-form__panel p-3 border-radius-xl bg-white " data-animation="FadeIn">--}}
{{--                        <h5 class="font-weight-bolder">old costs</h5>--}}
{{--                        <div class="multisteps-form__content">--}}
{{--                            <div class="row   mt-3">--}}
{{--                                <div class="col-12 p-2">--}}
{{--                                    <div class="screens row">--}}
{{--                                        <div class="screen col">--}}
{{--                                            <span>old total</span>--}}
{{--                                            <strong id="oldTotal">{{$rev->total_price}}</strong>--}}
{{--                                        </div>--}}
{{--                                        <div class="screen col">--}}
{{--                                            <span>discount</span>--}}
{{--                                            <strong id="oldDiscount"> {{$rev->discount_value}} {{($rev->discount_type == 'per') ? '%' : ''}} </strong>--}}
{{--                                        </div>--}}
{{--                                        <div class="screen col">--}}
{{--                                            <span>Amount to Pay</span>--}}
{{--                                            <strong id="oldRevenue"> {{$rev->grand_total}}</strong>--}}
{{--                                        </div>--}}
{{--                                        <div class="screen col">--}}
{{--                                            <span>paid</span>--}}
{{--                                            <strong id="oldPaid"> {{$rev->paid_amount}}</strong>--}}
{{--                                        </div>--}}
{{--                                        <div class="screen col">--}}
{{--                                            <span>dues</span>--}}
{{--                                            <strong id="oldDues"> {{$rev->rem_amount}}</strong>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            @if($rev->discount_value != 0)--}}
{{--                                <label class="form-label"><i class="fa fa-tag pt-2"></i> Discount Reason </label>--}}
{{--                                <span>{{($rev->reason->desc) ?? ''}}</span>--}}
{{--                            @endif--}}
{{--                        </div>--}}

{{--                        <h5 class="font-weight-bolder mt-2">payment</h5>--}}
{{--                        <div class="multisteps-form__content">--}}
{{--                            <div class="row   mt-3">--}}
{{--                                <div class="col-12 p-2">--}}
{{--                                    <div class="screens row">--}}
{{--                                        <div class="screen col">--}}
{{--                                            <span>total</span>--}}
{{--                                            <strong id="totalPrice"> </strong>--}}
{{--                                        </div>--}}
{{--                                        <div class="screen col">--}}
{{--                                            <span>discount</span>--}}
{{--                                            <strong id="discount"> 0 </strong>--}}
{{--                                        </div>--}}
{{--                                        <div class="screen col">--}}
{{--                                            <span>Amount to Pay</span>--}}
{{--                                            <strong id="revenue"> </strong>--}}
{{--                                        </div>--}}
{{--                                        <div class="screen col">--}}
{{--                                            <span>paid</span>--}}
{{--                                            <strong id="paid"> {{$rev->paid_amount}} </strong>--}}
{{--                                        </div>--}}
{{--                                        <div class="screen col">--}}
{{--                                            <span>change</span>--}}
{{--                                            <strong id="change"> 0</strong>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="col-12 p-2">--}}
{{--                                    <div class="row align-items-end">--}}
{{--                                        <div class="col-md-6 p-2">--}}
{{--                                            <label class="form-label"> Discount Value </label>--}}
{{--                                            <input type="number" class="form-control" id="calcDiscount" step="any">--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-6 p-2 discType">--}}
{{--                                            <label class="form-label d-block"> Discount Type </label>--}}
{{--                                            <div class="form-check d-inline-block py-2 mx-2 ">--}}
{{--                                                <input class="form-check-input " type="radio" name="offerType"--}}
{{--                                                       id="offerType1" value="per">--}}
{{--                                                <label class="form-check-label" for="offerType1"> Percent </label>--}}
{{--                                            </div>--}}
{{--                                            <div class="form-check d-inline-block py-2 mx-2 ">--}}
{{--                                                <input class="form-check-input " type="radio" name="offerType"--}}
{{--                                                       id="offerType2" value="val">--}}
{{--                                                <label class="form-check-label" for="offerType2"> Amount </label>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-12 p-2" id="reasonDiv" style="display: none">--}}
{{--                                            <label class="form-label"> Discount Reason </label>--}}
{{--                                            <select class="form-control" id="choices-discount">--}}
{{--                                                <option value="" disabled selected>-- Select The Reason Of The Discount --</option>--}}
{{--                                                {!! optionForEach($discounts,'id','desc') !!}--}}
{{--                                            </select>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                                <div class="col-12 p-2">--}}
{{--                                    <label class="form-label ">payment method</label>--}}
{{--                                    <div class="choose">--}}
{{--                                        --}}{{--  PAYMENT--}}
{{--                                        <div class="genderOption payment m-1">--}}
{{--                                            <input type="radio" class="btn-check" name="payment" value="cash" checked--}}
{{--                                                   id="option1">--}}
{{--                                            <label class=" mb-0 btn btn-outline" for="option1">--}}

{{--                                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1"--}}
{{--                                                     xmlns:xlink="http://www.w3.org/1999/xlink"--}}
{{--                                                     xmlns:svgjs="http://svgjs.com/svgjs" width="512"--}}
{{--                                                     height="512" x="0" y="0" viewBox="0 0 512 512"--}}
{{--                                                     style="enable-background:new 0 0 512 512"--}}
{{--                                                     xml:space="preserve">--}}
{{--                            <g>--}}
{{--                                <g xmlns="http://www.w3.org/2000/svg">--}}
{{--                                    <path--}}
{{--                                        d="m512 256c0 140.918-112.835 254.779-253.748 255.991-46.334.398-89.854-11.513-127.487-32.662-3.054-1.716-4.991-4.871-5.232-8.366-3.792-55.004-43.503-100.128-95.847-112.086-5.833-1.332-10.599-5.517-12.744-11.102-10.944-28.49-16.942-59.432-16.942-91.775 0-141.787 114.115-255.947 255.902-256 141.43-.053 256.098 114.582 256.098 256z"--}}
{{--                                        fill="#F44545" data-original="#f44545"></path>--}}
{{--                                    <path--}}
{{--                                        d="m467 231c0 102.725-83.275 186-186 186s-186-83.275-186-186 83.275-186 186-186 186 83.275 186 186z"--}}
{{--                                        fill="#FB5858" data-original="#fb5858"></path>--}}
{{--                                    <path--}}
{{--                                        d="m401.977 213.63-2.494 2.494c-5.288 5.288-13.542 5.802-19.407 1.543 4.259 5.865 3.745 14.119-1.543 19.407l-2.495 2.494c-5.288 5.288-13.542 5.802-19.407 1.543 4.259 5.865 3.745 14.119-1.543 19.407l-2.494 2.494c-5.288 5.288-13.542 5.802-19.406 1.543 4.259 5.865 3.745 14.119-1.543 19.407l-2.494 2.494c-5.858 5.858-15.355 5.858-21.213 0l-54.651-54.651c-5.858-5.858-5.858-15.355 0-21.213l2.494-2.494c5.288-5.288 13.542-5.802 19.407-1.543-4.259-5.865-3.745-14.119 1.543-19.407l2.494-2.494c5.288-5.288 13.542-5.802 19.407-1.543-4.259-5.865-3.745-14.119 1.543-19.407l2.494-2.494c5.288-5.288 13.542-5.802 19.407-1.543-4.259-5.865-3.745-14.119 1.543-19.407l2.495-2.494c5.858-5.858 15.355-5.858 21.213 0l54.651 54.651c5.857 5.858 5.857 15.356-.001 21.213z"--}}
{{--                                        fill="#E09380" data-original="#e09380"></path>--}}
{{--                                    <path--}}
{{--                                        d="m280.612 244.907 22.917 22.917-158.841 158.842-83.767-83.767 97.987-97.987c2.618-2.618 4.81-5.63 6.496-8.927l38.65-75.583c5.291-10.346 15.316-17.442 26.833-18.993l105.833-14.25 16.725 16.725-70.472 70.472 14.094 14.094z"--}}
{{--                                        fill="#FFBEAA" data-original="#ffbeaa"></path>--}}
{{--                                    <path--}}
{{--                                        d="m353.445 143.885-3.111 3.111-105.15 14.158c-11.516 1.551-21.542 8.647-26.832 18.993l-38.65 75.583c-1.686 3.297-3.878 6.309-6.496 8.927l-95.264 95.263-17.021-17.021 97.987-97.987c2.618-2.618 4.81-5.63 6.496-8.927l38.65-75.583c5.291-10.346 15.316-17.442 26.833-18.993l105.833-14.25z"--}}
{{--                                        fill="#FAA68E" data-original="#faa68e"></path>--}}
{{--                                    <path--}}
{{--                                        d="m447.523 165.268-128.811 55.492c-.114-.154-.228-.309-.343-.463-23.739-31.968-40.239-68.717-48.353-107.699l-10.157-48.79c-.424-2.039.644-4.095 2.557-4.919l120.594-51.952c2.547-1.097 5.46.417 6.025 3.132l9.792 47.037c8.115 38.982 24.614 75.732 48.353 107.699.114.154.228.308.343.463z"--}}
{{--                                        fill="#71892E" data-original="#71892e"></path>--}}
{{--                                    <path--}}
{{--                                        d="m453.72 162.598-12.399 5.342c-23.832-32.333-40.745-70.172-48.931-109.494l-9.245-44.408-116.485 50.181 9.792 47.039c7.866 37.785 24.187 74.135 47.196 105.12.423.57.844 1.141 1.262 1.713l-12.399 5.342c-23.832-32.332-40.745-70.173-48.931-109.494l-10.157-48.79c-1.056-5.074 1.632-10.245 6.392-12.296l120.593-51.954c3.035-1.308 6.457-1.183 9.389.341 2.267 1.178 4.017 3.076 5.006 5.372.291.674.515 1.383.668 2.117l9.792 47.037c7.866 37.785 24.187 74.135 47.196 105.12.423.569.843 1.14 1.261 1.712z"--}}
{{--                                        fill="#9BCF1B" data-original="#9bcf1b"></path>--}}
{{--                                    <path--}}
{{--                                        d="m457.717 105.14c-7.713 37.75-7.388 76.686.935 114.277.278 1.256-5.76 4.326-5.76 4.326h-24.577l-10.294-6.7-56.48 1.223-15.393 5.478h-26.76c-.044-.187-.087-.374-.132-.561-9.154-38.752-9.767-79.03-1.796-118.042l9.976-48.828c.417-2.04 2.212-3.505 4.294-3.505h131.31c2.773 0 4.849 2.543 4.294 5.26z"--}}
{{--                                        fill="#7FA32F" data-original="#7fa32f"></path>--}}
{{--                                    <path--}}
{{--                                        d="m474 57.174c0 .734-.074 1.474-.224 2.209l-9.618 47.073c-7.106 34.781-7.163 71.276-.222 106.134.006.03.012.061.018.093 1.146 5.716-3.211 11.06-9.041 11.06h-2.021c-9.094-39.123-9.656-80.567-1.617-119.92l9.08-44.442h-126.834l-9.618 47.075c-7.866 38.504-7.094 79.111 2.248 117.27-.006.008-.007.009-.013.017h-13.501c-9.095-39.123-9.656-80.568-1.617-119.92l9.977-48.827c1.042-5.101 5.529-8.764 10.735-8.764h131.013c2.932 0 5.817 1.037 7.917 3.083 2.174 2.118 3.338 4.945 3.338 7.859z"--}}
{{--                                        fill="#B9E746" data-original="#b9e746"></path>--}}
{{--                                    <path--}}
{{--                                        d="m428.315 223.743h-82.166c-.567-2.725 3.61-5.447 2.968-8.165-6.18-26.16-7.953-53.537-5.293-80.372h78.661c-.637 8.066-.955 16.164-.955 24.261 0 21.613 2.264 43.226 6.785 64.276z"--}}
{{--                                        fill="#9BCF1B" data-original="#9bcf1b"></path>--}}
{{--                                    <path--}}
{{--                                        d="m428.086 126.441c0 24.207-19.623 43.83-43.83 43.83s-43.83-19.623-43.83-43.83 19.623-43.83 43.83-43.83 43.83 19.623 43.83 43.83z"--}}
{{--                                        fill="#B9E746" data-original="#b9e746"></path>--}}
{{--                                    <path--}}
{{--                                        d="m410.554 126.441c0 14.524-11.774 26.298-26.298 26.298s-26.298-11.774-26.298-26.298 11.774-26.298 26.298-26.298 26.298 11.774 26.298 26.298z"--}}
{{--                                        fill="#CAED73" data-original="#caed73"></path>--}}
{{--                                    <path--}}
{{--                                        d="m410.554 126.441c0 3.06-.523 5.998-1.484 8.729-2.731.961-5.669 1.484-8.729 1.484-14.524 0-26.298-11.774-26.298-26.298 0-3.06.523-5.998 1.484-8.729 2.731-.961 5.669-1.484 8.729-1.484 14.524 0 26.298 11.774 26.298 26.298z"--}}
{{--                                        fill="#DBF3A0" data-original="#dbf3a0"></path>--}}
{{--                                    <path--}}
{{--                                        d="m399.607 171.747-106.808 106.808c-5.858 5.858-15.355 5.858-21.213 0l-2.494-2.494c-5.858-5.858-5.858-15.355 0-21.213l106.808-106.808c5.858-5.858 15.355-5.858 21.213 0l2.495 2.494c5.856 5.858 5.856 15.355-.001 21.213z"--}}
{{--                                        fill="#FFBEAA" data-original="#ffbeaa"></path>--}}
{{--                                    <path--}}
{{--                                        d="m312.863 232.106h-54.383v-50.043h28.812c3.07 6.166 6.364 12.218 9.871 18.137l-7.505 7.505c-3.674 3.674-3.674 9.63 0 13.304 3.674 3.674 9.63 3.674 13.304 0l4.584-4.584c1.63 2.363 3.296 4.699 4.997 7.007z"--}}
{{--                                        fill="#FFBEAA" data-original="#ffbeaa"></path>--}}
{{--                                    <path--}}
{{--                                        d="m400.564 158.936-5.198 5.198c-2.929 2.929-7.678 2.929-10.607 0l-1.247-1.247c-2.929-2.929-2.929-7.678 0-10.607l5.198-5.198c2.929-2.929 7.678-2.929 10.606 0l1.247 1.247c2.929 2.93 2.929 7.678.001 10.607z"--}}
{{--                                        fill="#FFF5F5" data-original="#fff5f5"></path>--}}
{{--                                    <path--}}
{{--                                        d="m50.372 328.439 56.149-56.149c1.953-1.953 5.118-1.953 7.071 0l30.247 30.247c1.953 1.953 1.953 5.118 0 7.071l-56.149 56.149c-1.953 1.953-5.118 1.953-7.071 0l-30.247-30.247c-1.953-1.953-1.953-5.118 0-7.071z"--}}
{{--                                        fill="#DCE6EB" data-original="#dce6eb"></path>--}}
{{--                                    <path--}}
{{--                                        d="m75.434 353.502 56.149-56.149c1.953-1.953 5.118-1.953 7.071 0l76.642 76.642c1.953 1.953 1.953 5.118 0 7.071l-56.149 56.149c-1.953 1.953-5.118 1.953-7.071 0l-76.642-76.642c-1.952-1.953-1.952-5.119 0-7.071z"--}}
{{--                                        fill="#FFF5F5" data-original="#fff5f5"></path>--}}
{{--                                    <path--}}
{{--                                        d="m198.841 404.954c1.953 1.953 1.953 5.118 0 7.071l-67.581 67.581c-52.046-29.097-92.889-75.838-114.432-132.128l58.733-58.733c1.953-1.953 5.119-1.953 7.071 0z"--}}
{{--                                        fill="#2E5AAC" data-original="#2e5aac"></path>--}}
{{--                                    <path--}}
{{--                                        d="m38.186 390.576c-8.405-13.574-15.576-27.992-21.357-43.097l58.733-58.733c1.953-1.953 5.119-1.953 7.071 0l28.692 28.692z"--}}
{{--                                        fill="#274C91" data-original="#274c91"></path>--}}
{{--                                    <path--}}
{{--                                        d="m174.206 415.881c-3.273 3.273-8.581 3.273-11.854 0s-3.273-8.581 0-11.854 8.58-3.273 11.854 0 3.274 8.581 0 11.854z"--}}
{{--                                        fill="#FFB52D" data-original="#ffb52d"></path>--}}
{{--                                </g>--}}
{{--                            </g>--}}
{{--                          </svg>--}}
{{--                                                <span class="ms-2"> cash </span>--}}

{{--                                            </label>--}}
{{--                                        </div>--}}
{{--                                        --}}{{--  PAYMENT--}}
{{--                                        <div class="genderOption payment m-1">--}}
{{--                                            <input type="radio" class="btn-check" name="payment" value="visa"--}}
{{--                                                   id="option2">--}}
{{--                                            <label class=" mb-0 btn btn-outline" for="option2">--}}
{{--                                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1"--}}
{{--                                                     xmlns:xlink="http://www.w3.org/1999/xlink"--}}
{{--                                                     xmlns:svgjs="http://svgjs.com/svgjs" width="512"--}}
{{--                                                     height="512" x="0" y="0" viewBox="0 0 473.96 473.96"--}}
{{--                                                     style="enable-background:new 0 0 512 512" xml:space="preserve">--}}
{{--                            <g>--}}
{{--                                <circle xmlns="http://www.w3.org/2000/svg" style="" cx="236.98" cy="236.99" r="236.97"--}}
{{--                                        fill="#F3F2F2" data-original="#f3f2f2"></circle>--}}
{{--                                <g xmlns="http://www.w3.org/2000/svg">--}}
{{--                                    <polygon style=""--}}
{{--                                             points="175.483,282.447 193.616,175.373 222.973,175.373 204.841,282.447  "--}}
{{--                                             fill="#293688" data-original="#293688"></polygon>--}}
{{--                                    <path style=""--}}
{{--                                          d="M309.352,178.141c-5.818-2.17-14.933-4.494-26.316-4.494c-29.014,0-49.451,14.526-49.627,35.337   c-0.161,15.382,14.589,23.962,25.732,29.088c11.427,5.238,15.27,8.599,15.214,13.28c-0.071,7.177-9.13,10.458-17.571,10.458   c-11.749-0.004-17.994-1.624-27.637-5.62l-3.783-1.706l-4.123,23.97c6.859,2.99,19.543,5.583,32.71,5.714   c30.858-0.007,50.899-14.353,51.124-36.583c0.112-12.179-7.712-21.448-24.651-29.092c-10.264-4.947-16.55-8.251-16.482-13.272   c0-4.449,5.324-9.208,16.815-9.208c9.601-0.15,16.557,1.931,21.979,4.101l2.627,1.235L309.352,178.141L309.352,178.141z"--}}
{{--                                          fill="#293688" data-original="#293688"></path>--}}
{{--                                    <path style=""--}}
{{--                                          d="M359.405,175.373c-7.034,0-12.116,2.148-15.207,9.119l-43.509,97.959h31.083l6.043-16.408h37.137   l3.45,16.408h27.633L381.86,175.376h-22.454L359.405,175.373L359.405,175.373z M346.062,244.618   c2.425-6.166,11.693-29.927,11.693-29.927c-0.168,0.281,2.413-6.196,3.895-10.215l1.987,9.227c0,0,5.616,25.56,6.795,30.918h-24.37   V244.618z"--}}
{{--                                          fill="#293688" data-original="#293688"></path>--}}
{{--                                    <path style=""--}}
{{--                                          d="M121.946,248.771l-2.586-14.679c-5.358-17.111-21.987-35.625-40.621-44.901l25.938,93.256h31.09   l46.626-107.074H151.31L121.946,248.771z"--}}
{{--                                          fill="#293688" data-original="#293688"></path>--}}
{{--                                </g>--}}
{{--                                <g xmlns="http://www.w3.org/2000/svg">--}}
{{--                                    <path style=""--}}
{{--                                          d="M46.823,175.373v1.729c36.838,8.86,62.413,31.259,72.538,56.991l-10.645-49.582   c-1.777-6.776-7.162-8.902-13.534-9.137L46.823,175.373L46.823,175.373z"--}}
{{--                                          fill="#F7981D" data-original="#f7981d"></path>--}}
{{--                                    <path style=""--}}
{{--                                          d="M236.964,473.958c91.464,0,170.77-51.846,210.272-127.725H26.696   C66.201,422.112,145.504,473.958,236.964,473.958z"--}}
{{--                                          fill="#F7981D" data-original="#f7981d"></path>--}}
{{--                                </g>--}}
{{--                                <path xmlns="http://www.w3.org/2000/svg" style=""--}}
{{--                                      d="M236.964,0C146.952,0,68.663,50.184,28.548,124.103h416.84C405.268,50.188,326.976,0,236.964,0z"--}}
{{--                                      fill="#293688" data-original="#293688"></path>--}}
{{--                                <g xmlns="http://www.w3.org/2000/svg">--}}
{{--                                </g>--}}
{{--                                <g xmlns="http://www.w3.org/2000/svg">--}}
{{--                                </g>--}}
{{--                                <g xmlns="http://www.w3.org/2000/svg">--}}
{{--                                </g>--}}
{{--                                <g xmlns="http://www.w3.org/2000/svg">--}}
{{--                                </g>--}}
{{--                                <g xmlns="http://www.w3.org/2000/svg">--}}
{{--                                </g>--}}
{{--                                <g xmlns="http://www.w3.org/2000/svg">--}}
{{--                                </g>--}}
{{--                                <g xmlns="http://www.w3.org/2000/svg">--}}
{{--                                </g>--}}
{{--                                <g xmlns="http://www.w3.org/2000/svg">--}}
{{--                                </g>--}}
{{--                                <g xmlns="http://www.w3.org/2000/svg">--}}
{{--                                </g>--}}
{{--                                <g xmlns="http://www.w3.org/2000/svg">--}}
{{--                                </g>--}}
{{--                                <g xmlns="http://www.w3.org/2000/svg">--}}
{{--                                </g>--}}
{{--                                <g xmlns="http://www.w3.org/2000/svg">--}}
{{--                                </g>--}}
{{--                                <g xmlns="http://www.w3.org/2000/svg">--}}
{{--                                </g>--}}
{{--                                <g xmlns="http://www.w3.org/2000/svg">--}}
{{--                                </g>--}}
{{--                                <g xmlns="http://www.w3.org/2000/svg">--}}
{{--                                </g>--}}
{{--                            </g>--}}
{{--                          </svg>--}}
{{--                                                <span class="ms-2"> visa </span>--}}
{{--                                            </label>--}}
{{--                                        </div>--}}
{{--                                        --}}{{--  PAYMENT--}}
{{--                                        <div class="genderOption payment m-1">--}}
{{--                                            <input type="radio" class="btn-check" name="payment" value="mastercard"--}}
{{--                                                   id="option3">--}}
{{--                                            <label class=" mb-0 btn btn-outline" for="option3">--}}
{{--                                                <svg viewBox="0 0 256 199" version="1.1" xmlns="http://www.w3.org/2000/svg"--}}
{{--                                                     xmlns:xlink="http://www.w3.org/1999/xlink"--}}
{{--                                                     preserveAspectRatio="xMidYMid">--}}
{{--                                                    <g>--}}
{{--                                                        <path--}}
{{--                                                            d="M46.5392504,198.011312 L46.5392504,184.839826 C46.5392504,179.790757 43.4659038,176.497885 38.1973096,176.497885 C35.5630125,176.497885 32.7091906,177.375984 30.7334678,180.229806 C29.1967945,177.815034 27.0015469,176.497885 23.7086756,176.497885 C21.513428,176.497885 19.3181804,177.15646 17.5619824,179.571233 L17.5619824,176.936935 L12.9519625,176.936935 L12.9519625,198.011312 L17.5619824,198.011312 L17.5619824,186.3765 C17.5619824,182.644579 19.5377052,180.888381 22.6110518,180.888381 C25.6843984,180.888381 27.2210717,182.864103 27.2210717,186.3765 L27.2210717,198.011312 L31.8310916,198.011312 L31.8310916,186.3765 C31.8310916,182.644579 34.0263392,180.888381 36.880161,180.888381 C39.9535076,180.888381 41.490181,182.864103 41.490181,186.3765 L41.490181,198.011312 L46.5392504,198.011312 L46.5392504,198.011312 Z M114.81145,176.936935 L107.347608,176.936935 L107.347608,170.570717 L102.737589,170.570717 L102.737589,176.936935 L98.566618,176.936935 L98.566618,181.107905 L102.737589,181.107905 L102.737589,190.766995 C102.737589,195.59654 104.713311,198.450362 109.981906,198.450362 C111.957628,198.450362 114.152876,197.791787 115.689549,196.913688 L114.372401,192.962243 C113.055252,193.840341 111.518579,194.059866 110.420955,194.059866 C108.225708,194.059866 107.347608,192.742718 107.347608,190.54747 L107.347608,181.107905 L114.81145,181.107905 L114.81145,176.936935 L114.81145,176.936935 Z M153.886857,176.497885 C151.25256,176.497885 149.496362,177.815034 148.398738,179.571233 L148.398738,176.936935 L143.788718,176.936935 L143.788718,198.011312 L148.398738,198.011312 L148.398738,186.156975 C148.398738,182.644579 149.935411,180.668856 152.789233,180.668856 C153.667332,180.668856 154.764956,180.888381 155.643055,181.107905 L156.960204,176.71741 C156.082105,176.497885 154.764956,176.497885 153.886857,176.497885 L153.886857,176.497885 L153.886857,176.497885 Z M94.834697,178.693133 C92.6394495,177.15646 89.566103,176.497885 86.2732315,176.497885 C81.0046375,176.497885 77.492241,179.132183 77.492241,183.303153 C77.492241,186.81555 80.1265385,188.791272 84.736558,189.449847 L86.931806,189.669371 C89.346578,190.10842 90.6637265,190.766995 90.6637265,191.864619 C90.6637265,193.401292 88.9075285,194.498916 85.834182,194.498916 C82.7608355,194.498916 80.346063,193.401292 78.8093895,192.303668 L76.614142,195.816065 C79.0289145,197.572262 82.321786,198.450362 85.614657,198.450362 C91.7613505,198.450362 95.2737465,195.59654 95.2737465,191.645094 C95.2737465,187.913173 92.4199245,185.937451 88.0294295,185.278876 L85.834182,185.059351 C83.858459,184.839826 82.321786,184.400777 82.321786,183.083629 C82.321786,181.546955 83.858459,180.668856 86.2732315,180.668856 C88.9075285,180.668856 91.5418255,181.76648 92.858974,182.425054 L94.834697,178.693133 L94.834697,178.693133 Z M217.329512,176.497885 C214.695215,176.497885 212.939017,177.815034 211.841393,179.571233 L211.841393,176.936935 L207.231373,176.936935 L207.231373,198.011312 L211.841393,198.011312 L211.841393,186.156975 C211.841393,182.644579 213.378066,180.668856 216.231888,180.668856 C217.109987,180.668856 218.207611,180.888381 219.08571,181.107905 L220.402859,176.71741 C219.52476,176.497885 218.207611,176.497885 217.329512,176.497885 L217.329512,176.497885 L217.329512,176.497885 Z M158.496877,187.474123 C158.496877,193.840341 162.887372,198.450362 169.69264,198.450362 C172.765986,198.450362 174.961234,197.791787 177.156481,196.035589 L174.961234,192.303668 C173.205036,193.620817 171.448838,194.279391 169.473115,194.279391 C165.741194,194.279391 163.106897,191.645094 163.106897,187.474123 C163.106897,183.522678 165.741194,180.888381 169.473115,180.668856 C171.448838,180.668856 173.205036,181.32743 174.961234,182.644579 L177.156481,178.912658 C174.961234,177.15646 172.765986,176.497885 169.69264,176.497885 C162.887372,176.497885 158.496877,181.107905 158.496877,187.474123 L158.496877,187.474123 L158.496877,187.474123 Z M201.08468,187.474123 L201.08468,176.936935 L196.47466,176.936935 L196.47466,179.571233 C194.937987,177.595509 192.742739,176.497885 189.888917,176.497885 C183.961749,176.497885 179.351729,181.107905 179.351729,187.474123 C179.351729,193.840341 183.961749,198.450362 189.888917,198.450362 C192.962264,198.450362 195.157512,197.352737 196.47466,195.377015 L196.47466,198.011312 L201.08468,198.011312 L201.08468,187.474123 Z M184.181274,187.474123 C184.181274,183.742202 186.596046,180.668856 190.547492,180.668856 C194.279413,180.668856 196.91371,183.522678 196.91371,187.474123 C196.91371,191.206044 194.279413,194.279391 190.547492,194.279391 C186.596046,194.059866 184.181274,191.206044 184.181274,187.474123 L184.181274,187.474123 Z M129.080559,176.497885 C122.933866,176.497885 118.543371,180.888381 118.543371,187.474123 C118.543371,194.059866 122.933866,198.450362 129.300084,198.450362 C132.373431,198.450362 135.446777,197.572262 137.861549,195.59654 L135.666302,192.303668 C133.910104,193.620817 131.714856,194.498916 129.519609,194.498916 C126.665787,194.498916 123.811965,193.181768 123.153391,189.449847 L138.739648,189.449847 L138.739648,187.693648 C138.959173,180.888381 135.007727,176.497885 129.080559,176.497885 L129.080559,176.497885 L129.080559,176.497885 Z M129.080559,180.449331 C131.934381,180.449331 133.910104,182.20553 134.349153,185.498401 L123.372916,185.498401 C123.811965,182.644579 125.787688,180.449331 129.080559,180.449331 L129.080559,180.449331 Z M243.452958,187.474123 L243.452958,168.594995 L238.842938,168.594995 L238.842938,179.571233 C237.306265,177.595509 235.111017,176.497885 232.257196,176.497885 C226.330027,176.497885 221.720007,181.107905 221.720007,187.474123 C221.720007,193.840341 226.330027,198.450362 232.257196,198.450362 C235.330542,198.450362 237.52579,197.352737 238.842938,195.377015 L238.842938,198.011312 L243.452958,198.011312 L243.452958,187.474123 Z M226.549552,187.474123 C226.549552,183.742202 228.964324,180.668856 232.91577,180.668856 C236.647691,180.668856 239.281988,183.522678 239.281988,187.474123 C239.281988,191.206044 236.647691,194.279391 232.91577,194.279391 C228.964324,194.059866 226.549552,191.206044 226.549552,187.474123 L226.549552,187.474123 Z M72.443172,187.474123 L72.443172,176.936935 L67.833152,176.936935 L67.833152,179.571233 C66.2964785,177.595509 64.101231,176.497885 61.247409,176.497885 C55.3202405,176.497885 50.7102205,181.107905 50.7102205,187.474123 C50.7102205,193.840341 55.3202405,198.450362 61.247409,198.450362 C64.3207555,198.450362 66.5160035,197.352737 67.833152,195.377015 L67.833152,198.011312 L72.443172,198.011312 L72.443172,187.474123 Z M55.3202405,187.474123 C55.3202405,183.742202 57.735013,180.668856 61.6864585,180.668856 C65.4183795,180.668856 68.0526765,183.522678 68.0526765,187.474123 C68.0526765,191.206044 65.4183795,194.279391 61.6864585,194.279391 C57.735013,194.059866 55.3202405,191.206044 55.3202405,187.474123 Z"--}}
{{--                                                            fill="#000000"></path>--}}
{{--                                                        <rect fill="#FF5F00" x="93.2980455" y="16.9034088"--}}
{{--                                                              width="69.1502985" height="124.251009">--}}
{{--                                                        </rect>--}}
{{--                                                        <path--}}
{{--                                                            d="M97.688519,79.0288935 C97.688519,53.783546 109.542856,31.3920209 127.763411,16.9033869 C114.3724,6.3661985 97.468994,-1.94737475e-05 79.0289145,-1.94737475e-05 C35.3434877,-1.94737475e-05 1.7258174e-06,35.3434665 1.7258174e-06,79.0288935 C1.7258174e-06,122.71432 35.3434877,158.057806 79.0289145,158.057806 C97.468994,158.057806 114.3724,151.691588 127.763411,141.1544 C109.542856,126.88529 97.688519,104.274241 97.688519,79.0288935 Z"--}}
{{--                                                            fill="#EB001B"></path>--}}
{{--                                                        <path--}}
{{--                                                            d="M255.746345,79.0288935 C255.746345,122.71432 220.402859,158.057806 176.717432,158.057806 C158.277352,158.057806 141.373945,151.691588 127.982936,141.1544 C146.423015,126.665766 158.057827,104.274241 158.057827,79.0288935 C158.057827,53.783546 146.20349,31.3920209 127.982936,16.9033869 C141.373945,6.3661985 158.277352,-1.94737475e-05 176.717432,-1.94737475e-05 C220.402859,-1.94737475e-05 255.746345,35.5629913 255.746345,79.0288935 Z"--}}
{{--                                                            fill="#F79E1B"></path>--}}
{{--                                                    </g>--}}
{{--                                                </svg>--}}
{{--                                                <span class="ms-2"> mastercard </span></button>--}}
{{--                                            </label>--}}
{{--                                        </div>--}}
{{--                                        --}}{{--  PAYMENT--}}
{{--                                        <div class="genderOption payment m-1">--}}
{{--                                            <input type="radio" class="btn-check" name="payment" value="Meeza"--}}
{{--                                                   id="option4">--}}
{{--                                            <label class=" mb-0 btn btn-outline" for="option4">--}}
{{--                                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"--}}
{{--                                                     viewBox="0 0 163 88" style="enable-background:new 0 0 163 88;" xml:space="preserve">--}}
{{--	<style type="text/css">--}}
{{--        .st0{fill:#FFFFFF;}--}}
{{--        .st1{fill:#510C76;}--}}
{{--        .st2{fill:#EB6B24;}--}}
{{--        .st3{fill:#FFFFFF;stroke:#FFFFFF;stroke-miterlimit:10;}--}}
{{--    </style>--}}
{{--                                                    <path class="st0" d="M147.2,12.5L143,65.8c-0.4,5.4-4.9,9.6-10.3,9.7h-87c-21.5,0-23-8.3-21.9-24l3.5-39L147.2,12.5z"/>--}}
{{--                                                    <path class="st1" d="M60.8,12.5l-4.5,63H34.5c-21.5,0-23-8.3-21.9-24l3.5-39H60.8z"/>--}}
{{--                                                    <path class="st1" d="M65.9,38l-0.8,11.5c-0.4,4.2,2.7,7.9,6.9,8.3c0.2,0,0.5,0,0.7,0h3.5c4.6-0.1,8.4-3.7,8.7-8.3l1.3-19.8H74.7--}}
{{--		C70,29.8,66.2,33.4,65.9,38z M77.9,49.5c-0.1,0.6-0.6,1.1-1.2,1.1h-3.5c-0.6,0-1-0.4-1-1c0,0,0-0.1,0-0.1L73,38--}}
{{--		c0.1-0.6,0.6-1.1,1.2-1.1h4.6L77.9,49.5z"/>--}}
{{--                                                    <path class="st1" d="M130.8,29.7h-11.7l-1.3,19.8c0,0.8,0,1.5,0.2,2.2h-0.5c-3.7,0-5.5-2.6-5.2-7.4l0.6-8.4l0,0l0.2-3--}}
{{--		c0.1-1.7-1.2-3.1-2.9-3.3c-0.1,0-0.1,0-0.2,0h-4l-0.2,3.3l-0.5,8v0.5v0.8l-0.1,0.9v0.4V44v0.3l0,0l-0.1,2c-0.1,1.6,0,3.2,0.3,4.8--}}
{{--		c-0.9,0.5-1.8,0.7-2.8,0.7c-3.2,0-7.3-1-7.3-6.6L95.9,33c0.2-1.7-1.1-3.2-2.8-3.3c-0.1,0-0.2,0-0.2,0h-4L88.7,33l-1.9,28.7--}}
{{--		c-0.1,1.8-0.4,6.3-0.4,6.3h3.9c1.8,0,3.4-1.5,3.5-3.3l0.4-7c1.1,0.6,3.9,0.9,5.6,0.9c2.8,0,5.4-1.2,7.2-3.3c1.7,2.1,4.3,3.3,7.7,3.3--}}
{{--		c2.3,0,4.5-0.7,6.3-2c0.7,0.7,1.5,1.2,2.5,1.5l0,0c0.6,0.2,1.3,0.2,1.9,0.2h3.5c4.6-0.1,8.4-3.7,8.8-8.3l0.8-11.9--}}
{{--		c0.4-4.2-2.7-7.9-6.9-8.3C131.3,29.7,131,29.7,130.8,29.7z M130.6,49.9c0,0.6-0.6,1.1-1.2,1.1h-3.5c-0.6,0-1-0.4-1-1--}}
{{--		c0,0,0-0.1,0-0.1l0.8-13h4.6c0.6,0,1,0.4,1,1c0,0,0,0.1,0,0.1L130.6,49.9z"/>--}}
{{--                                                    <path class="st1" d="M70,22.9l-0.1,1.6c-0.1,1.5,1,2.9,2.5,3c0.1,0,0.2,0,0.2,0h1.3c1.7,0,3-1.3,3.2-3l0.3-4.6h-4.3--}}
{{--		C71.5,19.9,70.1,21.2,70,22.9z"/>--}}
{{--                                                    <path class="st1" d="M78.1,22.9L78,24.5c-0.1,1.5,1,2.9,2.6,3c0.1,0,0.1,0,0.2,0H82c1.7,0,3-1.3,3.2-3l0.3-4.6h-4.2--}}
{{--		C79.6,19.9,78.2,21.2,78.1,22.9z"/>--}}
{{--                                                    <path class="st2" d="M91.9,27.4h1.6c1.5,0.1,2.9-1,3-2.6c0,0,0-0.1,0-0.1l0.1-1.3c0.1-1.7-0.8-3.5-2.4-3.5l-4.9,0l-0.3,4.2--}}
{{--		C88.9,25.8,90.2,27.3,91.9,27.4z"/>--}}
{{--                                                    <path class="st1" d="M95.6,63.4L95.5,65c-0.1,1.5,1,2.9,2.5,3c0.1,0,0.2,0,0.3,0h1.3c1.7,0,3-1.3,3.2-3l0.3-4.6h-4.2--}}
{{--		C97.1,60.4,95.7,61.8,95.6,63.4z"/>--}}
{{--                                                    <path class="st1" d="M104.2,63.4l-0.1,1.6c-0.1,1.5,1,2.9,2.5,3c0.1,0,0.2,0,0.2,0h1.3c1.7,0,3-1.3,3.2-3l0.3-4.6h-4.2--}}
{{--		C105.7,60.4,104.3,61.8,104.2,63.4z"/>--}}
{{--                                                    <path class="st1" d="M109.4,27.3h-0.9c-0.2,0-0.2-0.1-0.2-0.2l0.3-3.8c0-0.3,0-0.6,0-0.9c0-0.4-0.2-0.6-0.6-0.6s-0.7,0-1,0--}}
{{--		c-0.1,0-0.1,0-0.1,0.1c0.1,0.6,0.1,1.2,0,1.7c-0.1,0.8-0.1,1.7-0.2,2.5c0,0.3,0,0.6-0.1,0.9s-0.1,0.2-0.3,0.2h-1.8--}}
{{--		c-0.2,0-0.2,0-0.2-0.2c0.1-1.3,0.2-2.6,0.3-3.9c0-0.3,0-0.6,0-0.9c0-0.3-0.2-0.5-0.4-0.5c0,0-0.1,0-0.1,0c-0.3,0-0.7,0-1,0--}}
{{--		c-0.1,0-0.1,0-0.1,0.1c-0.1,0.8-0.1,1.6-0.2,2.4s-0.1,1.8-0.2,2.7c0,0.2-0.1,0.3-0.3,0.3h-1.8c-0.2,0-0.3-0.1-0.2-0.3--}}
{{--		c0.1-1.3,0.2-2.7,0.3-4c0.1-0.9,0.1-1.8,0.2-2.7c0-0.2,0.1-0.2,0.3-0.3c0.5-0.1,0.9-0.1,1.4-0.2c0.8-0.1,1.5-0.1,2.3,0--}}
{{--		c0.4,0,0.9,0.2,1.3,0.3c0.1,0,0.1,0,0.2,0c0.8-0.3,1.7-0.4,2.5-0.4c0.4,0,0.7,0.1,1.1,0.2c0.6,0.2,1.1,0.7,1.2,1.3--}}
{{--		c0.1,0.5,0.1,1.1,0,1.6l-0.2,3.3c0,0.3,0,0.6-0.1,0.9s-0.1,0.2-0.3,0.2L109.4,27.3z"/>--}}
{{--                                                    <path class="st1" d="M123.1,24.3h-2c-0.1,0-0.2,0-0.2,0.2c0,0.6,0.2,0.9,0.8,0.9c0.5,0,0.9,0,1.4,0h1.4c0.2,0,0.3,0,0.3,0.3--}}
{{--		c0,0.4,0,0.8-0.1,1.3c0,0.1-0.1,0.2-0.2,0.2c0,0,0,0,0,0c-0.7,0.1-1.3,0.2-2,0.2c-0.6,0-1.2,0-1.8,0c-0.4,0-0.8-0.2-1.2-0.4--}}
{{--		c-0.4-0.3-0.7-0.7-0.7-1.2c-0.1-0.7-0.1-1.4,0-2.1c0-0.6,0.1-1.2,0.3-1.8c0.1-0.6,0.5-1.2,1.1-1.5c0.3-0.2,0.7-0.3,1.1-0.4--}}
{{--		c0.9-0.1,1.8-0.1,2.6,0c0.4,0.1,0.8,0.2,1.1,0.5c0.3,0.3,0.6,0.8,0.6,1.3c0.1,0.8,0.1,1.6,0,2.4c0,0.1-0.1,0.2-0.2,0.2H125--}}
{{--		L123.1,24.3z M121.1,22.9h1.8c0.5,0,0.5,0,0.4-0.5c0-0.3-0.3-0.5-0.6-0.6c-0.2,0-0.5,0-0.7,0c-0.4,0-0.7,0.2-0.8,0.6--}}
{{--		C121.1,22.5,121.1,22.7,121.1,22.9z"/>--}}
{{--                                                    <path class="st1" d="M115.9,24.3c-0.7,0-1.3,0-1.9,0c-0.2,0-0.2,0.1-0.2,0.2c0,0.6,0.2,0.8,0.8,0.9c0.2,0,0.4,0,0.5,0h2.3--}}
{{--		c0.2,0,0.3,0,0.2,0.2c0,0.4-0.1,0.9-0.1,1.3c0,0.1-0.1,0.2-0.2,0.2c0,0,0,0,0,0c-0.6,0.1-1.3,0.1-1.9,0.2c-0.7,0-1.4,0-2.2-0.1--}}
{{--		c-0.3,0-0.6-0.2-0.9-0.3c-0.4-0.3-0.7-0.7-0.8-1.3c-0.1-0.8-0.1-1.5,0-2.3c0-0.5,0.1-1,0.2-1.5c0.1-0.7,0.5-1.3,1.1-1.6--}}
{{--		c0.3-0.2,0.7-0.3,1.1-0.3c0.9-0.1,1.8-0.1,2.7,0c0.4,0.1,0.8,0.2,1.1,0.5c0.4,0.3,0.6,0.8,0.6,1.3c0,0.6,0,1.2,0,1.7--}}
{{--		c0,0.2,0,0.4,0,0.5c0,0.1-0.1,0.3-0.3,0.3L115.9,24.3L115.9,24.3z M116.1,22.9c0-0.2,0-0.4,0-0.6c0-0.3-0.3-0.5-0.5-0.5--}}
{{--		c-0.2,0-0.5,0-0.7,0c-0.6,0-0.9,0.5-0.9,1.1L116.1,22.9z"/>--}}
{{--                                                    <path class="st1" d="M135.1,21.7h-1.3c-0.2,0-0.3-0.1-0.2-0.2c0-0.4,0.1-0.9,0.1-1.3c0-0.1,0.1-0.2,0.2-0.2c1-0.2,2.1-0.3,3.1-0.2--}}
{{--		c0.5,0,0.9,0.1,1.4,0.2c0.7,0.2,1.2,0.9,1.2,1.6c0,0.9-0.1,1.8-0.2,2.8l-0.1,2.1c0,0.4-0.1,0.5-0.5,0.6c-1.3,0.2-2.6,0.3-3.9,0.2--}}
{{--		c-0.3,0-0.7-0.1-1-0.1c-0.5-0.1-0.9-0.6-1-1.1c-0.1-0.7-0.1-1.4,0.2-2c0.2-0.6,0.8-1.1,1.5-1.1c0.4-0.1,0.7-0.1,1.1-0.1--}}
{{--		c0.5,0,1,0,1.5,0c0.1,0,0.1,0,0.1-0.1v-0.1c0-0.5-0.2-0.8-0.8-0.8L135.1,21.7z M137.1,24.1c-0.5,0-1,0-1.4,0c-0.3,0-0.6,0.2-0.6,0.5--}}
{{--		c0,0.1,0,0.2,0,0.3c0,0.3,0.2,0.5,0.4,0.5c0,0,0,0,0.1,0c0.5,0,1,0,1.4-0.1c0,0,0.1,0,0.1-0.1C137,24.9,137,24.5,137.1,24.1--}}
{{--		L137.1,24.1z"/>--}}
{{--                                                    <path class="st1" d="M129.1,25.3h3c0.1,0,0.1,0.1,0.1,0.2c0,0.5-0.1,1-0.1,1.5c0,0.2-0.1,0.2-0.3,0.2H126c-0.3,0-0.3-0.1-0.3-0.3--}}
{{--		s0-0.7,0.1-1c0-0.1,0.1-0.2,0.1-0.3l2.8-3.3l0.5-0.6h-2.7c-0.3,0-0.3,0-0.3-0.3l0.1-1.3c0-0.2,0.1-0.3,0.3-0.3h5.6--}}
{{--		c0.2,0,0.3,0.1,0.2,0.3c0,0.4,0,0.7-0.1,1.1c0,0.1,0,0.2-0.1,0.3c-1,1.2-2,2.5-3,3.7L129.1,25.3z"/>--}}
{{--                                                    <path class="st2" d="M117.1,60.8c-1.8,0.1-3.2,1.5-3.3,3.3l-0.3,3.9h20c1.8-0.1,3.2-1.5,3.3-3.3l0.3-3.9H117.1z"/>--}}
{{--                                                    <path class="st3" d="M130.4,77H34.5c-10.1,0-16.2-1.7-19.9-5.6c-4.4-4.8-4.3-12.3-3.8-20.2l3.6-40.7l134.7,0.1l-4.3,53--}}
{{--		C144.1,71.1,137.9,76.8,130.4,77z M17.7,14l-3.3,37.5C13.8,60,14.1,65.6,17.2,69c2.9,3.1,8.4,4.5,17.3,4.5h95.9--}}
{{--		c5.7-0.2,10.4-4.5,11.1-10.2l4-49.2L17.7,14z"/>--}}
{{--                                                    <path class="st0" d="M40.8,58H29.4c-1.7,0-3-1.3-3-3c0-0.1,0-0.2,0-0.3l1.6-22c0.2-1.8,1.7-3.2,3.5-3.3h11.3c1.7,0,3,1.3,3,3--}}
{{--		c0,0.1,0,0.2,0,0.3l-1.6,22C44.1,56.5,42.6,58,40.8,58z M31.3,31.7c-0.6,0-1,0.4-1.1,1l-1.6,22c0,0.6,0.4,1,1,1H41--}}
{{--		c0.6,0,1-0.4,1.1-1l1.6-22c0-0.6-0.4-1-1-1H31.3z"/>--}}
{{--                                                    <polygon class="st0" points="43.7,51 43.5,53.2 27.7,53.2 27.9,51 "/>--}}
{{--</svg>--}}

{{--                                                <span class="ms-2"> Meeza </span>--}}
{{--                                            </label>--}}
{{--                                        </div>--}}
{{--                                        --}}{{--  PAYMENT--}}
{{--                                        <div class="genderOption payment m-1">--}}
{{--                                            <input type="radio" class="btn-check" name="payment" value="voucher"--}}
{{--                                                   id="option5">--}}
{{--                                            <label class=" mb-0 btn btn-outline" for="option5">--}}
{{--                                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"--}}
{{--                                                     viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">--}}
{{--<path style="fill:#F53000;" d="M512,401.805c0,8.501-6.892,15.393-15.393,15.393H15.393C6.892,417.199,0,410.307,0,401.805V110.195--}}
{{--	c0-8.501,6.892-15.393,15.393-15.393h481.213c8.501,0,15.393,6.892,15.393,15.393L512,401.805L512,401.805z"/>--}}
{{--                                                    <path style="fill:#2D2E30;" d="M512,401.805V110.195c0-8.501-6.892-15.393-15.393-15.393H317.024--}}
{{--	c-0.205,2.869,0.781,5.809,2.975,8.004l17.65,17.65c4.014,4.014,4.014,10.523,0,14.536L320,152.639--}}
{{--	c-4.014,4.014-4.014,10.523,0,14.536l17.65,17.65c4.014,4.014,4.014,10.523,0,14.536L320,217.01c-4.014,4.014-4.014,10.523,0,14.536--}}
{{--	l17.65,17.65c4.014,4.014,4.014,10.523,0,14.536L320,281.381c-4.014,4.014-4.014,10.523,0,14.536l17.65,17.65--}}
{{--	c4.014,4.014,4.014,10.523,0,14.536L320,345.752c-4.014,4.014-4.014,10.523,0,14.536l17.65,17.65c4.014,4.014,4.014,10.523,0,14.536--}}
{{--	L320,410.123c-1.958,1.958-2.954,4.51-3.002,7.076h179.608C505.108,417.199,512,410.307,512,401.805z"/>--}}
{{--                                                    <path style="fill:#FFFFFF;" d="M102.579,237.313v-27.802c0-19.384,12.727-26.431,29.369-26.431c16.445,0,29.368,7.049,29.368,26.431--}}
{{--	v27.802c0,19.384-12.922,26.431-29.368,26.431C115.305,263.745,102.579,256.697,102.579,237.313z M141.736,209.512--}}
{{--	c0-6.461-3.72-9.397-9.789-9.397c-6.069,0-9.594,2.937-9.594,9.397v27.802c0,6.461,3.525,9.397,9.594,9.397s9.789-2.936,9.789-9.397--}}
{{--	V209.512z M222.01,185.43c0,1.175-0.196,2.546-0.782,3.72l-68.919,141.163c-1.37,2.937-5.091,4.895-8.811,4.895--}}
{{--	c-6.656,0-10.965-5.483-10.965-10.377c0-1.174,0.392-2.546,0.979-3.72l68.722-141.164c1.566-3.328,4.699-4.894,8.223-4.894--}}
{{--	C215.94,175.053,222.01,179.164,222.01,185.43z M192.445,300.357v-27.802c0-19.384,12.727-26.431,29.368-26.431--}}
{{--	c16.446,0,29.369,7.049,29.369,26.431v27.802c0,19.384-12.922,26.431-29.369,26.431--}}
{{--	C205.172,326.788,192.445,319.741,192.445,300.357z M231.603,272.555c0-6.461-3.72-9.397-9.789-9.397s-9.593,2.936-9.593,9.397--}}
{{--	v27.802c0,6.461,3.524,9.397,9.593,9.397s9.789-2.937,9.789-9.397V272.555z"/>--}}
{{--                                                    <path style="fill:#FAE246;" d="M465.963,382.354H46.924c-9.22,0-16.696-7.475-16.696-16.696V141.948--}}
{{--	c0-9.22,7.475-16.696,16.696-16.696h419.04c9.22,0,16.696,7.475,16.696,16.696v223.711--}}
{{--	C482.659,374.88,475.184,382.354,465.963,382.354z M63.619,348.962h385.648V158.643H63.619V348.962z"/>--}}
{{--                                                    <path style="fill:#E3C129;" d="M465.963,125.252H340.348c0.834,3.379-0.058,7.097-2.699,9.738L320,152.639--}}
{{--	c-1.685,1.685-2.652,3.81-2.923,6.005h132.192v190.319H317.83c-1.611,3.751-0.893,8.263,2.17,11.325l17.65,17.65--}}
{{--	c1.274,1.274,2.14,2.799,2.606,4.417h125.709c9.22,0,16.696-7.475,16.696-16.696V141.949--}}
{{--	C482.659,132.727,475.184,125.252,465.963,125.252z"/>--}}
{{--                                                    <g>--}}
{{--                                                    </g>--}}
{{--                                                    <g>--}}
{{--                                                    </g>--}}
{{--                                                    <g>--}}
{{--                                                    </g>--}}
{{--                                                    <g>--}}
{{--                                                    </g>--}}
{{--                                                    <g>--}}
{{--                                                    </g>--}}
{{--                                                    <g>--}}
{{--                                                    </g>--}}
{{--                                                    <g>--}}
{{--                                                    </g>--}}
{{--                                                    <g>--}}
{{--                                                    </g>--}}
{{--                                                    <g>--}}
{{--                                                    </g>--}}
{{--                                                    <g>--}}
{{--                                                    </g>--}}
{{--                                                    <g>--}}
{{--                                                    </g>--}}
{{--                                                    <g>--}}
{{--                                                    </g>--}}
{{--                                                    <g>--}}
{{--                                                    </g>--}}
{{--                                                    <g>--}}
{{--                                                    </g>--}}
{{--                                                    <g>--}}
{{--                                                    </g>--}}
{{--</svg>--}}
{{--                                                <span class="ms-2"> voucher </span>--}}
{{--                                            </label>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="row align-items-end">--}}
{{--                                        <div class="col-8 col-md-9 p-2 ">--}}
{{--                                            <label> Amount </label>--}}
{{--                                            <input class="form-control" type="number" id="amount"--}}
{{--                                                   onchange="calculateChange()" onkeyup="calculateChange()" min="0" step="any"/>--}}
{{--                                        </div>--}}
{{--                                        --}}{{--                                            <div class="col-4 col-md-3 p-2">--}}
{{--                                        --}}{{--                                                <button type="button" class="btn w-100 btn-success"> Pay</button>--}}
{{--                                        --}}{{--                                            </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}


{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="row">--}}
{{--                            <div class="button-row d-flex mt-4 col-12">--}}
{{--                                <button class="btn bg-gradient-secondary mb-0 js-btn-prev" type="button" id="lastPrev">--}}
{{--                                    Prev--}}
{{--                                </button>--}}
{{--                                <button class="btn bg-gradient-dark ms-auto mb-0" id="confirmBtn"> Confirm</button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class=" col-lg-3 p-1 ">--}}
{{--                <div class=" bill" id="bill">--}}
{{--                    <h4 class="font-weight-bolder ps-2">Bill</h4>--}}
{{--                    <div class="info">--}}
{{--                        <h6 class="billTitle"> ticket <span id="RandTicket">{{$rev->ticket_num}}</span></h6>--}}
{{--                        <ul>--}}
{{--                            <li><label> Cashier Name : </label> <strong>{{$add_by}}</strong></li>--}}
{{--                            <li><label> Visit Date : </label> <strong id="dateOfTicket">{{$rev->day}}</strong></li>--}}
{{--                            <li><label> Reservation Duration : </label> <strong id="hourOfTicket"--}}
{{--                                                                                style="text-transform: none !important;">{{$rev->hours_count}}--}}
{{--                                    h</strong>--}}
{{--                            </li>--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                    <div class="info firstInfo">--}}
{{--                        <h6 class="billTitle"> visitors</h6>--}}
{{--                        <div class="items">--}}
{{--                            <div class="itemsHead row visitorItemRows">--}}
{{--                                <span class="col">type</span>--}}
{{--                                <span class="col"> Quantity </span>--}}
{{--                                <span class="col"> price </span>--}}
{{--                            </div>--}}
{{--                            @foreach($rev->models->groupBy('visitor_type_id') as $visitor)--}}
{{--                            <div class="item row insertRows">--}}
{{--                                <span class="col">{{$visitor[0]->type->title}}</span>--}}
{{--                                <span class="col" style="text-transform: initial !important;"> {{$visitor->count()}}</span>--}}
{{--                                <span class="col"> {{$visitor->sum('price')}} EGP</span>--}}
{{--                            </div>--}}
{{--                            @endforeach--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="info secondInfo">--}}
{{--                        @if(count($products) > 0)--}}
{{--                        <h6 class="billTitle"> products</h6>--}}
{{--                        <div class="items">--}}
{{--                            <div class="itemsHead row">--}}
{{--                                <span class="col">type</span>--}}
{{--                                <span class="col"> Quantity </span>--}}
{{--                                <span class="col"> price </span>--}}
{{--                            </div>--}}
{{--                            @foreach($products as $product)--}}
{{--                            <div class="item row">--}}
{{--                                <span class="col">{{$product->product->title}} </span>--}}
{{--                                <span class="col"> {{$product->qty}} </span>--}}
{{--                                <span class="col"> {{$product->total_price}} EGP </span>--}}
{{--                            </div>--}}
{{--                            @endforeach--}}
{{--                        </div>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                    <div class="info thirdInfo">--}}

{{--                    </div>--}}
{{--                    @php--}}
{{--                        $generator = new Picqer\Barcode\BarcodeGeneratorHTML();--}}
{{--                    @endphp--}}
{{--                    <div class="myBarcode">--}}
{{--                        {!! $generator->getBarcode($rev->ticket_num, $generator::TYPE_CODE_128) !!}--}}
{{--                    </div>--}}
{{--                    <div id="printDiv" style="display: none">--}}
{{--                        <div class="printBtn">--}}
{{--                            <a class="btn btn-outline-info fw-normal " id="accessBtn"><i--}}
{{--                                    class="fas fa-sign-out me-2"></i>--}}
{{--                                Access--}}
{{--                            </a>--}}
{{--                            <a class="btn btn-info " target="_blank"  id="printBtn"><i class="fal fa-print me-2"></i> Print</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </form>--}}
{{--    </div>--}}
{{--@endsection--}}
{{--@section('js')--}}
{{--    <script type="text/javascript" src="{{asset('assets/sales')}}/js/plugins/multistep-form.js"></script>--}}

{{--    @include('sales.layouts.assets.editDataTable')--}}
{{--    <script>--}}
{{--        $(document).ready(function () {--}}
{{--            checkTime()--}}

{{--        });--}}
{{--    </script>--}}
{{--        <script>--}}
{{--            $('form').on('submit', function (e) {--}}
{{--                e.preventDefault();--}}
{{--                var duration = $('#duration').val(),--}}
{{--                    visit_date = $('#date').val(),--}}
{{--                    shift_id = $('#choices-shift').val(),--}}
{{--                    visitor_type = $("span[id='visitor_type[]']").map(function () {--}}
{{--                        return $(this).attr('data-type_id');--}}
{{--                    }).get(),--}}
{{--                    visitor_price = $("span[id='visitor_price[]']").map(function () {--}}
{{--                        return $(this).attr('data-price');--}}
{{--                    }).get(),--}}
{{--                    visitor_birthday = $("input[id='visitor_birthday[]']").map(function () {--}}
{{--                        return $(this).val();--}}
{{--                    }).get(),--}}
{{--                    visitor_name = $("input[name='visitor_name[]']").map(function () {--}}
{{--                        return $(this).val();--}}
{{--                    }).get(),--}}
{{--                    gender = $(".choose input:checked").map(function () {--}}
{{--                        return $(this).val();--}}
{{--                    }).get(),--}}
{{--                    product_id = $("input[name='product_id[]']").map(function () {--}}
{{--                        return $(this).val();--}}
{{--                    }).get(),--}}
{{--                    ticket_price    =  $("#beforeTax").text(),--}}
{{--                    ent_tax         =  $("#ent").text(),--}}
{{--                    vat             =  $("#vat").text(),--}}
{{--                    product_qty = $("input[name='proQtyInput[]']").map(function () {--}}
{{--                        return $(this).val();--}}
{{--                    }).get(),--}}
{{--                    product_price = $("input[name='proTotalInput[]']").map(function () {--}}
{{--                        return $(this).val();--}}
{{--                    }).get(),--}}
{{--                    client_name = $("#client_name").val(),--}}
{{--                    client_phone = $("#phone").val(),--}}
{{--                    client_email = $("#email").val(),--}}
{{--                    total_price = $("#totalPrice").text(),--}}
{{--                    discount_value = $("#discount").text().replace('%', ''),--}}
{{--                    discount_id     =  $("#choices-discount").val(),--}}
{{--                    RandTicket = $("#RandTicket").text(),--}}
{{--                    revenue = $("#revenue").text(),--}}
{{--                    amount = parseFloat($('#paid').text()) - parseFloat($('#change').text()),--}}
{{--                    discount_type = $(".discType input:checked").map(function () {--}}
{{--                        return $(this).val();--}}
{{--                    }).get(),--}}
{{--                    rem = parseFloat($("#revenue").text()) - amount;--}}

{{--                if(discount_value != 0 && discount_id.length == 0){--}}
{{--                    toastr.error("Choose The Discount Reasons");--}}
{{--                }--}}
{{--                else {--}}
{{--                    var data = {--}}

{{--                        'client_name': client_name,--}}
{{--                        'phone': client_phone,--}}
{{--                        'email': client_email,--}}
{{--                        'shift_start': "{{$rev->models[0]->shift_start}}",--}}
{{--                        'shift_end': "{{$rev->models[0]->shift_end}}",--}}
{{--                        'note': $('#note').val(),--}}
{{--                        "visitor_type": visitor_type,--}}
{{--                        "visitor_price": visitor_price,--}}
{{--                        "visitor_birthday": visitor_birthday,--}}
{{--                        "visitor_name": visitor_name,--}}
{{--                        "gender": gender,--}}
{{--                        "product_id": product_id,--}}
{{--                        "product_qty": product_qty,--}}
{{--                        "product_price": product_price.toFixed(2),--}}
{{--                        "ticket_price":ticket_price.toFixed(2),--}}
{{--                        "ent_tax":ent_tax,--}}
{{--                        "vat": vat.toFixed(2),--}}
{{--                        "total_price": total_price,--}}
{{--                        "discount_type": discount_type,--}}
{{--                        "discount_value": discount_value,--}}
{{--                        "discount_id": discount_id,--}}
{{--                        "rand_ticket": RandTicket,--}}
{{--                        "amount": amount.toFixed(2),--}}
{{--                        "revenue": revenue,--}}
{{--                        "rev_id": "{{$rev->id}}",--}}
{{--                        "rem": (Math.round(rem * 100) / 100).toFixed(2),--}}
{{--                        "payment_method" : $('input[name="payment"]:checked').val()--}}
{{--                    }--}}
{{--                    $.ajax({--}}
{{--                        type: "POST",--}}
{{--                        data: data,--}}
{{--                        url: '{{route('postUpdateReservation')}}',--}}
{{--                        beforeSend: function () {--}}
{{--                            $('#confirmBtn').html('<span class="spinner-border spinner-border-sm mr-2" ' +--}}
{{--                                ' ></span> <span style="margin-left: 4px;">working</span>').attr('disabled', true);--}}
{{--                        },--}}
{{--                        success: function (data) {--}}
{{--                            toastr.success("Reservation updated successfully");--}}
{{--                            $('#confirmBtn').hide();--}}
{{--                            $('#lastPrev').hide();--}}
{{--                            $('#printDiv').show();--}}
{{--                            $('#printBtn').attr("href", data.printUrl)--}}
{{--                            $('#accessBtn').attr("href", data.accessUrl)--}}
{{--                            window.scrollTo({top: 1000, behavior: 'smooth'});--}}
{{--                        },--}}
{{--                    });--}}
{{--                }--}}

{{--                // Prevent form submission--}}
{{--            });--}}
{{--        </script>--}}

{{--@endsection--}}


@extends('sales.layouts.master')
@section('page_title')
    {{$setting->title}} | Edit Reservation
@endsection
@section('content')
    <h2 class="MainTiltle mb-5 ms-4"> Edit Reservation </h2>

    <div class="multisteps-form">
        <form action="{{route('reservations.update',$rev->id)}}" method="POST" enctype="multipart/form-data"
              class="row">
            @csrf
            @method('PUT')
            <input type="hidden" id="rev_id" name="rev_id" value="{{$rev->id}}">
            <input type="hidden" id="visit_date" name="visit_date" value="{{$rev->day}}">
            <div class="col-lg-9 p-1 ">
                <div class="multisteps-form__progress mb-5">
                    <button type="button"
                            class="multisteps-form__progress-btn ReservationInfo-multisteps-form__progress-btn js-active"
                            title="ReservationInfo"> Reservation Info
                    </button>
                    <button type="button" class="multisteps-form__progress-btn visitors-multisteps-form__progress-btn"
                            title="visitors"> visitors
                    </button>
                    <button type="button" class="multisteps-form__progress-btn products-multisteps-form__progress-btn"
                            title="products"> products
                    </button>
                    <button type="button" class="multisteps-form__progress-btn payment-multisteps-form__progress-btn"
                            title="payment"> payment
                    </button>
                </div>
                <div class="multisteps-form__form mb-2">
                    <!-- step 1 -->
                    <div class="card multisteps-form__panel ReservationInfo-multisteps-form__panel p-3 border-radius-xl bg-white js-active"
                         validate="true" id="ticketTab" data-animation="FadeIn">
                        <h5 class="font-weight-bolder">Reservation Info</h5>
                        <div class="multisteps-form__content">
                            <div class="row mt-3">
                                <div class="col-sm-6 p-2">
                                    <label>Client Name </label>
                                    <input class="form-control" type="text" value="{{$rev->client_name}}"
                                           name="client_name" id="client_name">
                                    <label id="client_nameError" class="text-danger"></label>
                                </div>
                                <div class="col-sm-6 p-2">
                                    <label>Phone </label>
                                    <input class="form-control" type="text" value="{{$rev->phone}}"
                                           name="phone" id="phone">
                                    <label id="phoneError" class="text-danger"></label>
                                </div>
                                <div class="col-sm-12">
                                    <label>Email </label>
                                    <input class="form-control" type="email" value="{{$rev->email}}"
                                           name="email" id="email">
                                    <label id="emailError" class="text-danger"></label>
                                </div>
                                <div class="col-sm-12">
                                    <label class="form-label"> <i class="fas fa-feather-alt me-1"></i> Note </label>
                                    <textarea name="notes" id="note" class="form-control" rows="6"
                                              placeholder="Add Note...">{{$rev->note}}</textarea>
                                </div>
                            </div>
                            {{--                            <div class="row mt-3">--}}
                            {{--                                <div class="col-sm-6 p-2">--}}
                            {{--                                    <label style="text-transform: initial !important;">Reservation Duration (h) </label>--}}
                            {{--                                    <input class="form-control" type="number" value="{{$rev->hours_count}}"--}}
                            {{--                                           name="duration" onchange="checkTime()"--}}
                            {{--                                           id="duration" min="1" max="24"--}}
                            {{--                                           onKeyUp="if(this.value>24){this.value='24';}else if(this.value<=0){this.value='1';}$('#durationError').text('')"/>--}}
                            {{--                                    <label id="durationError" class="text-danger"></label>--}}
                            {{--                                </div>--}}
                            {{--                                <input class="form-control" type="hidden" id="date" value="{{$rev->day}}"--}}
                            {{--                                       name="visit_date"/>--}}
                            {{--                                <input type="hidden" id="first_shift_start" value="{{$first_shift_start}}">--}}
                            {{--                                <input type="hidden" id="start" value="">--}}
                            {{--                                <div class="col-sm-6 p-2">--}}
                            {{--                                    <label class="form-label"> shift </label>--}}
                            {{--                                    <select class="form-control" id="choices_times" name="choices_times">--}}

                            {{--                                    </select>--}}
                            {{--                                </div>--}}
                            {{--                                <div class="col-sm-12 p-2">--}}
                            {{--                                    <label class="form-label"> <i class="fas fa-feather-alt me-1"></i> Note </label>--}}
                            {{--                                    <textarea name="notes" id="note" class="form-control" rows="6"--}}
                            {{--                                              placeholder="Add Note...">{{$rev->note}}</textarea>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                            <div class="button-row d-flex mt-4">
                                <button class="btn bg-gradient-dark ms-auto mb-0 js-btn-next" type="button"
                                        id="firstNext">Next
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- step 2 -->
                    <div class="card multisteps-form__panel p-3 border-radius-xl bg-white " id="visitorsTab"
                         data-animation="FadeIn">
                        <h5 class="font-weight-bolder">visitors</h5>
                        <div class="multisteps-form__content">
                            <div class="row mt-3">
                                <!-- visitor Type  -->
                                <small class="form-text text-muted mb-1"><i class="fa fa-arrow-right text-warning"></i>
                                    Enter a number to add many rows</small>
                                <div class="col-10 p-2">
                                    @foreach($types as $type)
                                        <div class="visitorType visitorType{{$type->id}}">
                                            <div class="visitorTypeDiv">
                                                <img src="{{get_file($type->photo)}}" alt="{{$type->title}}"
                                                     title="{{$type->title}}">
                                                <span class="visitor">{{$type->title}}</span>
                                                <span
                                                    class="count">{{$models->where('rev_id',$rev->id)->where('visitor_type_id',$type->id)->count()}}</span>
                                                <input type="hidden"
                                                       value="{{($prices->where('visitor_type_id',$type->id)->first()->price) ?? null}}"
                                                       name="price[]" id="price{{$type->id}}">
                                                <input type="hidden" value="{{$type->id}}"
                                                       id="visitor_type_id">
                                            </div>
                                            <div class="countInput">
                                                <input type="text" id="countInput" class="inputCount" min="0" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1').replace(/^0[^.]/, '0');"
                                                       value="{{$models->where('rev_id',$rev->id)->where('visitor_type_id',$type->id)->count()}}"/>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="col-2">
                                    <button class="btn btn-danger" type="button" onclick="DeleteRows()"><i
                                            class="fal fa-trash me-2"></i> Clear
                                    </button>
                                </div>
                                <!-- table -->
                                <div class="col-12 p-2 position-relative">
                                    <table class="firstTable  customDataTable table table-bordered nowrap">
                                        <thead>
                                        <tr>
                                            <th>Type</th>
                                            <th>price</th>
                                            <th>Name</th>
                                            <th>Birthday</th>
                                            <th>Gender</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody id="visitorTable">
                                        @foreach($models as $model)
                                            <tr class="{{$model->type->title}}">
                                                <td><span data-type_id="{{$model->type->id}}"
                                                          id="visitor_type[]">{{$model->type->title}}</span></td>
                                                <td><span data-price="{{$model->price}}"
                                                          id="visitor_price[]">{{$model->price}}</span></td>
                                                <td><input type="text" class="form-control" placeholder="Name"
                                                           name="visitor_name[]" value="{{$model->name}}"></td>
                                                <td><input type="date" class="form-control" name="visitor_birthday[]"
                                                           id="visitor_birthday[]" value="{{$model->birthday}}"></td>
                                                <td>
                                                    <div class="choose">
                                                        <div class="genderOption">
                                                            <input type="radio" class="btn-check gender" name="gender{{$model->id}}"
                                                                   value="male" id="option1{{$model->id}}" {{($model->gender == 'male') ? 'checked' : ''}}>
                                                            <label class=" mb-0 btn btn-outline" for="option1{{$model->id}}">
                                                                <span> <i class="fas fa-male"></i> </span>
                                                            </label>
                                                        </div>
                                                        <div class="genderOption">
                                                            <input type="radio" class="btn-check gender" name="gender{{$model->id}}"
                                                                   value="female" id="option2{{$model->id}}" {{($model->gender == 'female') ? 'checked' : ''}}>
                                                            <label class=" mb-0 btn btn-outline" for="option2{{$model->id}}">
                                                                <span> <i class="fas fa-female"></i> </span>
                                                                <!-- <span> female </span> -->
                                                            </label>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="controlIcons">
                                                    <span class="icon Delete"
                                                          data-model_id="{{$model->type->id}}"> <i
                                                            class="far fa-trash-alt"></i> </span>
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="button-row d-flex mt-4">
                                <button class="btn bg-gradient-secondary mb-0 js-btn-prev" type="button"
                                        id="secondPrev">Prev
                                </button>
                                <button class="btn bg-gradient-dark ms-auto mb-0 js-btn-next" type="button"
                                        id="secondNext">Next
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- step 3 -->
                    <div class="card multisteps-form__panel p-3 border-radius-xl bg-white " id="productsTab"
                         data-animation="FadeIn">
                        <h5 class="font-weight-bolder">products</h5>
                        <div class="multisteps-form__content">
                            <div class="row mt-3 align-items-end">
                                <div class="col-md-5 p-2">
                                    <label class="form-label"> category </label>
                                    <select class="form-control" id="choices-category">
                                        <option value="" disabled selected>Choose The Category</option>
                                        {!! optionForEach($categories,'id','title') !!}
                                    </select>
                                </div>
                                <div class="col-md-5 p-2">
                                    <label class="form-label"> product </label>
                                    <select class="form-control" id="choices-product">
                                        <option value="" disabled selected>Choose The Product</option>
                                    </select>
                                </div>
                                <div class="col-md-2 p-2">
                                    <button type="button" class="btn btn-success w-100 " id="addBtn"> ADD</button>
                                </div>
                                <div class="col-md-12 p-2  pt-5">
                                    <table class=" customDataTable table table-bordered nowrap" id="myNewTable">
                                        <thead>
                                        <tr>
                                            <th>Type</th>
                                            <th>price</th>
                                            <th>Quantity</th>
                                            <th>Total Price</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($products as $product)
                                            <tr class="productrow{{$product->product_id}}">
                                                <td>
                                                    <span id="spanProductId"
                                                          data-product_id="{{$product->product_id}}">{{$product->product->title}}</span>
                                                </td>
                                                <td>
                                                    <span class="price"
                                                          id="price{{$product->product_id}}">{{$product->price}}</span>
                                                </td>
                                                <td>
                                                    <div class="countInput">
                                                        <button type="button" class=" sub" id="subBtn">-</button>
                                                        <input type="number" disabled id="qtyVal{{$product->product_id}}"
                                                               class="qtyVal" value="{{$product->qty}}" min="1"/>
                                                        <button type="button" class=" add plusBtn" id="plusBtn">+
                                                        </button>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="productTotalPrice"
                                                          id="productTotalPrice{{$product->product_id}}">{{$product->total_price}}</span>
                                                </td>
                                                <td>
                                                    <span class="controlIcons">
                                                      <span class="icon Delete">
                                                          <i class="far fa-trash-alt"></i>
                                                      </span>
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="button-row d-flex mt-4">
                                <button class="btn bg-gradient-secondary mb-0 js-btn-prev" type="button" id="thirdPrev">
                                    Prev
                                </button>
                                <button class="btn bg-gradient-dark ms-auto mb-0 js-btn-next" type="button"
                                        id="thirdNext">Next
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- step 4 -->
                    <div class="card multisteps-form__panel p-3 border-radius-xl bg-white " data-animation="FadeIn">
                        <h5 class="font-weight-bolder">old costs</h5>
                        <div class="multisteps-form__content">
                            <div class="row   mt-3">
                                <div class="col-12 p-2">
                                    <div class="screens row">
                                        <div class="screen col">
                                            <span>old total</span>
                                            <strong id="oldTotal">{{$rev->total_price}}</strong>
                                        </div>
                                        <div class="screen col">
                                            <span>discount</span>
                                            <strong id="oldDiscount"> {{$rev->discount_value}} {{($rev->discount_type == 'per') ? '%' : ''}} </strong>
                                        </div>
                                        <div class="screen col">
                                            <span>Amount to Pay</span>
                                            <strong id="oldRevenue"> {{$rev->grand_total}}</strong>
                                        </div>
                                        <div class="screen col">
                                            <span>paid</span>
                                            <strong id="oldPaid"> {{$rev->paid_amount}}</strong>
                                            <input type="hidden" value="{{$rev->paid_amount}}" id="oldPayRev">
                                        </div>
                                        <div class="screen col">
                                            <span>dues</span>
                                            <strong id="oldDues"> {{$rev->rem_amount}}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if($rev->discount_value != 0)
                                <label class="form-label"><i class="fa fa-tag pt-2"></i> Discount Reason </label>
                                <span>{{($rev->reason->desc) ?? ''}}</span>
                            @endif
                        </div>

                        <h5 class="font-weight-bolder mt-2">payment</h5>
                        <div class="multisteps-form__content">
                            <div class="row   mt-3">
                                <div class="col-12 p-2">
                                    <div class="screens row">
                                        <div class="screen col">
                                            <span>total</span>
                                            <strong id="totalPrice"> </strong>
                                        </div>
                                        <div class="screen col">
                                            <span>discount</span>
                                            <strong id="discount"> 0 </strong>
                                        </div>
                                        <div class="screen col">
                                            <span>Amount to Pay</span>
                                            <strong id="revenue"></strong>
                                        </div>
                                        <div class="screen col">
                                            <span>paid</span>
                                            <strong id="paid"> {{$rev->paid_amount}} </strong>
                                        </div>
                                        <div class="screen col">
                                            <span>change</span>
                                            <strong id="change"> 0</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 p-2">
                                    <div class="row align-items-end">
                                        <div class="col-md-6 p-2">
                                            <label class="form-label"> Discount Value </label>
                                            <input type="number" class="form-control" id="calcDiscount" step="any">
                                        </div>
                                        <div class="col-md-6 p-2 discType">
                                            <label class="form-label d-block"> Discount Type </label>
                                            <div class="form-check d-inline-block py-2 mx-2 ">
                                                <input class="form-check-input " type="radio" name="offerType"
                                                       id="offerType1" value="per">
                                                <label class="form-check-label" for="offerType1"> Percent </label>
                                            </div>
                                            <div class="form-check d-inline-block py-2 mx-2 ">
                                                <input class="form-check-input " type="radio" name="offerType"
                                                       id="offerType2" value="val">
                                                <label class="form-check-label" for="offerType2"> Amount </label>
                                            </div>
                                        </div>
                                        <div class="col-md-12 p-2" id="reasonDiv" style="display: none">
                                            <label class="form-label"> Discount Reason </label>
                                            <select class="form-control" id="choices-discount">
                                                <option value="" disabled selected>-- Select The Reason Of The Discount --</option>
                                                {!! optionForEach($discounts,'id','desc') !!}
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 p-2">
                                    <label class="form-label ">payment method</label>
                                    <div class="choose">
                                        {{--  PAYMENT--}}
                                        <div class="genderOption payment m-1">
                                            <input type="radio" class="btn-check" name="payment" value="cash" checked
                                                   id="option1">
                                            <label class=" mb-0 btn btn-outline" for="option1">

                                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                                     xmlns:xlink="http://www.w3.org/1999/xlink"
                                                     xmlns:svgjs="http://svgjs.com/svgjs" width="512"
                                                     height="512" x="0" y="0" viewBox="0 0 512 512"
                                                     style="enable-background:new 0 0 512 512"
                                                     xml:space="preserve">
                            <g>
                                <g xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="m512 256c0 140.918-112.835 254.779-253.748 255.991-46.334.398-89.854-11.513-127.487-32.662-3.054-1.716-4.991-4.871-5.232-8.366-3.792-55.004-43.503-100.128-95.847-112.086-5.833-1.332-10.599-5.517-12.744-11.102-10.944-28.49-16.942-59.432-16.942-91.775 0-141.787 114.115-255.947 255.902-256 141.43-.053 256.098 114.582 256.098 256z"
                                        fill="#F44545" data-original="#f44545"></path>
                                    <path
                                        d="m467 231c0 102.725-83.275 186-186 186s-186-83.275-186-186 83.275-186 186-186 186 83.275 186 186z"
                                        fill="#FB5858" data-original="#fb5858"></path>
                                    <path
                                        d="m401.977 213.63-2.494 2.494c-5.288 5.288-13.542 5.802-19.407 1.543 4.259 5.865 3.745 14.119-1.543 19.407l-2.495 2.494c-5.288 5.288-13.542 5.802-19.407 1.543 4.259 5.865 3.745 14.119-1.543 19.407l-2.494 2.494c-5.288 5.288-13.542 5.802-19.406 1.543 4.259 5.865 3.745 14.119-1.543 19.407l-2.494 2.494c-5.858 5.858-15.355 5.858-21.213 0l-54.651-54.651c-5.858-5.858-5.858-15.355 0-21.213l2.494-2.494c5.288-5.288 13.542-5.802 19.407-1.543-4.259-5.865-3.745-14.119 1.543-19.407l2.494-2.494c5.288-5.288 13.542-5.802 19.407-1.543-4.259-5.865-3.745-14.119 1.543-19.407l2.494-2.494c5.288-5.288 13.542-5.802 19.407-1.543-4.259-5.865-3.745-14.119 1.543-19.407l2.495-2.494c5.858-5.858 15.355-5.858 21.213 0l54.651 54.651c5.857 5.858 5.857 15.356-.001 21.213z"
                                        fill="#E09380" data-original="#e09380"></path>
                                    <path
                                        d="m280.612 244.907 22.917 22.917-158.841 158.842-83.767-83.767 97.987-97.987c2.618-2.618 4.81-5.63 6.496-8.927l38.65-75.583c5.291-10.346 15.316-17.442 26.833-18.993l105.833-14.25 16.725 16.725-70.472 70.472 14.094 14.094z"
                                        fill="#FFBEAA" data-original="#ffbeaa"></path>
                                    <path
                                        d="m353.445 143.885-3.111 3.111-105.15 14.158c-11.516 1.551-21.542 8.647-26.832 18.993l-38.65 75.583c-1.686 3.297-3.878 6.309-6.496 8.927l-95.264 95.263-17.021-17.021 97.987-97.987c2.618-2.618 4.81-5.63 6.496-8.927l38.65-75.583c5.291-10.346 15.316-17.442 26.833-18.993l105.833-14.25z"
                                        fill="#FAA68E" data-original="#faa68e"></path>
                                    <path
                                        d="m447.523 165.268-128.811 55.492c-.114-.154-.228-.309-.343-.463-23.739-31.968-40.239-68.717-48.353-107.699l-10.157-48.79c-.424-2.039.644-4.095 2.557-4.919l120.594-51.952c2.547-1.097 5.46.417 6.025 3.132l9.792 47.037c8.115 38.982 24.614 75.732 48.353 107.699.114.154.228.308.343.463z"
                                        fill="#71892E" data-original="#71892e"></path>
                                    <path
                                        d="m453.72 162.598-12.399 5.342c-23.832-32.333-40.745-70.172-48.931-109.494l-9.245-44.408-116.485 50.181 9.792 47.039c7.866 37.785 24.187 74.135 47.196 105.12.423.57.844 1.141 1.262 1.713l-12.399 5.342c-23.832-32.332-40.745-70.173-48.931-109.494l-10.157-48.79c-1.056-5.074 1.632-10.245 6.392-12.296l120.593-51.954c3.035-1.308 6.457-1.183 9.389.341 2.267 1.178 4.017 3.076 5.006 5.372.291.674.515 1.383.668 2.117l9.792 47.037c7.866 37.785 24.187 74.135 47.196 105.12.423.569.843 1.14 1.261 1.712z"
                                        fill="#9BCF1B" data-original="#9bcf1b"></path>
                                    <path
                                        d="m457.717 105.14c-7.713 37.75-7.388 76.686.935 114.277.278 1.256-5.76 4.326-5.76 4.326h-24.577l-10.294-6.7-56.48 1.223-15.393 5.478h-26.76c-.044-.187-.087-.374-.132-.561-9.154-38.752-9.767-79.03-1.796-118.042l9.976-48.828c.417-2.04 2.212-3.505 4.294-3.505h131.31c2.773 0 4.849 2.543 4.294 5.26z"
                                        fill="#7FA32F" data-original="#7fa32f"></path>
                                    <path
                                        d="m474 57.174c0 .734-.074 1.474-.224 2.209l-9.618 47.073c-7.106 34.781-7.163 71.276-.222 106.134.006.03.012.061.018.093 1.146 5.716-3.211 11.06-9.041 11.06h-2.021c-9.094-39.123-9.656-80.567-1.617-119.92l9.08-44.442h-126.834l-9.618 47.075c-7.866 38.504-7.094 79.111 2.248 117.27-.006.008-.007.009-.013.017h-13.501c-9.095-39.123-9.656-80.568-1.617-119.92l9.977-48.827c1.042-5.101 5.529-8.764 10.735-8.764h131.013c2.932 0 5.817 1.037 7.917 3.083 2.174 2.118 3.338 4.945 3.338 7.859z"
                                        fill="#B9E746" data-original="#b9e746"></path>
                                    <path
                                        d="m428.315 223.743h-82.166c-.567-2.725 3.61-5.447 2.968-8.165-6.18-26.16-7.953-53.537-5.293-80.372h78.661c-.637 8.066-.955 16.164-.955 24.261 0 21.613 2.264 43.226 6.785 64.276z"
                                        fill="#9BCF1B" data-original="#9bcf1b"></path>
                                    <path
                                        d="m428.086 126.441c0 24.207-19.623 43.83-43.83 43.83s-43.83-19.623-43.83-43.83 19.623-43.83 43.83-43.83 43.83 19.623 43.83 43.83z"
                                        fill="#B9E746" data-original="#b9e746"></path>
                                    <path
                                        d="m410.554 126.441c0 14.524-11.774 26.298-26.298 26.298s-26.298-11.774-26.298-26.298 11.774-26.298 26.298-26.298 26.298 11.774 26.298 26.298z"
                                        fill="#CAED73" data-original="#caed73"></path>
                                    <path
                                        d="m410.554 126.441c0 3.06-.523 5.998-1.484 8.729-2.731.961-5.669 1.484-8.729 1.484-14.524 0-26.298-11.774-26.298-26.298 0-3.06.523-5.998 1.484-8.729 2.731-.961 5.669-1.484 8.729-1.484 14.524 0 26.298 11.774 26.298 26.298z"
                                        fill="#DBF3A0" data-original="#dbf3a0"></path>
                                    <path
                                        d="m399.607 171.747-106.808 106.808c-5.858 5.858-15.355 5.858-21.213 0l-2.494-2.494c-5.858-5.858-5.858-15.355 0-21.213l106.808-106.808c5.858-5.858 15.355-5.858 21.213 0l2.495 2.494c5.856 5.858 5.856 15.355-.001 21.213z"
                                        fill="#FFBEAA" data-original="#ffbeaa"></path>
                                    <path
                                        d="m312.863 232.106h-54.383v-50.043h28.812c3.07 6.166 6.364 12.218 9.871 18.137l-7.505 7.505c-3.674 3.674-3.674 9.63 0 13.304 3.674 3.674 9.63 3.674 13.304 0l4.584-4.584c1.63 2.363 3.296 4.699 4.997 7.007z"
                                        fill="#FFBEAA" data-original="#ffbeaa"></path>
                                    <path
                                        d="m400.564 158.936-5.198 5.198c-2.929 2.929-7.678 2.929-10.607 0l-1.247-1.247c-2.929-2.929-2.929-7.678 0-10.607l5.198-5.198c2.929-2.929 7.678-2.929 10.606 0l1.247 1.247c2.929 2.93 2.929 7.678.001 10.607z"
                                        fill="#FFF5F5" data-original="#fff5f5"></path>
                                    <path
                                        d="m50.372 328.439 56.149-56.149c1.953-1.953 5.118-1.953 7.071 0l30.247 30.247c1.953 1.953 1.953 5.118 0 7.071l-56.149 56.149c-1.953 1.953-5.118 1.953-7.071 0l-30.247-30.247c-1.953-1.953-1.953-5.118 0-7.071z"
                                        fill="#DCE6EB" data-original="#dce6eb"></path>
                                    <path
                                        d="m75.434 353.502 56.149-56.149c1.953-1.953 5.118-1.953 7.071 0l76.642 76.642c1.953 1.953 1.953 5.118 0 7.071l-56.149 56.149c-1.953 1.953-5.118 1.953-7.071 0l-76.642-76.642c-1.952-1.953-1.952-5.119 0-7.071z"
                                        fill="#FFF5F5" data-original="#fff5f5"></path>
                                    <path
                                        d="m198.841 404.954c1.953 1.953 1.953 5.118 0 7.071l-67.581 67.581c-52.046-29.097-92.889-75.838-114.432-132.128l58.733-58.733c1.953-1.953 5.119-1.953 7.071 0z"
                                        fill="#2E5AAC" data-original="#2e5aac"></path>
                                    <path
                                        d="m38.186 390.576c-8.405-13.574-15.576-27.992-21.357-43.097l58.733-58.733c1.953-1.953 5.119-1.953 7.071 0l28.692 28.692z"
                                        fill="#274C91" data-original="#274c91"></path>
                                    <path
                                        d="m174.206 415.881c-3.273 3.273-8.581 3.273-11.854 0s-3.273-8.581 0-11.854 8.58-3.273 11.854 0 3.274 8.581 0 11.854z"
                                        fill="#FFB52D" data-original="#ffb52d"></path>
                                </g>
                            </g>
                          </svg>
                                                <span class="ms-2"> cash </span>

                                            </label>
                                        </div>
                                        {{--  PAYMENT--}}
                                        <div class="genderOption payment m-1">
                                            <input type="radio" class="btn-check" name="payment" value="visa"
                                                   id="option2">
                                            <label class=" mb-0 btn btn-outline" for="option2">
                                                <svg xmlns="http://www.w3.org/2000/svg" version="1.1"
                                                     xmlns:xlink="http://www.w3.org/1999/xlink"
                                                     xmlns:svgjs="http://svgjs.com/svgjs" width="512"
                                                     height="512" x="0" y="0" viewBox="0 0 473.96 473.96"
                                                     style="enable-background:new 0 0 512 512" xml:space="preserve">
                            <g>
                                <circle xmlns="http://www.w3.org/2000/svg" style="" cx="236.98" cy="236.99" r="236.97"
                                        fill="#F3F2F2" data-original="#f3f2f2"></circle>
                                <g xmlns="http://www.w3.org/2000/svg">
                                    <polygon style=""
                                             points="175.483,282.447 193.616,175.373 222.973,175.373 204.841,282.447  "
                                             fill="#293688" data-original="#293688"></polygon>
                                    <path style=""
                                          d="M309.352,178.141c-5.818-2.17-14.933-4.494-26.316-4.494c-29.014,0-49.451,14.526-49.627,35.337   c-0.161,15.382,14.589,23.962,25.732,29.088c11.427,5.238,15.27,8.599,15.214,13.28c-0.071,7.177-9.13,10.458-17.571,10.458   c-11.749-0.004-17.994-1.624-27.637-5.62l-3.783-1.706l-4.123,23.97c6.859,2.99,19.543,5.583,32.71,5.714   c30.858-0.007,50.899-14.353,51.124-36.583c0.112-12.179-7.712-21.448-24.651-29.092c-10.264-4.947-16.55-8.251-16.482-13.272   c0-4.449,5.324-9.208,16.815-9.208c9.601-0.15,16.557,1.931,21.979,4.101l2.627,1.235L309.352,178.141L309.352,178.141z"
                                          fill="#293688" data-original="#293688"></path>
                                    <path style=""
                                          d="M359.405,175.373c-7.034,0-12.116,2.148-15.207,9.119l-43.509,97.959h31.083l6.043-16.408h37.137   l3.45,16.408h27.633L381.86,175.376h-22.454L359.405,175.373L359.405,175.373z M346.062,244.618   c2.425-6.166,11.693-29.927,11.693-29.927c-0.168,0.281,2.413-6.196,3.895-10.215l1.987,9.227c0,0,5.616,25.56,6.795,30.918h-24.37   V244.618z"
                                          fill="#293688" data-original="#293688"></path>
                                    <path style=""
                                          d="M121.946,248.771l-2.586-14.679c-5.358-17.111-21.987-35.625-40.621-44.901l25.938,93.256h31.09   l46.626-107.074H151.31L121.946,248.771z"
                                          fill="#293688" data-original="#293688"></path>
                                </g>
                                <g xmlns="http://www.w3.org/2000/svg">
                                    <path style=""
                                          d="M46.823,175.373v1.729c36.838,8.86,62.413,31.259,72.538,56.991l-10.645-49.582   c-1.777-6.776-7.162-8.902-13.534-9.137L46.823,175.373L46.823,175.373z"
                                          fill="#F7981D" data-original="#f7981d"></path>
                                    <path style=""
                                          d="M236.964,473.958c91.464,0,170.77-51.846,210.272-127.725H26.696   C66.201,422.112,145.504,473.958,236.964,473.958z"
                                          fill="#F7981D" data-original="#f7981d"></path>
                                </g>
                                <path xmlns="http://www.w3.org/2000/svg" style=""
                                      d="M236.964,0C146.952,0,68.663,50.184,28.548,124.103h416.84C405.268,50.188,326.976,0,236.964,0z"
                                      fill="#293688" data-original="#293688"></path>
                                <g xmlns="http://www.w3.org/2000/svg">
                                </g>
                                <g xmlns="http://www.w3.org/2000/svg">
                                </g>
                                <g xmlns="http://www.w3.org/2000/svg">
                                </g>
                                <g xmlns="http://www.w3.org/2000/svg">
                                </g>
                                <g xmlns="http://www.w3.org/2000/svg">
                                </g>
                                <g xmlns="http://www.w3.org/2000/svg">
                                </g>
                                <g xmlns="http://www.w3.org/2000/svg">
                                </g>
                                <g xmlns="http://www.w3.org/2000/svg">
                                </g>
                                <g xmlns="http://www.w3.org/2000/svg">
                                </g>
                                <g xmlns="http://www.w3.org/2000/svg">
                                </g>
                                <g xmlns="http://www.w3.org/2000/svg">
                                </g>
                                <g xmlns="http://www.w3.org/2000/svg">
                                </g>
                                <g xmlns="http://www.w3.org/2000/svg">
                                </g>
                                <g xmlns="http://www.w3.org/2000/svg">
                                </g>
                                <g xmlns="http://www.w3.org/2000/svg">
                                </g>
                            </g>
                          </svg>
                                                <span class="ms-2"> visa </span>
                                            </label>
                                        </div>
                                        {{--  PAYMENT--}}
                                        <div class="genderOption payment m-1">
                                            <input type="radio" class="btn-check" name="payment" value="mastercard"
                                                   id="option3">
                                            <label class=" mb-0 btn btn-outline" for="option3">
                                                <svg viewBox="0 0 256 199" version="1.1" xmlns="http://www.w3.org/2000/svg"
                                                     xmlns:xlink="http://www.w3.org/1999/xlink"
                                                     preserveAspectRatio="xMidYMid">
                                                    <g>
                                                        <path
                                                            d="M46.5392504,198.011312 L46.5392504,184.839826 C46.5392504,179.790757 43.4659038,176.497885 38.1973096,176.497885 C35.5630125,176.497885 32.7091906,177.375984 30.7334678,180.229806 C29.1967945,177.815034 27.0015469,176.497885 23.7086756,176.497885 C21.513428,176.497885 19.3181804,177.15646 17.5619824,179.571233 L17.5619824,176.936935 L12.9519625,176.936935 L12.9519625,198.011312 L17.5619824,198.011312 L17.5619824,186.3765 C17.5619824,182.644579 19.5377052,180.888381 22.6110518,180.888381 C25.6843984,180.888381 27.2210717,182.864103 27.2210717,186.3765 L27.2210717,198.011312 L31.8310916,198.011312 L31.8310916,186.3765 C31.8310916,182.644579 34.0263392,180.888381 36.880161,180.888381 C39.9535076,180.888381 41.490181,182.864103 41.490181,186.3765 L41.490181,198.011312 L46.5392504,198.011312 L46.5392504,198.011312 Z M114.81145,176.936935 L107.347608,176.936935 L107.347608,170.570717 L102.737589,170.570717 L102.737589,176.936935 L98.566618,176.936935 L98.566618,181.107905 L102.737589,181.107905 L102.737589,190.766995 C102.737589,195.59654 104.713311,198.450362 109.981906,198.450362 C111.957628,198.450362 114.152876,197.791787 115.689549,196.913688 L114.372401,192.962243 C113.055252,193.840341 111.518579,194.059866 110.420955,194.059866 C108.225708,194.059866 107.347608,192.742718 107.347608,190.54747 L107.347608,181.107905 L114.81145,181.107905 L114.81145,176.936935 L114.81145,176.936935 Z M153.886857,176.497885 C151.25256,176.497885 149.496362,177.815034 148.398738,179.571233 L148.398738,176.936935 L143.788718,176.936935 L143.788718,198.011312 L148.398738,198.011312 L148.398738,186.156975 C148.398738,182.644579 149.935411,180.668856 152.789233,180.668856 C153.667332,180.668856 154.764956,180.888381 155.643055,181.107905 L156.960204,176.71741 C156.082105,176.497885 154.764956,176.497885 153.886857,176.497885 L153.886857,176.497885 L153.886857,176.497885 Z M94.834697,178.693133 C92.6394495,177.15646 89.566103,176.497885 86.2732315,176.497885 C81.0046375,176.497885 77.492241,179.132183 77.492241,183.303153 C77.492241,186.81555 80.1265385,188.791272 84.736558,189.449847 L86.931806,189.669371 C89.346578,190.10842 90.6637265,190.766995 90.6637265,191.864619 C90.6637265,193.401292 88.9075285,194.498916 85.834182,194.498916 C82.7608355,194.498916 80.346063,193.401292 78.8093895,192.303668 L76.614142,195.816065 C79.0289145,197.572262 82.321786,198.450362 85.614657,198.450362 C91.7613505,198.450362 95.2737465,195.59654 95.2737465,191.645094 C95.2737465,187.913173 92.4199245,185.937451 88.0294295,185.278876 L85.834182,185.059351 C83.858459,184.839826 82.321786,184.400777 82.321786,183.083629 C82.321786,181.546955 83.858459,180.668856 86.2732315,180.668856 C88.9075285,180.668856 91.5418255,181.76648 92.858974,182.425054 L94.834697,178.693133 L94.834697,178.693133 Z M217.329512,176.497885 C214.695215,176.497885 212.939017,177.815034 211.841393,179.571233 L211.841393,176.936935 L207.231373,176.936935 L207.231373,198.011312 L211.841393,198.011312 L211.841393,186.156975 C211.841393,182.644579 213.378066,180.668856 216.231888,180.668856 C217.109987,180.668856 218.207611,180.888381 219.08571,181.107905 L220.402859,176.71741 C219.52476,176.497885 218.207611,176.497885 217.329512,176.497885 L217.329512,176.497885 L217.329512,176.497885 Z M158.496877,187.474123 C158.496877,193.840341 162.887372,198.450362 169.69264,198.450362 C172.765986,198.450362 174.961234,197.791787 177.156481,196.035589 L174.961234,192.303668 C173.205036,193.620817 171.448838,194.279391 169.473115,194.279391 C165.741194,194.279391 163.106897,191.645094 163.106897,187.474123 C163.106897,183.522678 165.741194,180.888381 169.473115,180.668856 C171.448838,180.668856 173.205036,181.32743 174.961234,182.644579 L177.156481,178.912658 C174.961234,177.15646 172.765986,176.497885 169.69264,176.497885 C162.887372,176.497885 158.496877,181.107905 158.496877,187.474123 L158.496877,187.474123 L158.496877,187.474123 Z M201.08468,187.474123 L201.08468,176.936935 L196.47466,176.936935 L196.47466,179.571233 C194.937987,177.595509 192.742739,176.497885 189.888917,176.497885 C183.961749,176.497885 179.351729,181.107905 179.351729,187.474123 C179.351729,193.840341 183.961749,198.450362 189.888917,198.450362 C192.962264,198.450362 195.157512,197.352737 196.47466,195.377015 L196.47466,198.011312 L201.08468,198.011312 L201.08468,187.474123 Z M184.181274,187.474123 C184.181274,183.742202 186.596046,180.668856 190.547492,180.668856 C194.279413,180.668856 196.91371,183.522678 196.91371,187.474123 C196.91371,191.206044 194.279413,194.279391 190.547492,194.279391 C186.596046,194.059866 184.181274,191.206044 184.181274,187.474123 L184.181274,187.474123 Z M129.080559,176.497885 C122.933866,176.497885 118.543371,180.888381 118.543371,187.474123 C118.543371,194.059866 122.933866,198.450362 129.300084,198.450362 C132.373431,198.450362 135.446777,197.572262 137.861549,195.59654 L135.666302,192.303668 C133.910104,193.620817 131.714856,194.498916 129.519609,194.498916 C126.665787,194.498916 123.811965,193.181768 123.153391,189.449847 L138.739648,189.449847 L138.739648,187.693648 C138.959173,180.888381 135.007727,176.497885 129.080559,176.497885 L129.080559,176.497885 L129.080559,176.497885 Z M129.080559,180.449331 C131.934381,180.449331 133.910104,182.20553 134.349153,185.498401 L123.372916,185.498401 C123.811965,182.644579 125.787688,180.449331 129.080559,180.449331 L129.080559,180.449331 Z M243.452958,187.474123 L243.452958,168.594995 L238.842938,168.594995 L238.842938,179.571233 C237.306265,177.595509 235.111017,176.497885 232.257196,176.497885 C226.330027,176.497885 221.720007,181.107905 221.720007,187.474123 C221.720007,193.840341 226.330027,198.450362 232.257196,198.450362 C235.330542,198.450362 237.52579,197.352737 238.842938,195.377015 L238.842938,198.011312 L243.452958,198.011312 L243.452958,187.474123 Z M226.549552,187.474123 C226.549552,183.742202 228.964324,180.668856 232.91577,180.668856 C236.647691,180.668856 239.281988,183.522678 239.281988,187.474123 C239.281988,191.206044 236.647691,194.279391 232.91577,194.279391 C228.964324,194.059866 226.549552,191.206044 226.549552,187.474123 L226.549552,187.474123 Z M72.443172,187.474123 L72.443172,176.936935 L67.833152,176.936935 L67.833152,179.571233 C66.2964785,177.595509 64.101231,176.497885 61.247409,176.497885 C55.3202405,176.497885 50.7102205,181.107905 50.7102205,187.474123 C50.7102205,193.840341 55.3202405,198.450362 61.247409,198.450362 C64.3207555,198.450362 66.5160035,197.352737 67.833152,195.377015 L67.833152,198.011312 L72.443172,198.011312 L72.443172,187.474123 Z M55.3202405,187.474123 C55.3202405,183.742202 57.735013,180.668856 61.6864585,180.668856 C65.4183795,180.668856 68.0526765,183.522678 68.0526765,187.474123 C68.0526765,191.206044 65.4183795,194.279391 61.6864585,194.279391 C57.735013,194.059866 55.3202405,191.206044 55.3202405,187.474123 Z"
                                                            fill="#000000"></path>
                                                        <rect fill="#FF5F00" x="93.2980455" y="16.9034088"
                                                              width="69.1502985" height="124.251009">
                                                        </rect>
                                                        <path
                                                            d="M97.688519,79.0288935 C97.688519,53.783546 109.542856,31.3920209 127.763411,16.9033869 C114.3724,6.3661985 97.468994,-1.94737475e-05 79.0289145,-1.94737475e-05 C35.3434877,-1.94737475e-05 1.7258174e-06,35.3434665 1.7258174e-06,79.0288935 C1.7258174e-06,122.71432 35.3434877,158.057806 79.0289145,158.057806 C97.468994,158.057806 114.3724,151.691588 127.763411,141.1544 C109.542856,126.88529 97.688519,104.274241 97.688519,79.0288935 Z"
                                                            fill="#EB001B"></path>
                                                        <path
                                                            d="M255.746345,79.0288935 C255.746345,122.71432 220.402859,158.057806 176.717432,158.057806 C158.277352,158.057806 141.373945,151.691588 127.982936,141.1544 C146.423015,126.665766 158.057827,104.274241 158.057827,79.0288935 C158.057827,53.783546 146.20349,31.3920209 127.982936,16.9033869 C141.373945,6.3661985 158.277352,-1.94737475e-05 176.717432,-1.94737475e-05 C220.402859,-1.94737475e-05 255.746345,35.5629913 255.746345,79.0288935 Z"
                                                            fill="#F79E1B"></path>
                                                    </g>
                                                </svg>
                                                <span class="ms-2"> mastercard </span></button>
                                            </label>
                                        </div>
                                        {{--  PAYMENT--}}
                                        <div class="genderOption payment m-1">
                                            <input type="radio" class="btn-check" name="payment" value="Meeza"
                                                   id="option4">
                                            <label class=" mb-0 btn btn-outline" for="option4">
                                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                     viewBox="0 0 163 88" style="enable-background:new 0 0 163 88;" xml:space="preserve">
	<style type="text/css">
        .st0{fill:#FFFFFF;}
        .st1{fill:#510C76;}
        .st2{fill:#EB6B24;}
        .st3{fill:#FFFFFF;stroke:#FFFFFF;stroke-miterlimit:10;}
    </style>
                                                    <path class="st0" d="M147.2,12.5L143,65.8c-0.4,5.4-4.9,9.6-10.3,9.7h-87c-21.5,0-23-8.3-21.9-24l3.5-39L147.2,12.5z"/>
                                                    <path class="st1" d="M60.8,12.5l-4.5,63H34.5c-21.5,0-23-8.3-21.9-24l3.5-39H60.8z"/>
                                                    <path class="st1" d="M65.9,38l-0.8,11.5c-0.4,4.2,2.7,7.9,6.9,8.3c0.2,0,0.5,0,0.7,0h3.5c4.6-0.1,8.4-3.7,8.7-8.3l1.3-19.8H74.7
		C70,29.8,66.2,33.4,65.9,38z M77.9,49.5c-0.1,0.6-0.6,1.1-1.2,1.1h-3.5c-0.6,0-1-0.4-1-1c0,0,0-0.1,0-0.1L73,38
		c0.1-0.6,0.6-1.1,1.2-1.1h4.6L77.9,49.5z"/>
                                                    <path class="st1" d="M130.8,29.7h-11.7l-1.3,19.8c0,0.8,0,1.5,0.2,2.2h-0.5c-3.7,0-5.5-2.6-5.2-7.4l0.6-8.4l0,0l0.2-3
		c0.1-1.7-1.2-3.1-2.9-3.3c-0.1,0-0.1,0-0.2,0h-4l-0.2,3.3l-0.5,8v0.5v0.8l-0.1,0.9v0.4V44v0.3l0,0l-0.1,2c-0.1,1.6,0,3.2,0.3,4.8
		c-0.9,0.5-1.8,0.7-2.8,0.7c-3.2,0-7.3-1-7.3-6.6L95.9,33c0.2-1.7-1.1-3.2-2.8-3.3c-0.1,0-0.2,0-0.2,0h-4L88.7,33l-1.9,28.7
		c-0.1,1.8-0.4,6.3-0.4,6.3h3.9c1.8,0,3.4-1.5,3.5-3.3l0.4-7c1.1,0.6,3.9,0.9,5.6,0.9c2.8,0,5.4-1.2,7.2-3.3c1.7,2.1,4.3,3.3,7.7,3.3
		c2.3,0,4.5-0.7,6.3-2c0.7,0.7,1.5,1.2,2.5,1.5l0,0c0.6,0.2,1.3,0.2,1.9,0.2h3.5c4.6-0.1,8.4-3.7,8.8-8.3l0.8-11.9
		c0.4-4.2-2.7-7.9-6.9-8.3C131.3,29.7,131,29.7,130.8,29.7z M130.6,49.9c0,0.6-0.6,1.1-1.2,1.1h-3.5c-0.6,0-1-0.4-1-1
		c0,0,0-0.1,0-0.1l0.8-13h4.6c0.6,0,1,0.4,1,1c0,0,0,0.1,0,0.1L130.6,49.9z"/>
                                                    <path class="st1" d="M70,22.9l-0.1,1.6c-0.1,1.5,1,2.9,2.5,3c0.1,0,0.2,0,0.2,0h1.3c1.7,0,3-1.3,3.2-3l0.3-4.6h-4.3
		C71.5,19.9,70.1,21.2,70,22.9z"/>
                                                    <path class="st1" d="M78.1,22.9L78,24.5c-0.1,1.5,1,2.9,2.6,3c0.1,0,0.1,0,0.2,0H82c1.7,0,3-1.3,3.2-3l0.3-4.6h-4.2
		C79.6,19.9,78.2,21.2,78.1,22.9z"/>
                                                    <path class="st2" d="M91.9,27.4h1.6c1.5,0.1,2.9-1,3-2.6c0,0,0-0.1,0-0.1l0.1-1.3c0.1-1.7-0.8-3.5-2.4-3.5l-4.9,0l-0.3,4.2
		C88.9,25.8,90.2,27.3,91.9,27.4z"/>
                                                    <path class="st1" d="M95.6,63.4L95.5,65c-0.1,1.5,1,2.9,2.5,3c0.1,0,0.2,0,0.3,0h1.3c1.7,0,3-1.3,3.2-3l0.3-4.6h-4.2
		C97.1,60.4,95.7,61.8,95.6,63.4z"/>
                                                    <path class="st1" d="M104.2,63.4l-0.1,1.6c-0.1,1.5,1,2.9,2.5,3c0.1,0,0.2,0,0.2,0h1.3c1.7,0,3-1.3,3.2-3l0.3-4.6h-4.2
		C105.7,60.4,104.3,61.8,104.2,63.4z"/>
                                                    <path class="st1" d="M109.4,27.3h-0.9c-0.2,0-0.2-0.1-0.2-0.2l0.3-3.8c0-0.3,0-0.6,0-0.9c0-0.4-0.2-0.6-0.6-0.6s-0.7,0-1,0
		c-0.1,0-0.1,0-0.1,0.1c0.1,0.6,0.1,1.2,0,1.7c-0.1,0.8-0.1,1.7-0.2,2.5c0,0.3,0,0.6-0.1,0.9s-0.1,0.2-0.3,0.2h-1.8
		c-0.2,0-0.2,0-0.2-0.2c0.1-1.3,0.2-2.6,0.3-3.9c0-0.3,0-0.6,0-0.9c0-0.3-0.2-0.5-0.4-0.5c0,0-0.1,0-0.1,0c-0.3,0-0.7,0-1,0
		c-0.1,0-0.1,0-0.1,0.1c-0.1,0.8-0.1,1.6-0.2,2.4s-0.1,1.8-0.2,2.7c0,0.2-0.1,0.3-0.3,0.3h-1.8c-0.2,0-0.3-0.1-0.2-0.3
		c0.1-1.3,0.2-2.7,0.3-4c0.1-0.9,0.1-1.8,0.2-2.7c0-0.2,0.1-0.2,0.3-0.3c0.5-0.1,0.9-0.1,1.4-0.2c0.8-0.1,1.5-0.1,2.3,0
		c0.4,0,0.9,0.2,1.3,0.3c0.1,0,0.1,0,0.2,0c0.8-0.3,1.7-0.4,2.5-0.4c0.4,0,0.7,0.1,1.1,0.2c0.6,0.2,1.1,0.7,1.2,1.3
		c0.1,0.5,0.1,1.1,0,1.6l-0.2,3.3c0,0.3,0,0.6-0.1,0.9s-0.1,0.2-0.3,0.2L109.4,27.3z"/>
                                                    <path class="st1" d="M123.1,24.3h-2c-0.1,0-0.2,0-0.2,0.2c0,0.6,0.2,0.9,0.8,0.9c0.5,0,0.9,0,1.4,0h1.4c0.2,0,0.3,0,0.3,0.3
		c0,0.4,0,0.8-0.1,1.3c0,0.1-0.1,0.2-0.2,0.2c0,0,0,0,0,0c-0.7,0.1-1.3,0.2-2,0.2c-0.6,0-1.2,0-1.8,0c-0.4,0-0.8-0.2-1.2-0.4
		c-0.4-0.3-0.7-0.7-0.7-1.2c-0.1-0.7-0.1-1.4,0-2.1c0-0.6,0.1-1.2,0.3-1.8c0.1-0.6,0.5-1.2,1.1-1.5c0.3-0.2,0.7-0.3,1.1-0.4
		c0.9-0.1,1.8-0.1,2.6,0c0.4,0.1,0.8,0.2,1.1,0.5c0.3,0.3,0.6,0.8,0.6,1.3c0.1,0.8,0.1,1.6,0,2.4c0,0.1-0.1,0.2-0.2,0.2H125
		L123.1,24.3z M121.1,22.9h1.8c0.5,0,0.5,0,0.4-0.5c0-0.3-0.3-0.5-0.6-0.6c-0.2,0-0.5,0-0.7,0c-0.4,0-0.7,0.2-0.8,0.6
		C121.1,22.5,121.1,22.7,121.1,22.9z"/>
                                                    <path class="st1" d="M115.9,24.3c-0.7,0-1.3,0-1.9,0c-0.2,0-0.2,0.1-0.2,0.2c0,0.6,0.2,0.8,0.8,0.9c0.2,0,0.4,0,0.5,0h2.3
		c0.2,0,0.3,0,0.2,0.2c0,0.4-0.1,0.9-0.1,1.3c0,0.1-0.1,0.2-0.2,0.2c0,0,0,0,0,0c-0.6,0.1-1.3,0.1-1.9,0.2c-0.7,0-1.4,0-2.2-0.1
		c-0.3,0-0.6-0.2-0.9-0.3c-0.4-0.3-0.7-0.7-0.8-1.3c-0.1-0.8-0.1-1.5,0-2.3c0-0.5,0.1-1,0.2-1.5c0.1-0.7,0.5-1.3,1.1-1.6
		c0.3-0.2,0.7-0.3,1.1-0.3c0.9-0.1,1.8-0.1,2.7,0c0.4,0.1,0.8,0.2,1.1,0.5c0.4,0.3,0.6,0.8,0.6,1.3c0,0.6,0,1.2,0,1.7
		c0,0.2,0,0.4,0,0.5c0,0.1-0.1,0.3-0.3,0.3L115.9,24.3L115.9,24.3z M116.1,22.9c0-0.2,0-0.4,0-0.6c0-0.3-0.3-0.5-0.5-0.5
		c-0.2,0-0.5,0-0.7,0c-0.6,0-0.9,0.5-0.9,1.1L116.1,22.9z"/>
                                                    <path class="st1" d="M135.1,21.7h-1.3c-0.2,0-0.3-0.1-0.2-0.2c0-0.4,0.1-0.9,0.1-1.3c0-0.1,0.1-0.2,0.2-0.2c1-0.2,2.1-0.3,3.1-0.2
		c0.5,0,0.9,0.1,1.4,0.2c0.7,0.2,1.2,0.9,1.2,1.6c0,0.9-0.1,1.8-0.2,2.8l-0.1,2.1c0,0.4-0.1,0.5-0.5,0.6c-1.3,0.2-2.6,0.3-3.9,0.2
		c-0.3,0-0.7-0.1-1-0.1c-0.5-0.1-0.9-0.6-1-1.1c-0.1-0.7-0.1-1.4,0.2-2c0.2-0.6,0.8-1.1,1.5-1.1c0.4-0.1,0.7-0.1,1.1-0.1
		c0.5,0,1,0,1.5,0c0.1,0,0.1,0,0.1-0.1v-0.1c0-0.5-0.2-0.8-0.8-0.8L135.1,21.7z M137.1,24.1c-0.5,0-1,0-1.4,0c-0.3,0-0.6,0.2-0.6,0.5
		c0,0.1,0,0.2,0,0.3c0,0.3,0.2,0.5,0.4,0.5c0,0,0,0,0.1,0c0.5,0,1,0,1.4-0.1c0,0,0.1,0,0.1-0.1C137,24.9,137,24.5,137.1,24.1
		L137.1,24.1z"/>
                                                    <path class="st1" d="M129.1,25.3h3c0.1,0,0.1,0.1,0.1,0.2c0,0.5-0.1,1-0.1,1.5c0,0.2-0.1,0.2-0.3,0.2H126c-0.3,0-0.3-0.1-0.3-0.3
		s0-0.7,0.1-1c0-0.1,0.1-0.2,0.1-0.3l2.8-3.3l0.5-0.6h-2.7c-0.3,0-0.3,0-0.3-0.3l0.1-1.3c0-0.2,0.1-0.3,0.3-0.3h5.6
		c0.2,0,0.3,0.1,0.2,0.3c0,0.4,0,0.7-0.1,1.1c0,0.1,0,0.2-0.1,0.3c-1,1.2-2,2.5-3,3.7L129.1,25.3z"/>
                                                    <path class="st2" d="M117.1,60.8c-1.8,0.1-3.2,1.5-3.3,3.3l-0.3,3.9h20c1.8-0.1,3.2-1.5,3.3-3.3l0.3-3.9H117.1z"/>
                                                    <path class="st3" d="M130.4,77H34.5c-10.1,0-16.2-1.7-19.9-5.6c-4.4-4.8-4.3-12.3-3.8-20.2l3.6-40.7l134.7,0.1l-4.3,53
		C144.1,71.1,137.9,76.8,130.4,77z M17.7,14l-3.3,37.5C13.8,60,14.1,65.6,17.2,69c2.9,3.1,8.4,4.5,17.3,4.5h95.9
		c5.7-0.2,10.4-4.5,11.1-10.2l4-49.2L17.7,14z"/>
                                                    <path class="st0" d="M40.8,58H29.4c-1.7,0-3-1.3-3-3c0-0.1,0-0.2,0-0.3l1.6-22c0.2-1.8,1.7-3.2,3.5-3.3h11.3c1.7,0,3,1.3,3,3
		c0,0.1,0,0.2,0,0.3l-1.6,22C44.1,56.5,42.6,58,40.8,58z M31.3,31.7c-0.6,0-1,0.4-1.1,1l-1.6,22c0,0.6,0.4,1,1,1H41
		c0.6,0,1-0.4,1.1-1l1.6-22c0-0.6-0.4-1-1-1H31.3z"/>
                                                    <polygon class="st0" points="43.7,51 43.5,53.2 27.7,53.2 27.9,51 "/>
</svg>

                                                <span class="ms-2"> Meeza </span>
                                            </label>
                                        </div>
                                        {{--  PAYMENT--}}
                                        <div class="genderOption payment m-1">
                                            <input type="radio" class="btn-check" name="payment" value="voucher"
                                                   id="option5">
                                            <label class=" mb-0 btn btn-outline" for="option5">
                                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                     viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve">
<path style="fill:#F53000;" d="M512,401.805c0,8.501-6.892,15.393-15.393,15.393H15.393C6.892,417.199,0,410.307,0,401.805V110.195
	c0-8.501,6.892-15.393,15.393-15.393h481.213c8.501,0,15.393,6.892,15.393,15.393L512,401.805L512,401.805z"/>
                                                    <path style="fill:#2D2E30;" d="M512,401.805V110.195c0-8.501-6.892-15.393-15.393-15.393H317.024
	c-0.205,2.869,0.781,5.809,2.975,8.004l17.65,17.65c4.014,4.014,4.014,10.523,0,14.536L320,152.639
	c-4.014,4.014-4.014,10.523,0,14.536l17.65,17.65c4.014,4.014,4.014,10.523,0,14.536L320,217.01c-4.014,4.014-4.014,10.523,0,14.536
	l17.65,17.65c4.014,4.014,4.014,10.523,0,14.536L320,281.381c-4.014,4.014-4.014,10.523,0,14.536l17.65,17.65
	c4.014,4.014,4.014,10.523,0,14.536L320,345.752c-4.014,4.014-4.014,10.523,0,14.536l17.65,17.65c4.014,4.014,4.014,10.523,0,14.536
	L320,410.123c-1.958,1.958-2.954,4.51-3.002,7.076h179.608C505.108,417.199,512,410.307,512,401.805z"/>
                                                    <path style="fill:#FFFFFF;" d="M102.579,237.313v-27.802c0-19.384,12.727-26.431,29.369-26.431c16.445,0,29.368,7.049,29.368,26.431
	v27.802c0,19.384-12.922,26.431-29.368,26.431C115.305,263.745,102.579,256.697,102.579,237.313z M141.736,209.512
	c0-6.461-3.72-9.397-9.789-9.397c-6.069,0-9.594,2.937-9.594,9.397v27.802c0,6.461,3.525,9.397,9.594,9.397s9.789-2.936,9.789-9.397
	V209.512z M222.01,185.43c0,1.175-0.196,2.546-0.782,3.72l-68.919,141.163c-1.37,2.937-5.091,4.895-8.811,4.895
	c-6.656,0-10.965-5.483-10.965-10.377c0-1.174,0.392-2.546,0.979-3.72l68.722-141.164c1.566-3.328,4.699-4.894,8.223-4.894
	C215.94,175.053,222.01,179.164,222.01,185.43z M192.445,300.357v-27.802c0-19.384,12.727-26.431,29.368-26.431
	c16.446,0,29.369,7.049,29.369,26.431v27.802c0,19.384-12.922,26.431-29.369,26.431
	C205.172,326.788,192.445,319.741,192.445,300.357z M231.603,272.555c0-6.461-3.72-9.397-9.789-9.397s-9.593,2.936-9.593,9.397
	v27.802c0,6.461,3.524,9.397,9.593,9.397s9.789-2.937,9.789-9.397V272.555z"/>
                                                    <path style="fill:#FAE246;" d="M465.963,382.354H46.924c-9.22,0-16.696-7.475-16.696-16.696V141.948
	c0-9.22,7.475-16.696,16.696-16.696h419.04c9.22,0,16.696,7.475,16.696,16.696v223.711
	C482.659,374.88,475.184,382.354,465.963,382.354z M63.619,348.962h385.648V158.643H63.619V348.962z"/>
                                                    <path style="fill:#E3C129;" d="M465.963,125.252H340.348c0.834,3.379-0.058,7.097-2.699,9.738L320,152.639
	c-1.685,1.685-2.652,3.81-2.923,6.005h132.192v190.319H317.83c-1.611,3.751-0.893,8.263,2.17,11.325l17.65,17.65
	c1.274,1.274,2.14,2.799,2.606,4.417h125.709c9.22,0,16.696-7.475,16.696-16.696V141.949
	C482.659,132.727,475.184,125.252,465.963,125.252z"/>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
                                                    <g>
                                                    </g>
</svg>
                                                <span class="ms-2"> voucher </span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="row align-items-end">
                                        <div class="col-8 col-md-9 p-2 ">
                                            <label> Amount </label>
                                            <input class="form-control" type="number" id="amount"
                                                   onchange="calculateChange()" onkeyup="calculateChange()" min="0" step="any"/>
                                        </div>
                                        {{--                                            <div class="col-4 col-md-3 p-2">--}}
                                        {{--                                                <button type="button" class="btn w-100 btn-success"> Pay</button>--}}
                                        {{--                                            </div>--}}
                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="row">
                            <div class="button-row d-flex mt-4 col-12">
                                <button class="btn bg-gradient-secondary mb-0 js-btn-prev" type="button" id="lastPrev">
                                    Prev
                                </button>
                                <button class="btn bg-gradient-dark ms-auto mb-0" id="confirmBtn"> Confirm</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class=" col-lg-3 p-1 ">
                <div class=" bill" id="bill">
                    <h4 class="font-weight-bolder ps-2">Bill</h4>
                    <div class="info">
                        <h6 class="billTitle"> ticket <span id="RandTicket">{{$rev->ticket_num}}</span></h6>
                        <ul>
                            <li><label> Shop Name : </label> <strong>Kids station company</strong></li>
                            <li><label> شركه محطه الاطفال : </label> <strong>اسم المحل</strong></li>
                            <li><label> الرقم الضريبي : </label> <strong>7030324813</strong></li>
                            <li><label> 7030324813 : </label> <strong>Vat Reg No</strong></li>
                            <li><label> Cashier Name : </label> <strong>{{$add_by}}</strong></li>
                            <li><label> Visit Date : </label> <strong id="dateOfTicket">{{$rev->day}}</strong></li>
                            <li><label> Reservation Duration : </label> <strong id="hourOfTicket"
                                                                                style="text-transform: none !important;">{{$rev->hours_count}}
                                    h</strong>
                            </li>
                        </ul>
                    </div>
                    <div class="info firstInfo">
                        <h6 class="billTitle"> visitors</h6>
                        <div class="items">
                            <div class="itemsHead row visitorItemRows">
                                <span class="col">type</span>
                                <span class="col"> Quantity </span>
                                <span class="col"> price </span>
                            </div>
                            @foreach($rev->models->groupBy('visitor_type_id') as $visitor)
                                <div class="item row insertRows">
                                    <span class="col">{{$visitor[0]->type->title}}</span>
                                    <span class="col" style="text-transform: initial !important;"> {{$visitor->count()}}</span>
                                    <span class="col"> {{$visitor->sum('price')}} EGP</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="info secondInfo">
                        @if(count($products) > 0)
                            <h6 class="billTitle"> products</h6>
                            <div class="items">
                                <div class="itemsHead row">
                                    <span class="col">type</span>
                                    <span class="col"> Quantity </span>
                                    <span class="col"> price </span>
                                </div>
                                @foreach($products as $product)
                                    <div class="item row">
                                        <span class="col">{{$product->product->title}} </span>
                                        <span class="col"> {{$product->qty}} </span>
                                        <span class="col"> {{$product->total_price}} EGP </span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                    <div class="info thirdInfo">

                    </div>
                    @php
                        $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
                    @endphp
                    <div class="myBarcode">
                        {!! $generator->getBarcode($rev->ticket_num, $generator::TYPE_CODE_128) !!}
                    </div>
                    <div id="printDiv" style="display: none">
                        <div class="printBtn">
                            <a class="btn btn-outline-info fw-normal " id="accessBtn"><i
                                    class="fas fa-sign-out me-2"></i>
                                Access
                            </a>
                            <a class="btn btn-info " target="_blank"  id="printBtn"><i class="fal fa-print me-2"></i> Print</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('js')
    <script type="text/javascript" src="{{asset('assets/sales')}}/js/plugins/multistep-form.js"></script>

    @include('sales.layouts.assets.editDataTable')
    <script>

        // $(document).on('click', '#thirdNext', function () {
        //     var oldPayRev = $('#oldPayRev').val();
        //     var totalPrice = $('#totalPrice').text();
        //     var newRevenue = totalPrice - oldPayRev;
        //     $('#revenue').text(newRevenue);
        // })


        $(document).ready(function () {
            checkTime()
        });
    </script>
    <script>
        $('form').on('submit', function (e) {
            e.preventDefault();
            var duration = $('#duration').val(),
                visit_date = $('#date').val(),
                shift_id = $('#choices-shift').val(),
                visitor_type = $("span[id='visitor_type[]']").map(function () {
                    return $(this).attr('data-type_id');
                }).get(),
                visitor_price = $("span[id='visitor_price[]']").map(function () {
                    return $(this).attr('data-price');
                }).get(),
                visitor_birthday = $("input[id='visitor_birthday[]']").map(function () {
                    return $(this).val();
                }).get(),
                visitor_name = $("input[name='visitor_name[]']").map(function () {
                    return $(this).val();
                }).get(),
                gender = $(".choose input:checked").map(function () {
                    return $(this).val();
                }).get(),
                product_id = $("input[name='product_id[]']").map(function () {
                    return $(this).val();
                }).get(),
                ticket_price    =  $("#beforeTax").text(),
                ent_tax         =  $("#ent").text(),
                vat             =  $("#vat").text(),
                product_qty = $("input[name='proQtyInput[]']").map(function () {
                    return $(this).val();
                }).get(),
                product_price = $("input[name='proTotalInput[]']").map(function () {
                    return $(this).val();
                }).get(),
                client_name = $("#client_name").val(),
                client_phone = $("#phone").val(),
                client_email = $("#email").val(),
                total_price = $("#totalPrice").text(),
                discount_value = $("#discount").text().replace('%', ''),
                discount_id     =  $("#choices-discount").val(),
                RandTicket = $("#RandTicket").text(),
                revenue = $("#revenue").text(),
                amount = parseFloat($('#paid').text()) - parseFloat($('#change').text()),
                discount_type = $(".discType input:checked").map(function () {
                    return $(this).val();
                }).get(),
                rem = parseFloat($("#revenue").text()) - amount;
            var oldPayRev = $('#oldPayRev').val();

            if(discount_value != 0 && discount_id.length == 0){
                toastr.error("Choose The Discount Reasons");
            }
            else {


                var data = {
                    'client_name': client_name,
                    'phone': client_phone,
                    'email': client_email,
                    'shift_start': "{{$rev->models[0]->shift_start}}",
                    'shift_end': "{{$rev->models[0]->shift_end}}",
                    'note': $('#note').val(),
                    "visitor_type": visitor_type,
                    "visitor_price": visitor_price,
                    "visitor_birthday": visitor_birthday,
                    "visitor_name": visitor_name,
                    "gender": gender,
                    "product_id": product_id,
                    "product_qty": product_qty,
                    "product_price": product_price,
                    "ticket_price":ticket_price,
                    "ent_tax":ent_tax,
                    "vat":vat,
                    "total_price": total_price,
                    "discount_type": discount_type,
                    "discount_value": discount_value,
                    "discount_id": discount_id,
                    "rand_ticket": RandTicket,
                    "amount": amount,
                    "revenue": revenue,
                    "rev_id": "{{$rev->id}}",
                    "rem": (Math.round(rem * 100) / 100).toFixed(2),
                    "payment_method" : $('input[name="payment"]:checked').val(),
                    "oldPayRev" : oldPayRev,
                }
                $.ajax({
                    type: "POST",
                    data: data,
                    url: '{{route('postUpdateReservation')}}',
                    beforeSend: function () {
                        $('#confirmBtn').html('<span class="spinner-border spinner-border-sm mr-2" ' +
                            ' ></span> <span style="margin-left: 4px;">working</span>').attr('disabled', true);
                    },
                    success: function (data) {
                        toastr.success("Reservation updated successfully");
                        $('#confirmBtn').hide();
                        $('#lastPrev').hide();
                        $('#printDiv').show();
                        $('#printBtn').attr("href", data.printUrl)
                        $('#accessBtn').attr("href", data.accessUrl)
                        window.scrollTo({top: 1000, behavior: 'smooth'});
                    },
                });
            }

            // Prevent form submission
        });
    </script>

@endsection


