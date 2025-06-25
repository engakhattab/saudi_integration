<!DOCTYPE html>
<html lang="ar">

<head>
    <!-- Required meta tags -->
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>dountLand</title>
    <!-- icon -->
    <link rel="icon" href="{{get_file(setting()->logo)}}" type="image/x-icon" />
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- fonts  -->
    <link href="https://fonts.googleapis.com/css?family=Cairo&display=swap" rel="stylesheet" />
    <style>
        .container {
            background-color: rgb(255, 255, 255);
            border-radius: 30px;
        }

        h5 {
            font-weight: bold;
            margin-bottom: 30px;
        }

        * {
            font-family: "Cairo", sans-serif;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            outline: none;
        }

        body {
            overflow-x: hidden;
            background: linear-gradient(45deg , #0087d6 , #fff);
        }

        ::-webkit-scrollbar {
            width: 4px;
            height: 4px;
            background-color: #e4e4e4;
        }

        ::-webkit-scrollbar-track {
            -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
            box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
        }

        ::-webkit-scrollbar-thumb {
            background-color: #525252;
            outline: none;
            border-radius: 20px !important;
        }

        a {
            text-decoration: none;
        }

        a:hover {
            text-decoration: none;
        }

        button:focus {
            outline: 0;
        }

        .form-control:focus {
            border: 1px solid #fff;
            -webkit-box-shadow: 0px 2px 2px 1px #25252553;
            box-shadow: 0px 2px 2px 1px #25252553;
            -webkit-transition: 0.3s ease;
            transition: 0.3s ease;
        }

        .row {
            margin: 0px;
        }

        .logo {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
        }

        .logo .image img {
            height: 80px;
            max-width: 120px;
            object-fit: contain;
        }

    </style>
</head>

<body dir="rtl">

<div class="logo">
    <div class="image py-5">
        <img src="{{get_file(setting()->logo)}}">
    </div>

</div>



<div class="terms px-2">
    <div class="container  w-lg-75 mb-5 shadow ">
        {!! $text !!}
    </div>
</div>

<!--////////////////////////////////////////////////////////////////////////////////-->
<!--////////////////////////////////////////////////////////////////////////////////-->
<!--////////////////////////////////////////////////////////////////////////////////-->
<!--/////////////////////////////JavaScript/////////////////////////////////////////-->
<!--////////////////////////////////////////////////////////////////////////////////-->
<!--////////////////////////////////////////////////////////////////////////////////-->
<!--////////////////////////////////////////////////////////////////////////////////-->

</body>

</html>
