@extends('site.layouts.master')
@section('content')
  <content>
    <!-- mainSlider -->
    <section class="MainSlider">
      <div class="swiper MainSlider-container ">
        <div class="swiper-wrapper">
            @foreach($sliders as $slider)
          <div class="swiper-slide  mainSlideItem" style="background-image:url({{asset($slider->photo)}})">
            <div class=" info">
              <h2> {{$slider->title}} </h2>
              <h1> {{$slider->sub_title}} </h1>
              <a href="{{$slider->button_link}}" class="default-btn"> <i class="fas fa-headset  me-2"></i> {{$slider->button_text}}
                <span></span>
              </a>
            </div>
          </div>
            @endforeach
        </div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
      </div>
    </section>
    <!-- about Section -->
    <section class="aboutSection  ">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-6 p-2">
            <div class="info ">
              <h1 class="title"> about us </h1>
              <p class="animate__animated animate__fadeInUp wow">
                  {{$setting->about}}
              </p>
{{--              <div class="icons row">--}}
{{--                <div class="col p-1 animate__animated animate__fadeInUp wow">--}}
{{--                  <a href="{{route('safety')}}" class="icon">--}}
{{--                    <i class="fas fa-user-hard-hat"></i>--}}
{{--                    <span>SAFE</span>--}}
{{--                  </a>--}}
{{--                </div>--}}
{{--                <div class="col p-1 animate__animated animate__fadeInUp wow">--}}
{{--                  <a href="family-friendly.html" class="icon">--}}
{{--                    <i class="fas fa-users-crown"></i>--}}
{{--                    <span>Family Friendly</span>--}}
{{--                  </a>--}}
{{--                </div>--}}
{{--                <div class="col p-1 animate__animated animate__fadeInUp wow">--}}
{{--                  <a href="challenging.html" class="icon">--}}
{{--                    <i class="fas fa-trophy"></i>--}}
{{--                    <span>CHALLENGING</span>--}}
{{--                  </a>--}}
{{--                </div>--}}
{{--              </div>--}}
            </div>
          </div>
          <div class="col-md-6 p-0">
            <div class="card3D">
              <div class="atropos my-atropos">
                <div class="atropos-scale">
                  <div class="atropos-rotate">
                    <div class="atropos-inner">
                      <div class="card bg-gradient-primary">
                        <div class="BG">
                          <img class="animate__animated animate__fadeInUp wow" data-wow-delay=".5s"
                            data-atropos-offset="4" src="{{asset('assets/site')}}/img/bg.svg" >
                          <img class="animate__animated animate__fadeInUp wow" data-wow-delay="1s"
                            data-atropos-offset="3" src="{{asset('assets/site')}}/img/bg1.svg" >
                          <img class="animate__animated animate__fadeInUp wow" data-wow-delay="1.5s"
                            data-atropos-offset="6" src="{{asset('assets/site')}}/img/bg2.svg" >
                          <img class="animate__animated animate__fadeInUp wow" data-wow-delay="2s"
                            data-atropos-offset="8" src="{{asset('assets/site')}}/img/bg3.svg" >
                        </div>
                        <h1 data-atropos-offset="5"> welcome to </h1>
                        <img class="logo animate__animated animate__fadeInUp wow" data-wow-delay="2s"
                          data-atropos-offset="5" src="{{asset($setting->logo)}}">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!--  COURSES -->
    <section class="courses ">
      <div class="container">
        <div class="row">
          <div class="col-md-10 p-2 m-auto">
            <h1 class="title">OBSTACLE COURSES </h1>
            <div id="logoCarousel" class="carousel">
              <div class="carousel__image-container">
                <ul>
                  <li data-for="0" class="is-active">
                    <h3>{{$expert->name}}</h3>
                    <img  src="{{asset(''.$expert->image)}}">
                  </li>
                  <li data-for="1">
                    <h3>{{$skilled->name}}</h3>
                    <img  src="{{asset(''.$skilled->image)}}">
                  </li>
                  <li data-for="2">
                    <h3>{{$invoice->name}}</h3>
                    <img  src="{{asset(''.$invoice->image)}}">
                  </li>
                </ul>
              </div>
              <div class="carousel__viewport ">
                <div class="carousel__track">
                  <div data-index="0" class="carousel__slide is-selected">
                    <div class="info">
                      <h3>{{$invoice->title}}</h3>
                      <p>{{$invoice->text}}</p>
                    </div>
                  </div>
                  <div data-index="1" class="carousel__slide">
                    <div class="info">
                      <h3>{{$expert->title}}</h3>
                      <p>{{$expert->text}}</p>
                      <a href="#!" class="default-btn"> Learn More
                        <span></span>
                      </a>
                    </div>
                  </div>
                  <div data-index="2" class="carousel__slide">
                    <div class="info">
                      <h3>{{$expert->title}}</h3>
                      <p>{{$setting->title}} {{$expert->text}}</p>
                      <a href="#!" class="default-btn"> Contact Us
                        <span></span>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div id="logoBar" class="carouselBar">
              <p data-for="0" class=" is-active">{{$expert->name}}</p>
              <p data-for="1">{{$skilled->name}}</p>
              <p data-for="2">{{$invoice->name}}</p>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- offers -->
    <section class="offers">
      <div class="container">
        <h1 class="title"> WHAT WE OFFER </h1>
        <ul class="nav nav-tabs" role="tablist">
            @foreach($offers as $offer)
          <li class="nav-item" role="presentation">
            <button class="nav-link {{($loop->iteration == 1) ? 'active' :''}}" id="{{$offer->title}}-tab" data-bs-toggle="tab" data-bs-target="#{{$offer->title}}" role="tab"
              aria-controls="{{$offer->title}}">{{$offer->title}}</button>
          </li>
            @endforeach
        </ul>
        <div class="tab-content">
            @foreach($offers as $offer)
            <div class="tab-pane fade {{($loop->iteration == 1) ? 'show active' :''}}" id="{{$offer->title}}" role="tabpanel" aria-labelledby="{{$offer->title}}-tab">
            <div class="row">
                @foreach($offer->items as $item)
              <div class=" col  p-2">
                <div class="offer">
                  <div class="offerImg">
                    <img src="{{asset($item->photo)}}" >
                  </div>
                  <h2> {{$item->title}} </h2>
                  <p>{{Str::limit($item->desc,200)}} </p>
                  <a href="{{route('offer_details',$item->id)}}"> VIEW COURSE </a>
                </div>
              </div>
                @endforeach
            </div>
          </div>
            @endforeach
        </div>
      </div>
    </section>
    <!-- prices -->
    <section class="prices">
      <div class="container">
        <h1 class="title"> PRICES & OPENING HOURS </h1>
        <div class="swiper prices-container ">
          <div class="swiper-wrapper">
            @foreach($prices_sliders as $slide)
            <div class="swiper-slide ">
              <a data-fancybox="prices" href="{{asset(''.$slide->image)}}" data-caption="">
                <img src="{{asset(''.$slide->image)}}/">
              </a>
            </div>
            @endforeach
          </div>
          <div class="swiper-button-next"></div>
          <div class="swiper-button-prev"></div>
        </div>
      </div>
    </section>
    <!-- contact -->
    <section class="contact">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-6 p-2">
            <h1 class="titleTow"> GET IN TOUCH </h1>
            <ul class="info">
              <li>
                <a href="#!">
                  <span class="icon me-2">
                    <i class="fas fa-map-marked-alt"></i>
                  </span>
                  {{$setting->address}}
                </a>
              </li>
              <li>
                <a href="mailto:info@skypark.fun">
                  <span class="icon me-2">
                    <i class="fas fa-envelope"></i>
                  </span>
                  {{$setting->info_email}}
                </a>
              </li>
              <li>
                <a href="tel:01223303786">
                  <span class="icon me-2">
                    <i class="fas fa-phone-rotary"></i>
                  </span>
                    {{$setting->phone}}
                </a>
              </li>
            </ul>
            <h1 class="titleTow"> FOLLOW US </h1>
            <ul class="info">
              <li class="d-inline-block">
                <a href="{{$setting->facebook}}" target="_blank">
                  <span class="icon me-2">
                    <i class="fab fa-facebook"></i>
                  </span>
                </a>
              </li>
              <li class="d-inline-block">
                <a href="{{$setting->instagram}}" target="_blank">
                  <span class="icon me-2">
                    <i class="fab fa-instagram"></i>
                  </span>
                </a>
              </li>
              <li class="d-inline-block">
                <a href="{{$setting->twitter}}" target="_blank">
                  <span class="icon me-2">
                    <i class="fab fa-twitter"></i>
                  </span>
                </a>
              </li>
            </ul>
          </div>
          <div class="col-md-6 p-2">
            <div class="map">
              <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3452.7254232427294!2d30.94778548488418!3d30.073404081871765!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x296bd4895170d534!2sSky%20Park!5e0!3m2!1sar!2seg!4v1641717248640!5m2!1sar!2seg"
                style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
          </div>
        </div>
      </div>
    </section>
  </content>
@endsection
