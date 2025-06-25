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
                    <a href="{{route('privacy')}}" class="active">Privacy </a>
                </li>
            </ul>
        </section>
        <!-- Terms page -->
        <section class="aboutUsPage">
            <div class="container">
                <h1 class="title"> Privacy </h1>
                <div class="row">
                    <div class="col-md-7 p-2 m-auto">
                        <p>
                            {!! $setting->privacy !!}
                        </p>
                    </div>
                </div>
            </div>
        </section>



    </content>
@endsection
