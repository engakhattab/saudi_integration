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
            <a href="{{route('activities')}}" class="active">Activities </a>
        </li>
      </ul>
    </section>

    <!-- activities -->
    <section class="activities">
      <div class="container">
          @foreach($activities as $activity)
        <div class="activity">
          <div class="row align-items-center">
            <div class="col-md-6 p-3 {{($loop->odd) ? 'order-md-2' : ''}}">
              <img src="{{asset($activity->photo)}}" >
            </div>
            <div class="col-md-6 p-3 {{($loop->odd) ? 'order-md-1' : ''}}">
              <div class="info">
                  <h3 class="titleTow text-muted m-0"> {{$activity->title}} </h3>
                  <h1 class="title"> {{$activity->sub_title}} </h1>
                <p>
                    {{$activity->desc}}
                </p>
              </div>
            </div>
          </div>
        </div>
          @endforeach
      </div>
    </section>



  </content>
 @endsection
