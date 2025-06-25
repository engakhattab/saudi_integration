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
          <a href="{{route('/')}}"> home </a>
        </li>
        <li>
          <a href="#!" class="active"> SAFE </a>
        </li>
      </ul>
    </section>
    <!-- about us page -->
    <section class="aboutUsPage">
      <div class="container">

        <div class="row">
          <div class="col-lg-4 col-md-12 d-none d-md-block">
            <div class="sidebar-right">
              <!-- Search box -->
              <div class="widget search-box">
                <h3 class="sidebar-title">Search</h3>
                <form class="form-inline form-search" method="GET">
                  <div class="form-group">
                    <label class="sr-only" for="textsearch2">Looking for something</label>
                    <input type="text" class="form-control" id="textsearch2" placeholder="Search">
                  </div>
                  <button type="submit" class="btn"><i class="fa fa-search"></i></button>
                </form>
              </div>
              <!-- Recent posts start -->
              <div class="widget recent-posts">
                <h3 class="sidebar-title">Recent Posts</h3>
                <div class="d-flex position-relative mb-4 recent-posts-box">
                  <a href="blog-details.html">
                    <img src="{{asset('assets/site')}}/img/post1.jpg" class="flex-shrink-0 me-3" alt="...">
                  </a>
                  <div class="align-self-center">
                    <h5>
                      <a href="blog-details.html">6 Tips for Renting Ski Equipment</a>
                    </h5>
                    <div class="listing-post-meta">
                      $345,00 | <a href="#"><i class="fa fa-calendar"></i> Jan 12, 2020</a>
                    </div>
                  </div>
                </div>

                <div class="d-flex position-relative recent-posts-box">
                  <a href="blog-details.html">
                    <img src="{{asset('assets/site')}}/img/post2.jpg" class="flex-shrink-0 me-3" alt="...">
                  </a>
                  <div class="align-self-center">
                    <h5>
                      <a href="blog-details.html">The Best Spots for Freeride Trips</a>
                    </h5>
                    <div class="listing-post-meta">
                      $745,00 | <a href="#"><i class="fa fa-calendar"></i>Aug 26, 2021</a>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Posts By Category Start -->
              <div class="posts-by-category widget">
                <h3 class="sidebar-title">Category</h3>
                <ul class="list-unstyled list-cat">
                  <li><a href="#"> backcountry <span>(19)</span></a></li>
                  <li><a href="#">extreme <span>(22) </span></a></li>
                  <li><a href="#">gopro <span>(45)</span></a></li>
                  <li><a href="#"> snowpark <span>(21)</span> </a></li>
                  <li><a href="#"> sport <span>(9) </span></a></li>
                </ul>
              </div>

              <!-- Tags box Start -->
              <div class="widget tags-box widget-3">
                <h3 class="sidebar-title">Tags</h3>
                <ul class="tags">
                  <li><a href="#">backcountry</a></li>
                  <li><a href="#">extreme</a></li>
                  <li><a href="#">gopro</a></li>
                  <li><a href="#">snowpark</a></li>
                  <li><a href="#">sport</a></li>
                  <li><a href="#">backcountry</a></li>
                  <li><a href="#"> sport</a></li>
                </ul>
              </div>
            </div>
          </div>

          <div class="col-lg-8 col-md-12">
            <div class="contents p-md-3">

              <h1 class="title "> SAFE </h1>


              <div class="img-div w-100">
                <img src="{{asset('assets/site')}}/img/safety.jpg" alt="">
              </div>

              <p class="mt-5">Adventure is more than just a fun activity to spend your time
                 on, it’s more like food that fuels up your life and brings a joyful spirit
                  to your days. But what makes {{$setting->title}} adventures special, is our special
                   ingredient “Safety” which is our utmost priority through the design and
                    implementation of our obstacle courses.

                We deliver a new definition for adventure, and that is to challenge your limits
                but in a completely safe and secure environment. At {{$setting->title}}, every champ must be
                 equipped with a safety harness that is carefully strapped to a safety wire all
                  attached to our course. The wire will always hold you if your feet failed to.
                   But that’s not the extent of it, helmets are not an option to make sure that diamond
                   valued head of yours stays untouched. In addition, you get the option to rent or buy a pair
                   of gloves in order to hold onto your dear life as much as you wich, without your hands growing tired of it.

                               </p>
            </div>



          </div>
        </div>

      </div>
    </section>

  </content>
@endsection
