<!doctype html>
<html lang="en" dir="ltr">

<head>
    @include('site/layouts/head')
</head>

<body>
@include('site/layouts/header')

@yield('content')

@include('site/layouts/footer')
@include('site/layouts/scripts')
@yield('site-js')
</body>
</html>


