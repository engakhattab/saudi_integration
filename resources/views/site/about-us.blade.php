@extends('site.layouts.master')
@section('content')
  <content>

    <!-- Main Banner  -->
    <section class="mainBanner">
      <button onclick="goBack()" class="Back">
        <i class="fas fa-angle-left"></i>
      </button>
      <ul>
        <li>
          <a href="index.html"> home </a>
        </li>
        <li>
          <a href="#!" class="active">about us </a>
        </li>
      </ul>
    </section>
    <!-- about us page -->
    <section class="aboutUsPage">
      <div class="container">
        <h1 class="title"> about us </h1>
        <div class="row">
          <div class="col-md-7 p-2 m-auto">
            <p>At {{$setting->title}}, your courage will be put to test. Nothing can satisfy your lust for adventure as a set of
              professional obstacle courses elevated on three levels. and the higher up you go, the more challenging it
              will get. So, take a deep breath and set your sails towards {{$setting->title}} to prove yourself the ultimate champ.
            </p>
            <p>Obstacle courses are established on four levels, Junior, Novice, Intermediate, and Expert. Each path goes
              another level higher than the one before and features some more challenging obstacles. No, we didn’t
              forget about our little ones. Children up to 5 years old have their own special route with obstacles
              tailored to match their age. Once you succeed to complete your mission and reach the finish line, your
              lips won’t refrain from keeping a smile on hold for the next couple of days. </p>
          </div>

        </div>
      </div>
    </section>

    <!-- counter -->
    <div class="counter">
      <div class="container">
        <div class="counterBox">
          <div class="row">
            <div class="col-lg-3 col-sm-6 p-2">
              <div class="counterItem">
                <div class="icon">
                  <i class="fad fa-chalkboard-teacher"></i>
                </div>
                <div class="info">
                  <h3>
                    <span class="odometer" data-count="4">00</span>
                    <span class="sign-icon">+</span>
                  </h3>
                  <p>COURSES</p>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-sm-6 p-2">
              <div class="counterItem">
                <div class="icon">
                  <i class="fad fa-ski-jump"></i>
                </div>
                <div class="info">
                  <h3>
                    <span class="odometer" data-count="45">00</span>
                    <span class="sign-icon">+</span>
                  </h3>
                  <p>OBSTACLES </p>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-sm-6 p-2">
              <div class="counterItem">
                <div class="icon">
                  <i class="fad fa-users-crown"></i>
                </div>
                <div class="info">

                  <h3>
                    <span class="odometer" data-count="15">00</span>
                    <span class="sign-icon">+</span>
                  </h3>
                  <p>INSTRUCTORS</p>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-sm-6 p-2">
              <div class="counterItem">
                <div class="icon">
                  <i class="fas fa-smile-beam"></i>
                </div>
                <div class="info">

                  <h3>
                    <span class="odometer" data-count="500">00</span>
                    <span class="sign-icon">+</span>
                  </h3>
                  <p>HAPPY ADVENTURERS</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
    <!-- PHILOSOPHY -->
      @foreach($abouts as $about)
    <section class="{{($loop->first) ? 'philosophy' : 'challenging'}}">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-6 p-2">
              @if($about->type == 'video')
            <div class="video">
              <video controls muted src="{{asset($about->video)}}"></video>
            </div>
              @elseif($about->type == 'image')
                <img src="{{asset($about->video)}}" alt="">
              @endif
          </div>
          <div class="col-md-6 p-2">
            <div class="philosophyInfo">
              <h3 class="titleTow text-muted m-0"> {{$about->title}} </h3>
              <h1 class="title"> {{$about->sub_title}} </h1>
              <p>
                  {{$about->desc}}
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>
      @endforeach
{{--      <section class="challenging">--}}
{{--          <div class="container">--}}
{{--              <p class=" titleTow text-muted m-0"> Unmatched Concept </p>--}}
{{--              <h1 class="title"> CHALLENGING <br> YET ENERGIZING </h1>--}}
{{--              <div class="row">--}}
{{--                  <div class="col-md-7 p-2 ">--}}
{{--                      <p>{{$setting->about}}--}}
{{--                      </p>--}}
{{--                  </div>--}}

{{--              </div>--}}
{{--          </div>--}}
{{--      </section>--}}
  </content>
@endsection
