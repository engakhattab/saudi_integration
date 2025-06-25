@extends('sales.layouts.master')
@section('links')
    Update Ticket
@endsection
@section('page_title')
    {{$setting->title}} | Update Ticket
@endsection
@section('content')
    <h2 class="MainTitle mb-5 ms-4">ticket</h2>
    <div class="multisteps-form">
        <form class="row">
            <div class="col-lg-9 p-1 ">
                <div class="multisteps-form__progress mb-5">
                    <button type="button" class="multisteps-form__progress-btn js-active" title="visitors"> visitors
                    </button>
                    <button type="button" class="multisteps-form__progress-btn" title="products"> products</button>
                    <button type="button" class="multisteps-form__progress-btn" title="payment"> payment</button>
                </div>
                <div class="multisteps-form__form mb-2">
                    <!-- step 2 -->
                    <div class="card multisteps-form__panel p-3 border-radius-xl bg-white js-active" id="visitorsTab"
                         data-animation="FadeIn">
                        <div style="justify-content: space-between">
                            <div>
                                <h5 class="font-weight-bolder">visitors</h5>
                            </div>
                            <div>
                                @if($rate != 0 && $rate != null)
                                    <ul class="rating">
                                        @for($i = 1 ;$i <= 5;$i++)
                                            <li><i class='fas fa-star {{($rate >= $i) ? 'gold' : ''}}'></i></li>
                                        @endfor
                                    </ul>
                                    <label class="form-label"> Client Rate </label>
                                @endif
                            </div>
                        </div>
                        <div class="multisteps-form__content">
                            <div class="row mt-3">
                                <!-- visitor Type  -->
                                <div class="col-12 p-2">
                                    @foreach($types as $type)
                                        <div class="visitorType visitorType{{$type->id}}">
                                            <div class="visitorTypeDiv">
                                                <img src="{{get_file($type->photo)}}" alt="{{$type->title}}"
                                                     title="{{$type->title}}">
                                                <span class="visitor">{{$type->title}}</span>
                                                <span
                                                    class="count">{{$models->where('ticket_id',$ticket->id)->where('visitor_type_id',$type->id)->count()}}</span>
                                                <input type="hidden"
                                                       value="{{$prices->where('visitor_type_id',$type->id)->first()->price??0}}"
                                                       name="price[]" id="price{{$type->id}}">
                                                <input type="hidden" value="{{$type->id}}"
                                                       id="visitor_type_id">
                                            </div>
                                        </div>
                                    @endforeach

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
                                            @if($model->status =="append")
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
                                                        @if($model->status == 'in')
                                                            <i class="fa fa-eye"></i>
                                                        @else
                                                            <span class="controlIcons">
                                                    <span class="icon Delete"
                                                          data-model_id="{{$model->type->id}}"> <i
                                                            class="far fa-trash-alt"></i> </span>
                                                    </span>
                                                        @endif


                                                    </td>
                                                </tr>

                                            @else

                                                <tr class="{{$model->type->title}}">
                                                    <td><span
                                                        >{{$model->type->title}}</span></td>
                                                    <td><span data-price="{{$model->price}}">{{$model->price}}</span></td>
                                                    <td><input type="text" class="form-control" placeholder="Name" value="{{$model->name}}"></td>
                                                    <td><input type="date" class="form-control" value="{{$model->birthday}}"></td>
                                                    <td>
                                                        <div class="choose">
                                                            <div class="genderOption">
                                                                <input type="radio" class="btn-check gender"

                                                                       value="male"
                                                                    {{($model->gender == 'male') ? 'checked' : ''}}>
                                                                <label class=" mb-0 btn btn-outline"
                                                                       for="option1{{$model->id}}">
                                                                    <span> <i class="fas fa-male"></i> </span>
                                                                </label>
                                                            </div>
                                                            <div class="genderOption">
                                                                <input type="radio" class="btn-check gender"
                                                                       value="female"
                                                                    {{($model->gender == 'female') ? 'checked' : ''}}>
                                                                <label class=" mb-0 btn btn-outline"
                                                                       for="option2{{$model->id}}">
                                                                    <span> <i class="fas fa-female"></i> </span>
                                                                    <!-- <span> female </span> -->
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if($model->status == 'in')
                                                            <i class="fa fa-eye"></i>
                                                        @else
                                                            <span class="controlIcons">
                                                                                <span class="icon Delete"
                                                                                      data-model_id="{{$model->type->id}}"> <i
                                                                                        class="far fa-trash-alt"></i> </span>
                                                                                </span>
                                                        @endif


                                                    </td>
                                                </tr>

                                            @endif
                                        @endforeach



                                        {{--                                        @foreach($models as $model)--}}
                                        {{--                                            <tr class="{{$model->type->title}}">--}}
                                        {{--                                                <td><span--}}
                                        {{--                                                         >{{$model->type->title}}</span></td>--}}
                                        {{--                                                <td><span data-price="{{$model->price}}">{{$model->price}}</span></td>--}}
                                        {{--                                                <td><input type="text" class="form-control" placeholder="Name" value="{{$model->name}}"></td>--}}
                                        {{--                                                <td><input type="date" class="form-control" value="{{$model->birthday}}"></td>--}}
                                        {{--                                                <td>--}}
                                        {{--                                                    <div class="choose">--}}
                                        {{--                                                        <div class="genderOption">--}}
                                        {{--                                                            <input type="radio" class="btn-check gender"--}}

                                        {{--                                                                   value="male"--}}
                                        {{--                                                                    {{($model->gender == 'male') ? 'checked' : ''}}>--}}
                                        {{--                                                            <label class=" mb-0 btn btn-outline"--}}
                                        {{--                                                                   for="option1{{$model->id}}">--}}
                                        {{--                                                                <span> <i class="fas fa-male"></i> </span>--}}
                                        {{--                                                            </label>--}}
                                        {{--                                                        </div>--}}
                                        {{--                                                        <div class="genderOption">--}}
                                        {{--                                                            <input type="radio" class="btn-check gender"--}}
                                        {{--                                                                   value="female"--}}
                                        {{--                                                                   {{($model->gender == 'female') ? 'checked' : ''}}>--}}
                                        {{--                                                            <label class=" mb-0 btn btn-outline"--}}
                                        {{--                                                                   for="option2{{$model->id}}">--}}
                                        {{--                                                                <span> <i class="fas fa-female"></i> </span>--}}
                                        {{--                                                                <!-- <span> female </span> -->--}}
                                        {{--                                                            </label>--}}
                                        {{--                                                        </div>--}}
                                        {{--                                                    </div>--}}
                                        {{--                                                </td>--}}
                                        {{--                                                <td>--}}
                                        {{--                                                    @if($model->status == 'in')--}}
                                        {{--                                                        <i class="fa fa-eye"></i>--}}
                                        {{--                                                    @else--}}
                                        {{--                                                        <span class="controlIcons">--}}
                                        {{--                                                                        <span class="icon Delete"--}}
                                        {{--                                                                              data-model_id="{{$model->type->id}}"> <i--}}
                                        {{--                                                                                class="far fa-trash-alt"></i> </span>--}}
                                        {{--                                                                        </span>--}}
                                        {{--                                                    @endif--}}


                                        {{--                                                </td>--}}
                                        {{--                                            </tr>--}}
                                        {{--                                        @endforeach--}}

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="button-row d-flex mt-4">
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
                                                        <input type="number" disabled
                                                               id="qtyVal{{$product->product_id}}"
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
                                            <strong id="oldTotal">{{$ticket->total_price}}</strong>
                                        </div>
                                        <div class="screen col">
                                            <span>discount</span>
                                            <strong
                                                id="oldDiscount"> {{$ticket->discount_value}} {{($ticket->discount_type == 'per') ? '%' : ''}} </strong>
                                        </div>
                                        <div class="screen col">
                                            <span>Amount to Pay</span>
                                            <strong id="oldRevenue"> {{$ticket->grand_total}}</strong>
                                            <input id="old_total" type="hidden" value="{{$ticket->grand_total}}">
                                        </div>
                                        <div class="screen col">
                                            <span>paid</span>
                                            <strong id="oldPaid"> {{$ticket->paid_amount}}</strong>
                                            <input type="hidden" value="{{$ticket->paid_amount}}" id="oldPayRev">
                                        </div>
                                        <div class="screen col">
                                            <span>dues</span>
                                            <strong id="oldDues"> {{$ticket->rem_amount}}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if($ticket->discount_value != 0)
                                <label class="form-label"><i class="fa fa-tag pt-2"></i> Discount Reason </label>
                                <span>{{($ticket->reason->desc) ?? ''}}</span>
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
                                            <strong id="revenue"> </strong>
                                        </div>
                                        <div class="screen col">
                                            <span>paid</span>
                                            <strong id="paid"> {{$ticket->paid_amount}} </strong>
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
                                                <option value="" disabled selected>-- Select The Reason Of The Discount
                                                    --
                                                </option>
                                                {!! optionForEach($discounts,'id','desc') !!}
                                            </select>
                                        </div>

                                    </div>
                                </div>


                                <div class="col-12 p-2">

                                    {{--                                    <label class="form-label ">payment method</label>--}}
                                    <div class="paymentMethods">
                                        {{--                                        <button class="btn" type="button" data-bs-toggle="collapse"--}}
                                        {{--                                                data-bs-target="#payCash"--}}
                                        {{--                                                aria-expanded="false" aria-controls="payCash">--}}
                                        {{--                                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1"--}}
                                        {{--                                                 xmlns:xlink="http://www.w3.org/1999/xlink"--}}
                                        {{--                                                 xmlns:svgjs="http://svgjs.com/svgjs" width="512"--}}
                                        {{--                                                 height="512" x="0" y="0" viewBox="0 0 512 512"--}}
                                        {{--                                                 style="enable-background:new 0 0 512 512"--}}
                                        {{--                                                 xml:space="preserve">--}}
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
                                        {{--                                            <span> cash </span></button>--}}
                                        {{--                                        <button class="btn" type="button" data-bs-toggle="collapse"--}}
                                        {{--                                                data-bs-target="#payCash" aria-expanded="false">--}}
                                        {{--                                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1"--}}
                                        {{--                                                 xmlns:xlink="http://www.w3.org/1999/xlink"--}}
                                        {{--                                                 xmlns:svgjs="http://svgjs.com/svgjs" width="512"--}}
                                        {{--                                                 height="512" x="0" y="0" viewBox="0 0 473.96 473.96"--}}
                                        {{--                                                 style="enable-background:new 0 0 512 512" xml:space="preserve">--}}
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
                                        {{--                                            <span> visa </span></button>--}}
                                        {{--                                        <button class="btn" type="button" data-bs-toggle="collapse"--}}
                                        {{--                                                data-bs-target="#payCash" aria-expanded="false">--}}
                                        {{--                                            <svg viewBox="0 0 256 199" version="1.1" xmlns="http://www.w3.org/2000/svg"--}}
                                        {{--                                                 xmlns:xlink="http://www.w3.org/1999/xlink"--}}
                                        {{--                                                 preserveAspectRatio="xMidYMid">--}}
                                        {{--                                                <g>--}}
                                        {{--                                                    <path--}}
                                        {{--                                                        d="M46.5392504,198.011312 L46.5392504,184.839826 C46.5392504,179.790757 43.4659038,176.497885 38.1973096,176.497885 C35.5630125,176.497885 32.7091906,177.375984 30.7334678,180.229806 C29.1967945,177.815034 27.0015469,176.497885 23.7086756,176.497885 C21.513428,176.497885 19.3181804,177.15646 17.5619824,179.571233 L17.5619824,176.936935 L12.9519625,176.936935 L12.9519625,198.011312 L17.5619824,198.011312 L17.5619824,186.3765 C17.5619824,182.644579 19.5377052,180.888381 22.6110518,180.888381 C25.6843984,180.888381 27.2210717,182.864103 27.2210717,186.3765 L27.2210717,198.011312 L31.8310916,198.011312 L31.8310916,186.3765 C31.8310916,182.644579 34.0263392,180.888381 36.880161,180.888381 C39.9535076,180.888381 41.490181,182.864103 41.490181,186.3765 L41.490181,198.011312 L46.5392504,198.011312 L46.5392504,198.011312 Z M114.81145,176.936935 L107.347608,176.936935 L107.347608,170.570717 L102.737589,170.570717 L102.737589,176.936935 L98.566618,176.936935 L98.566618,181.107905 L102.737589,181.107905 L102.737589,190.766995 C102.737589,195.59654 104.713311,198.450362 109.981906,198.450362 C111.957628,198.450362 114.152876,197.791787 115.689549,196.913688 L114.372401,192.962243 C113.055252,193.840341 111.518579,194.059866 110.420955,194.059866 C108.225708,194.059866 107.347608,192.742718 107.347608,190.54747 L107.347608,181.107905 L114.81145,181.107905 L114.81145,176.936935 L114.81145,176.936935 Z M153.886857,176.497885 C151.25256,176.497885 149.496362,177.815034 148.398738,179.571233 L148.398738,176.936935 L143.788718,176.936935 L143.788718,198.011312 L148.398738,198.011312 L148.398738,186.156975 C148.398738,182.644579 149.935411,180.668856 152.789233,180.668856 C153.667332,180.668856 154.764956,180.888381 155.643055,181.107905 L156.960204,176.71741 C156.082105,176.497885 154.764956,176.497885 153.886857,176.497885 L153.886857,176.497885 L153.886857,176.497885 Z M94.834697,178.693133 C92.6394495,177.15646 89.566103,176.497885 86.2732315,176.497885 C81.0046375,176.497885 77.492241,179.132183 77.492241,183.303153 C77.492241,186.81555 80.1265385,188.791272 84.736558,189.449847 L86.931806,189.669371 C89.346578,190.10842 90.6637265,190.766995 90.6637265,191.864619 C90.6637265,193.401292 88.9075285,194.498916 85.834182,194.498916 C82.7608355,194.498916 80.346063,193.401292 78.8093895,192.303668 L76.614142,195.816065 C79.0289145,197.572262 82.321786,198.450362 85.614657,198.450362 C91.7613505,198.450362 95.2737465,195.59654 95.2737465,191.645094 C95.2737465,187.913173 92.4199245,185.937451 88.0294295,185.278876 L85.834182,185.059351 C83.858459,184.839826 82.321786,184.400777 82.321786,183.083629 C82.321786,181.546955 83.858459,180.668856 86.2732315,180.668856 C88.9075285,180.668856 91.5418255,181.76648 92.858974,182.425054 L94.834697,178.693133 L94.834697,178.693133 Z M217.329512,176.497885 C214.695215,176.497885 212.939017,177.815034 211.841393,179.571233 L211.841393,176.936935 L207.231373,176.936935 L207.231373,198.011312 L211.841393,198.011312 L211.841393,186.156975 C211.841393,182.644579 213.378066,180.668856 216.231888,180.668856 C217.109987,180.668856 218.207611,180.888381 219.08571,181.107905 L220.402859,176.71741 C219.52476,176.497885 218.207611,176.497885 217.329512,176.497885 L217.329512,176.497885 L217.329512,176.497885 Z M158.496877,187.474123 C158.496877,193.840341 162.887372,198.450362 169.69264,198.450362 C172.765986,198.450362 174.961234,197.791787 177.156481,196.035589 L174.961234,192.303668 C173.205036,193.620817 171.448838,194.279391 169.473115,194.279391 C165.741194,194.279391 163.106897,191.645094 163.106897,187.474123 C163.106897,183.522678 165.741194,180.888381 169.473115,180.668856 C171.448838,180.668856 173.205036,181.32743 174.961234,182.644579 L177.156481,178.912658 C174.961234,177.15646 172.765986,176.497885 169.69264,176.497885 C162.887372,176.497885 158.496877,181.107905 158.496877,187.474123 L158.496877,187.474123 L158.496877,187.474123 Z M201.08468,187.474123 L201.08468,176.936935 L196.47466,176.936935 L196.47466,179.571233 C194.937987,177.595509 192.742739,176.497885 189.888917,176.497885 C183.961749,176.497885 179.351729,181.107905 179.351729,187.474123 C179.351729,193.840341 183.961749,198.450362 189.888917,198.450362 C192.962264,198.450362 195.157512,197.352737 196.47466,195.377015 L196.47466,198.011312 L201.08468,198.011312 L201.08468,187.474123 Z M184.181274,187.474123 C184.181274,183.742202 186.596046,180.668856 190.547492,180.668856 C194.279413,180.668856 196.91371,183.522678 196.91371,187.474123 C196.91371,191.206044 194.279413,194.279391 190.547492,194.279391 C186.596046,194.059866 184.181274,191.206044 184.181274,187.474123 L184.181274,187.474123 Z M129.080559,176.497885 C122.933866,176.497885 118.543371,180.888381 118.543371,187.474123 C118.543371,194.059866 122.933866,198.450362 129.300084,198.450362 C132.373431,198.450362 135.446777,197.572262 137.861549,195.59654 L135.666302,192.303668 C133.910104,193.620817 131.714856,194.498916 129.519609,194.498916 C126.665787,194.498916 123.811965,193.181768 123.153391,189.449847 L138.739648,189.449847 L138.739648,187.693648 C138.959173,180.888381 135.007727,176.497885 129.080559,176.497885 L129.080559,176.497885 L129.080559,176.497885 Z M129.080559,180.449331 C131.934381,180.449331 133.910104,182.20553 134.349153,185.498401 L123.372916,185.498401 C123.811965,182.644579 125.787688,180.449331 129.080559,180.449331 L129.080559,180.449331 Z M243.452958,187.474123 L243.452958,168.594995 L238.842938,168.594995 L238.842938,179.571233 C237.306265,177.595509 235.111017,176.497885 232.257196,176.497885 C226.330027,176.497885 221.720007,181.107905 221.720007,187.474123 C221.720007,193.840341 226.330027,198.450362 232.257196,198.450362 C235.330542,198.450362 237.52579,197.352737 238.842938,195.377015 L238.842938,198.011312 L243.452958,198.011312 L243.452958,187.474123 Z M226.549552,187.474123 C226.549552,183.742202 228.964324,180.668856 232.91577,180.668856 C236.647691,180.668856 239.281988,183.522678 239.281988,187.474123 C239.281988,191.206044 236.647691,194.279391 232.91577,194.279391 C228.964324,194.059866 226.549552,191.206044 226.549552,187.474123 L226.549552,187.474123 Z M72.443172,187.474123 L72.443172,176.936935 L67.833152,176.936935 L67.833152,179.571233 C66.2964785,177.595509 64.101231,176.497885 61.247409,176.497885 C55.3202405,176.497885 50.7102205,181.107905 50.7102205,187.474123 C50.7102205,193.840341 55.3202405,198.450362 61.247409,198.450362 C64.3207555,198.450362 66.5160035,197.352737 67.833152,195.377015 L67.833152,198.011312 L72.443172,198.011312 L72.443172,187.474123 Z M55.3202405,187.474123 C55.3202405,183.742202 57.735013,180.668856 61.6864585,180.668856 C65.4183795,180.668856 68.0526765,183.522678 68.0526765,187.474123 C68.0526765,191.206044 65.4183795,194.279391 61.6864585,194.279391 C57.735013,194.059866 55.3202405,191.206044 55.3202405,187.474123 Z"--}}
                                        {{--                                                        fill="#000000"></path>--}}
                                        {{--                                                    <rect fill="#FF5F00" x="93.2980455" y="16.9034088"--}}
                                        {{--                                                          width="69.1502985" height="124.251009">--}}
                                        {{--                                                    </rect>--}}
                                        {{--                                                    <path--}}
                                        {{--                                                        d="M97.688519,79.0288935 C97.688519,53.783546 109.542856,31.3920209 127.763411,16.9033869 C114.3724,6.3661985 97.468994,-1.94737475e-05 79.0289145,-1.94737475e-05 C35.3434877,-1.94737475e-05 1.7258174e-06,35.3434665 1.7258174e-06,79.0288935 C1.7258174e-06,122.71432 35.3434877,158.057806 79.0289145,158.057806 C97.468994,158.057806 114.3724,151.691588 127.763411,141.1544 C109.542856,126.88529 97.688519,104.274241 97.688519,79.0288935 Z"--}}
                                        {{--                                                        fill="#EB001B"></path>--}}
                                        {{--                                                    <path--}}
                                        {{--                                                        d="M255.746345,79.0288935 C255.746345,122.71432 220.402859,158.057806 176.717432,158.057806 C158.277352,158.057806 141.373945,151.691588 127.982936,141.1544 C146.423015,126.665766 158.057827,104.274241 158.057827,79.0288935 C158.057827,53.783546 146.20349,31.3920209 127.982936,16.9033869 C141.373945,6.3661985 158.277352,-1.94737475e-05 176.717432,-1.94737475e-05 C220.402859,-1.94737475e-05 255.746345,35.5629913 255.746345,79.0288935 Z"--}}
                                        {{--                                                        fill="#F79E1B"></path>--}}
                                        {{--                                                </g>--}}
                                        {{--                                            </svg>--}}
                                        {{--                                            <span> mastercard </span></button>--}}
                                        {{--                                        <button class="btn" type="button" data-bs-toggle="collapse"--}}
                                        {{--                                                data-bs-target="#payCash" aria-expanded="false">--}}
                                        {{--                                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1"--}}
                                        {{--                                                 xmlns:xlink="http://www.w3.org/1999/xlink"--}}
                                        {{--                                                 xmlns:svgjs="http://svgjs.com/svgjs" width="512"--}}
                                        {{--                                                 height="512" x="0" y="0" viewBox="0 0 473.96 473.96"--}}
                                        {{--                                                 style="enable-background:new 0 0 512 512" xml:space="preserve">--}}
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
                                        {{--                                            <span> Meeza </span></button>--}}

                                        <!-- payCash -->
                                        <div class="collapse show pt-3 " id="payCash">
                                            <div class="row align-items-end">
                                                <div class="col-8 col-md-9 p-2 ">
                                                    <label> Amount </label>
                                                    <input class="form-control" type="number" id="amount" step="any" onchange="calculateChange()" onkeyup="calculateChange()" value="{{$ticket->paid_amount}}"/>
                                                    <div class="pay mt-5">
                                                        {{--start choose pay when remanning amount--}}
                                                        <h6>اختر عمليه دفع المبلغ المضاف للفاتوره</h6>

                                                        <input type="radio" id="cash" name="pay" value="cash" checked>
                                                        <label for="cash">cash</label><br>

                                                        <input type="radio" id="visa" name="pay" value="visa">
                                                        <label for="visa">visa</label><br>

                                                        <input type="radio" id="mastercard" name="pay" value="mastercard">
                                                        <label for="mastercard">mastercard</label><br>

                                                        <input type="radio" id="Meeza" name="pay" value="Meeza">
                                                        <label for="Meeza">Meeza</label><br>

                                                        <input type="radio" id="voucher" name="pay" value="voucher">
                                                        <label for="voucher">voucher</label><br>


                                                        {{--end choose pay when remanning amount--}}
                                                    </div>
                                                </div>
                                                {{--                                                <div class="col-4 col-md-3 p-2">--}}
                                                {{--                                                    <button type="button" class="btn w-100 btn-success"> Pay</button>--}}
                                                {{--                                                </div>--}}
                                            </div>
                                        </div>
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
                        <h6 class="billTitle"> ticket <span id="RandTicket">{{$ticket->ticket_num}}</span></h6>
                        <ul>
                            <li><label> Shop Name : </label> <strong>Kids station company</strong></li>
                            <li><label> شركه محطه الاطفال : </label> <strong>اسم المحل</strong></li>
                            <li><label> الرقم الضريبي : </label> <strong>7030324813</strong></li>
                            <li><label> 7030324813 : </label> <strong>Vat Reg No</strong></li>
                            <li><label> Cashier Name : </label> <strong>{{$add_by}}</strong></li>
                            <li><label> Visit Date : </label> <strong id="dateOfTicket">{{$ticket->visit_date}}</strong>
                            </li>
                            <li><label> Reservation Duration : </label> <strong id="hourOfTicket"
                                                                                style="text-transform: initial !important;">{{$ticket->hours_count}}
                                    h</strong></li>
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
                            @foreach($ticket->models->groupBy('visitor_type_id') as $visitor)
                                <div class="item row insertRows">
                                    <span class="col">{{$visitor[0]->type->title}}</span>
                                    <span class="col"
                                          style="text-transform: initial !important;"> {{$visitor->count()}}</span>
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
                        {!! $generator->getBarcode($ticket->ticket_num, $generator::TYPE_CODE_128) !!}
                    </div>
                    <div id="printDiv" style="display: none">
                        <div class="printBtn">
                            <a class="btn btn-outline-info fw-normal " id="accessBtn"><i
                                    class="fas fa-sign-out me-2"></i>
                                Access
                            </a>
                            <a class="btn btn-info " target="_blank" id="printBtn"><i class="fal fa-print me-2"></i>
                                Print</a>
                        </div>
                    </div>
                </div>
            </div>
            @csrf
        </form>
    </div>
@endsection
@section('js')
    <script type="text/javascript" src="{{asset('assets/sales')}}/js/plugins/multistep-form.js"></script>
    @include('sales.layouts.assets.editDataTable')
    <script>
        $('form').on('submit', function (e) {
            e.preventDefault();
            var visitor_type = $("span[id='visitor_type[]']").map(function () {
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
                product_qty = $("input[name='proQtyInput[]']").map(function () {
                    return $(this).val();
                }).get(),
                product_price = $("input[name='proTotalInput[]']").map(function () {
                    return $(this).val();
                }).get(),
                ticket_price = $("#beforeTax").text(),
                ent_tax = $("#ent").text(),
                vat = $("#vat").text(),
                total_price = $("#totalPrice").text(),
                discount_value = $("#discount").text().replace('%', ''),
                discount_id = $("#choices-discount").val(),
                RandTicket = $("#RandTicket").text(),
                revenue = $("#revenue").text(),
                amount = parseFloat($('#paid').text()) - parseFloat($('#change').text()),
                discount_type = $(".discType input:checked").map(function () {
                    return $(this).val();
                }).get(),
                rem = parseFloat($("#revenue").text()) - amount;
            var oldPayRev = $('#oldPayRev').val();
            if (discount_value != 0 && discount_id.length == 0) {
                toastr.error("Choose The Discount Reasons");

            } else {
                var pay  = $('input[name="pay"]:checked').val();
                var oldRevenue = $("#oldRevenue").val();
                var old_total = $("#old_total").val();
                var data = {
                    "ticket_id": {{$ticket->id}},
                    "visitor_type": visitor_type,
                    "visitor_price": visitor_price,
                    "visitor_birthday": visitor_birthday,
                    "visitor_name": visitor_name,
                    "gender": gender,
                    "product_id": product_id,
                    "product_qty": product_qty,
                    "product_price": product_price,
                    "total_price": total_price,
                    "ticket_price": ticket_price,
                    "ent_tax": ent_tax,
                    "vat": vat,
                    "discount_type": discount_type,
                    "discount_value": discount_value,
                    "discount_id": discount_id,
                    "rand_ticket": RandTicket,
                    "amount": amount,
                    "revenue": revenue,
                    "rem": (Math.round(rem * 100) / 100).toFixed(2),
                    "oldRevenue": oldRevenue,
                    "old_total": old_total,
                    "pay":pay,
                    "oldPayRev" : oldPayRev,

                }
                console.log(data)
                $.ajax({
                    type: "POST",
                    data: data,
                    url: '{{route('restoreTicket')}}',
                    beforeSend: function () {
                        $('#confirmBtn').html('<span class="spinner-border spinner-border-sm mr-2" ' +
                            ' ></span> <span style="margin-left: 4px;">working</span>').attr('disabled', true);
                    },
                    success: function (data) {

                        toastr.success("Ticket is updated successfully");
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
