@extends('site.layouts.master')
@section('content')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <content>
      @if (Session::has('success'))
          <script>
              Swal.fire(
                  'Thank You!',
                  '{!! Session::get('success') !!}',
                  'success'
              )
          </script>
      @endif
    <!-- Main Banner  -->
    <section class="mainBanner">
      <button onclick="goBack()" class="Back">
        <i class="fas fa-angle-left"></i>
      </button>
      <ul>
        <li>
          <a href="{{route('/')}}"> home </a>
        </li>
        <li>
          <a href="{{route('contact_us')}}" class="active">Contact Us </a>
        </li>
      </ul>
    </section>
    <!-- mapEarth -->
    <section class="mapEarth">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-lg-6">
            <div class="worldMap">
              <div class="earth"></div>
              <div class="orbic">
                <svg viewBox="0 0 500 500" width="0" height="0">
                  <g id="orbic_path">
                    <ellipse cx="250" cy="250" rx="240" ry="100" transform="rotate(-10,250,250)"></ellipse>
                    <path d="M230,192Q300,25 375,146"></path>
                    <path d="M375,146Q450,175 410,301"></path>
                    <path d="M40,234Q300,125 410,301"></path>
                    <path d="M410,301Q260,165 125,354"></path>
                    <path d="M125,354Q150,220 230,192"></path>
                    <path d="M40,234Q130,200 125,354"></path>
                  </g>
                  <g id="orbic_dots">
                    <defs>
                      <circle id="orbic_dot" cx="0" cy="0" r="6"></circle>
                    </defs>
                    <use id="orbic_dot1" xlink:href="#orbic_dot"></use>
                    <use id="orbic_dot2" xlink:href="#orbic_dot"></use>
                    <use id="orbic_dot3" xlink:href="#orbic_dot"></use>
                    <use id="orbic_dot4" xlink:href="#orbic_dot"></use>
                    <use id="orbic_dot5" xlink:href="#orbic_dot"></use>
                  </g>
                  <g id="orbic_users">
                    <image id="orbic_user1" xlink:href="{{asset('assets/site')}}/img/user1.webp" width="20%" height="20%"></image>
                    <image id="orbic_user2" xlink:href="{{asset('assets/site')}}/img/user2.webp" width="20%" height="20%"></image>
                    <image id="orbic_user3" xlink:href="{{asset('assets/site')}}/img/user3.webp" width="20%" height="20%"></image>
                    <image id="orbic_user4" xlink:href="{{asset('assets/site')}}/img/user4.webp" width="20%" height="20%"></image>
                    <image id="orbic_user5" xlink:href="{{asset('assets/site')}}/img/user5.webp" width="20%" height="20%"></image>
                  </g>
                </svg>
              </div>
            </div>
          </div>
          <div class="col-lg-6 pt-lg-5">
            <div class="d-flex justify-content-start">
              <h2 class="title"> GET IN TOUCH </h2>
            </div>
            <div class="companyInfo ">
              <ul>
                <li>
                  <span><i class="fas fa-map-marker-alt"></i></span>
                  <p class="ms-3">{{$setting->address}} </p>
                </li>
                <li>
                  <span><i class="fas fa-phone"></i></span>
                  <p class="ms-3">
                    {{$setting->title}} Team
                    <a href="tel:00201050809110">{{$setting->Team_phone}}</a>
                  </p>
                </li>
                <li>
                  <span><i class="fas fa-phone"></i></span>
                  <p class="ms-3">
                    Organize your Group Event Or Birthday
                    <a href="tel:00201061844465">{{$setting->group_organization_phone}}</a>
                  </p>
                </li>
                <li>
                  <span><i class="fas fa-envelope"></i></span>
                  <p class="ms-3">
                    Information
                    <a href="mailto:{{$setting->info_email}}">{{$setting->info_email}}</a>
                  </p>
                </li>
                <li>
                  <span><i class="fas fa-envelope"></i></span>
                  <p class="ms-3">
                    Sales
                    <a href="mailto:{{$setting->sales_email}}">{{$setting->sales_email}}</a>
                  </p>
                </li>
              </ul>
            </div>
          </div>

        </div>
      </div>
    </section>

    <!-- contact Form -->
    <section class="contactForm">
      <div class="container">
        <div class="row">
          <div class="col-md-6 order-md-2 mb-5 mb-md-0">
            <section class="googleMap ">
              <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3452.7254232427294!2d30.94778548488418!3d30.073404081871765!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x296bd4895170d534!2sSky%20Park!5e0!3m2!1sar!2seg!4v1641717248640!5m2!1sar!2seg"
                frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
            </section>
          </div>
          <div class="col-md-6 order-md-1">
            <form class="row" method="POST" action="{{route('storeContact')}}">
                @csrf
              <div class="col-12">
                <h2 class="title"> EMAIL US </h2>
              </div>
              <div class="col-md-6 p-3">
                <label class="form-label"> <i class="fas fa-user me-2"></i> First Name</label>
                <input type="text" class="form-control" name="first_name" required>
              </div>
              <div class="col-md-6 p-3">
                <label class="form-label"> <i class="fas fa-user me-2"></i> Last Name</label>
                <input type="text" class="form-control" name="last_name" required>
              </div>
              <div class="col-md-6 p-3">
                <label class="form-label"><i class="fas fa-phone-alt me-2"></i> phone</label>
                <input type="number" class="form-control" name="phone" required>
              </div>
              <div class="col-md-6 p-3">
                <label class="form-label"> <i class="fas fa-envelope me-2"></i> email</label>
                <input type="email" class="form-control" name="email" required>
              </div>
              <div class="col-md-12 p-3">
                <label class="form-label"> <i class="fas fa-feather-alt me-2"></i> Your Message </label>
                <textarea class="form-control" rows="5" name="message" required></textarea>
              </div>
              <div class="col-md-12 text-center p-3">
                <button type="submit" class="default-btn"> Send Massage <i class="fas fa-paper-plane ms-2"></i>
                  <span></span>
                </button>
              </div>
            </form>
          </div>

        </div>
      </div>
    </section>
  </content>
@endsection
