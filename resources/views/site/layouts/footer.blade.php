<footer class="footer">
    <div class="container">
        <div class="logo">
            <img src="{{asset($setting->logo)}}" >
        </div>
        <div class="links">
            <ul>
                <li>
                    <a href="{{route('/')}}">Home</a>
                </li>
                <li>
                    <a href="{{route('about_us')}}">About us</a>
                </li>
                <li>
                    <a href="{{route('activities')}}">Activities</a>
                </li>
                <li>
                    <a href="{{route('groups')}}">Groups</a>
                </li>
                <li>
                    <a href="{{route('privacy')}}">Privacy</a>
                </li>
                <li>
                    <a href="{{route('refund-policy')}}">Refund Policy</a>
                </li>
                <li>
                    <a href="{{route('contact_us')}}">Contact us</a>
                </li>

            </ul>
        </div>
        <div class="row align-items-center">
            <div class="col-md-6 p-2">
                <div class="social ">
                    <ul>
                        <li>
                            <a target="_blank" href="{{$setting->twitter}}"><i class="fab fa-twitter"></i></a>
                        </li>
                        <li>
                            <a target="_blank" href="{{$setting->facebook}}"><i class="fab fa-facebook"></i></a>
                        </li>
                        <li>
                            <a target="_blank" href="{{$setting->instagram}}"><i class="fab fa-instagram"></i></a>
                        </li>
                        <li>
                            <a target="_blank" href="{{$setting->snap}}"><i class="fab fa-snapchat-ghost"></i></a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-6 p-2">
                <p> All rights reserved © {{date('Y')}} <a href="{{route('/')}}"> {{$setting->title}} </a></p>
            </div>
        </div>
    </div>
</footer>
