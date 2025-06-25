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
          <a href="{{route('groups')}}" class="active">GROUPS </a>
        </li>
      </ul>
    </section>

    <!-- groups -->
    <section class="groups">
      <div class="container">
          @foreach($groups as $key => $group)
              @php
              $number = ($key + 1)  % 2;
              @endphp
              <div class="group">
                  <div class="row align-items-center">
                      <div class="col-md-6 p-3 {{$number != 0?'order-md-2':''}}">
                          <img src="{{get_file($group->image)}}" >
                      </div>
                      <div class="col-md-6 p-3 order-md-1">
                          <div class="info">
                              <h1 class="title"> {{$group->title}} </h1>
                              <p>
                                  {{$group->text}}
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
