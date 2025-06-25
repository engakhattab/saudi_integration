@extends('site.layouts.master')

@section('content')
  <style>
    .myBarcode{
      position: relative;
      padding: 0 0 0;
      transform: scale(.8);
      transform-origin: left top;
    }
    .visitorType{
      display: inline-block;
      text-align: center;
      padding: 10px 20px;
      border-radius: 10px;
      margin: 2px;
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
      cursor: pointer;
      -webkit-transition: all 0.3s ease-in-out;
      transition: all 0.3s ease-in-out;
      border: 1px solid #eee;
      position: relative;
    }
    .visitorType img {
      width: 50px;
      height: 50px;
      margin: 5px;
    }
  </style>
  <!--(((((((((((((((((((((((()))))))))))))))))))))))-->
  <!--((((((((((((((((((( content )))))))))))))))))))-->
  <!--(((((((((((((((((((((((()))))))))))))))))))))))-->
  <content>

    <!-- Main Banner  -->
    <section class="mainBanner">
      <button onclick="goBack()" class="Back">
        <i class="fas fa-angle-left"></i>
      </button>
      <ul>
        <li>
          <a href="index.html"> index </a>
        </li>
        <li>
          <a href="#!" class="active"> Book Stay </a>
        </li>
      </ul>
    </section>
    <!-- about us page -->
    <section class="book-stay">
      <div class="container">

        <h2 class="MainTitle mb-5 ms-4">Ticket</h2>
        <div class="multisteps-form">
          <form class="row">
            <input type="hidden" value="" name="client_id">
            <div class="col-lg-9 p-1 ">
              <div class="multisteps-form__progress mb-5">
                <button type="button" class="multisteps-form__progress-btn js-active" title="Ticket"> Ticket
                </button>
                <button type="button" class="multisteps-form__progress-btn" title="visitors"> visitors</button>
                <button type="button" class="multisteps-form__progress-btn" title="Products"> Products</button>
                <button type="button" class="multisteps-form__progress-btn" title="payment"> payment</button>
              </div>
              <div class="multisteps-form__form mb-2" >
                <!-- step 1 -->
                {{--                    <div class="card multisteps-form__panel p-3 border-radius-xl bg-white js-active" id="TicketTab"--}}
                {{--                         data-animation="FadeIn">--}}
                {{--                        <h5 class="font-weight-bolder">Ticket</h5>--}}
                {{--                        <div class="multisteps-form__content">--}}
                {{--                            <div class="row mt-3">--}}
                {{--                                <div class="col-sm-6 p-2">--}}
                {{--                                    <label>Visit Date</label>--}}
                {{--                                    <input class="form-control" type="date" id="date" value="{{ date('Y-m-d') }}" name="visit_date"/>--}}
                {{--                                </div>--}}
                {{--                                <div class="col-sm-6 p-2">--}}
                {{--                                    <label style="text-transform: initial !important;">Reservation Duration (h) </label>--}}
                {{--                                    <input class="form-control" type="number" name="duration" id="duration" min="1" max="24"--}}
                {{--                                           onKeyUp="if(this.value>24){this.value='24';}else if(this.value<=0){this.value='1';}"/>--}}
                {{--                                    <label id="durationError" class="text-danger"></label>--}}
                {{--                                </div>--}}
                {{--                                <div class="col-12 p-2">--}}
                {{--                                    <label class="form-label"> shift </label>--}}
                {{--                                    <select class="form-control" id="choices-shift" name="shift_id">--}}
                {{--                                        @foreach($shifts as $shift)--}}
                {{--                                            <option value="{{$shift->id}}">{{date('h a', strtotime($shift->from))}}--}}
                {{--                                                : {{date('h a', strtotime($shift->to))}}</option>--}}
                {{--                                        @endforeach--}}
                {{--                                    </select>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}
                {{--                            <div class="button-row d-flex mt-4">--}}
                {{--                                <button class="btn bg-gradient-dark ms-auto mb-0 js-btn-next" type="button"--}}
                {{--                                        id="firstNext">Next--}}
                {{--                                </button>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                <div class="card multisteps-form__panel p-3 border-radius-xl bg-white js-active" id="ticketTab"
                     data-animation="FadeIn">
                  <div style="justify-content: space-between">
                    <div>
                      <h5 class="font-weight-bolder">Ticket</h5>
                    </div>
                  </div>


                  <div class="multisteps-form__content">
                    <div class="row mt-3">
                      <div class="col-sm-6 p-2">
                        <label>Phone</label>
                        <input class="form-control" type="number" id="phone"  name="phone" />
                        <label id="dayError" class="text-danger"></label>
                      </div>
                      <div class="col-sm-6 p-2">
                        <label>Visit Date</label>
                        <input class="form-control" type="date" id="date" value="{{ date('Y-m-d') }}" name="visit_date" onchange="checkDay(event)"/>
                        <label id="dayError" class="text-danger"></label>
                      </div>
                      <div class="col-sm-6 p-2">
                        <label class="form-label" style="text-transform: initial !important;">Reservation Duration (h) </label>
                        <input class="form-control" type="text" name="duration" onchange="checkTime()" id="duration" min="1" max="24"
                               onKeyUp="if(this.value>5){this.value='5';}else if(this.value<=0){this.value='1';}$('#durationError').text('')"/>
                        <label id="durationError" class="text-danger"></label>
                      </div>
                      <input type="hidden" id="first_shift_start" value="{{$first_shift_start}}">
                      <input type="hidden" id="start" value="">
                      <div class="col-sm-6 p-2">
                        <label class="form-label"> shift </label>
                        <select class="form-control" id="choices_times" name="choices_times">

                        </select>
                      </div>
                    </div>
                    <div class="button-row d-flex mt-4 ">
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
                      <div class="col-12 p-2">
                        @foreach($types as $type)
                          <div class="visitorType visitorType{{$type->id}}">
                            <div class="visitorTypeDiv">
                              <img src="{{get_file($type->photo)}}" alt="">
                              <span class="visitor"> {{$type->title}} </span>
                              <span class="count">0</span>
                              <input type="hidden" value="" name="price[]" id="price{{$type->id}}">
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
                <div class="card multisteps-form__panel p-3 border-radius-xl bg-white " id="productsTab" data-animation="FadeIn">
                  <h5 class="font-weight-bolder">Products</h5>
                  <div class="multisteps-form__content">
                    <div class="row mt-3 align-items-end">
                      <div class="col-md-5 p-2">
                        <label class="form-label"> Category </label>
                        <select class="form-control" id="choices-category">
                          <option value="" disabled selected>Choose The Category</option>
                          {!! optionForEach($categories,'id','title') !!}
                        </select>
                      </div>
                      <div class="col-md-5 p-2">
                        <label class="form-label"> Product </label>
                        <select class="form-control" id="choices-product">
                          <option value="" disabled selected>Choose The Product</option>
                        </select>
                      </div>
                      <div class="col-md-2 p-2">
                        <button type="button" class="btn btn-success w-100 " style="background-color:#198754;border-color:#198754" id="addBtn"> ADD </button>
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
                  <h5 class="font-weight-bolder">payment</h5>
                  <div class="multisteps-form__content">
                    <div class="row   mt-3">
                      <div class="col-12 p-2">
                        <div class="screens row">
                          <div class="screen col">
                            <span>total</span>
                            <strong id="totalPrice">  </strong>
                          </div>
                          <div class="screen col">
                            <span>Amount to Pay</span>
                            <strong id="revenue">  </strong>
                          </div>
                          <div class="screen col">
                            <span>paid</span>
                            <strong id="paid"> 0 </strong>
                          </div>
                          <div class="screen col">
                            <span>change</span>
                            <strong id="change"> 0 </strong>
                          </div>
                        </div>
                      </div>

                      <div class="col-12 p-2">
                        <label class="form-label ">payment method</label>
                        <div class="choose">

                          <div class="genderOption payment m-1">
                            <input type="radio" class="btn-check" name="payment" value="visa" checked
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
                        </div>
                        <div class="row align-items-end">
                          <div class="col-8 col-md-9 p-2 ">
                            <label> Amount </label>
                            <input class="form-control" type="number" id="amount" readonly
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
                      <button class="btn bg-gradient-dark ms-auto mb-0" id="confirmBtn"> Confirm </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class=" col-lg-3 p-1 ">
              <div class=" bill" id="bill">
                <h4 class="font-weight-bolder ps-2">Bill</h4>
                <div class="info">
                  <h6 class="billTitle"> Ticket <span id="RandTicket">{{$random}}</span></h6>
                  <ul>
                    {{--                    <li><label> Cashier Name : </label> <strong>{{auth()->user()->name}}</strong></li>--}}
                    <li><label> Visit Date : </label> <strong id="dateOfTicket"> </strong></li>
                    <li><label> Reservation Duration : </label> <strong id="hourOfTicket" style="text-transform: initial !important;"></strong></li>
                    <li><label> Shift : </label> <strong id="shiftOfTicket"> </strong></li>
                  </ul>
                </div>
                <div class="info firstInfo">

                </div>
                <div class="info secondInfo">

                </div>
                <div class="info thirdInfo">

                </div>
                @php
                  $generator = new Picqer\Barcode\BarcodeGeneratorHTML();
                @endphp
                <div class="myBarcode">
                  {!! $generator->getBarcode($random, $generator::TYPE_CODE_128) !!}
                </div>
                <div id="printDiv" style="display: none">
                  <div class="printBtn">
                    {{--                    <a class="btn btn-outline-info fw-normal " id="accessBtn"><i--}}
                    {{--                              class="fas fa-sign-out me-2"></i>--}}
                    {{--                      Access--}}
                    {{--                    </a>--}}
                    <a class="btn btn-info " target="_blank"  id="printBtn"><i class="fal fa-print me-2"></i> Print</a>
                  </div>
                </div>
              </div>
            </div>
            @csrf
          </form>
        </div>

      </div>
    </section>

  </content>
  <!--(((((((((((((((((((((((()))))))))))))))))))))))-->
  <!--((((((((((((((((( / content )))))))))))))))))))-->
  <!--(((((((((((((((((((((((()))))))))))))))))))))))-->

@endsection

@section('site-js')
  <script type="text/javascript" src="{{asset('assets/sales')}}/js/plugins/multistep-form.js"></script>

  <!-- data table -->
  <script src="{{asset('assets/site')}}/js/datatables.min.js"></script>

  {{--  <script src="js/fancybox.js"></script>--}}
  {{--  <script src="js/atropos.min.js"></script>--}}
  {{--  <script src="js/fancybox.umd.js"></script>--}}
  {{--  <script src="js/WOW.js"></script>--}}
  {{--  <script src="js/multistep-form.js"></script>--}}


  @include('site.layouts.assets.adjustDataTable')
  <script>
    $('form').on('submit', function(e) {
      e.preventDefault();
      var duration        = $('#duration').val(),
              phone      = $('#phone').val(),
              visit_date      = $('#date').val(),
              shift_id        = $('#choices_times').val(),
              shift_start     = $('#choices_times').find(':selected').attr('data-starts'),
              shift_end       = $('#choices_times').find(':selected').attr('data-ends'),
              visitor_type    = $("span[id='visitor_type[]']").map(function(){return $(this).attr('data-type_id');}).get(),
              visitor_price   = $("span[id='visitor_price[]']").map(function(){return $(this).attr('data-price');}).get(),
              visitor_birthday= $("input[id='visitor_birthday[]']").map(function(){return $(this).val();}).get(),
              visitor_name    = $("input[name='visitor_name[]']").map(function(){return $(this).val();}).get(),
              gender          = $(".choose input:checked").map(function(){return $(this).val();}).get(),
              product_id      =  $("input[name='product_id[]']").map(function(){return $(this).val();}).get(),
              product_qty     =  $("input[name='proQtyInput[]']").map(function(){return $(this).val();}).get(),
              product_price   =  $("input[name='proTotalInput[]']").map(function(){return $(this).val();}).get(),
              ticket_price    =  $("#beforeTax").text(),
              ent_tax         =  $("#ent").text(),
              vat             =  $("#vat").text(),
              total_price     =  $("#totalPrice").text(),
              RandTicket      =  $("#RandTicket").text(),
              revenue         =  $("#revenue").text(),
              amount          =  parseFloat($('#paid').text())-parseFloat($('#change').text()),
              rem             = parseFloat($("#revenue").text())-amount,
              payment_method  = $('input[name="payment"]:checked').val();


      var data = {
        "phone":phone,
        "duration":duration,
        "visit_date":visit_date,
        "shift_id":shift_id,
        "shift_start":shift_start,
        "shift_end":shift_end,
        "visitor_type":visitor_type,
        "visitor_price":visitor_price,
        "visitor_birthday":visitor_birthday,
        "visitor_name":visitor_name,
        "gender":gender,
        "product_id":product_id,
        "product_qty":product_qty,
        "product_price":product_price,
        "ticket_price":ticket_price,
        "ent_tax":ent_tax,
        "vat":vat,
        "total_price":total_price,
        "rand_ticket":RandTicket,
        "amount":amount,
        "revenue":revenue,
        "rem":(Math.round(rem * 100) / 100).toFixed(2),
        "payment_method":payment_method,
      }

      $.ajax({
        type: "POST",
        data: data,
        url: '{{route('storeTicket')}}',
        beforeSend: function(){
          $('#confirmBtn').html('<span class="spinner-border spinner-border-sm mr-2" ' +
                  ' ></span> <span style="margin-left: 4px;">working</span>').attr('disabled', true);
        },
        success: function(data){
          if(data.status == true){
            toastr.success("Ticket is saved successfully");
            $('#confirmBtn').hide();
            $('#lastPrev').hide();
            $('#printDiv').show();
            $('#printBtn').attr("href", data.printUrl)
            // $('#accessBtn').attr("href", data.accessUrl)
            window.scrollTo({top: 800, behavior: 'smooth'});
            {{--window.setTimeout(function() {--}}
            {{--    window.location.href="{{route('client.create')}}";--}}
            {{--}, 300);--}}
          }
          else{
            toastr.error("The Client Has A Ticket In This Day");
          }
        },
      });


      // Prevent form submission
    });
    $(document).on('click','#thirdNext',function () {
      $('#amount').val(parseFloat($('#revenue').text()))
      calculateChange()
    })

  </script>
@endsection
