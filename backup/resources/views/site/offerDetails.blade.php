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
                    <a href="#!" class="active"> {{$offer->title}} </a>
                </li>
            </ul>
        </section>
        <!-- about us page -->
        <section class="aboutUsPage">
            <div class="container">

                <div class="row">
{{--                    <div class="col-lg-4 col-md-12 d-none d-md-block">--}}
{{--                        <div class="sidebar-right">--}}
{{--                        @if($offers->count() > 0)--}}
{{--                            <!-- Recent posts start -->--}}
{{--                                <div class="widget recent-posts">--}}
{{--                                    <h3 class="sidebar-title">Recent Offers</h3>--}}
{{--                                    @foreach($offers as $off)--}}
{{--                                        <div class="d-flex position-relative mb-4 recent-posts-box">--}}
{{--                                            <a href="{{route('offer_details',$off->id)}}">--}}
{{--                                                <img src="{{asset($off->photo)}}"--}}
{{--                                                     class="flex-shrink-0 me-3" alt="...">--}}
{{--                                            </a>--}}
{{--                                            <div class="align-self-center">--}}
{{--                                                <h5>--}}
{{--                                                    <a href="{{route('offer_details',$off->id)}}">--}}
{{--                                                        {{$off->title}}--}}
{{--                                                    </a>--}}
{{--                                                </h5>--}}
{{--                                                <div class="listing-post-meta">--}}
{{--                                                    <a href="#"><i class="fa fa-calendar mr-2"></i>--}}
{{--                                                        {{$off->created_at->diffForHumans()}}--}}
{{--                                                    </a>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    @endforeach--}}
{{--                                </div>--}}
{{--                        @endif--}}
{{--                            <!-- Tags box Start -->--}}
{{--                            <div class="widget tags-box widget-3">--}}
{{--                                <h3 class="sidebar-title">Tags</h3>--}}
{{--                                <ul class="tags">--}}
{{--                                    @foreach($tags as $tag)--}}
{{--                                        <li><a href="#!">{{$tag->title}}</a></li>--}}
{{--                                    @endforeach--}}
{{--                                </ul>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

                    <div class="col-lg-9 col-md-12" style="margin:auto">
                        <div class="contents p-md-3">

                            <h1 class="title "> {{$offer->title}} </h1>


                            <div class="img-div w-100">
                                <img src="{{asset($offer->photo)}}" alt="">
                            </div>

                            <p class="mt-5">
                                {{$offer->desc}}
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </section>

    </content>
@endsection
