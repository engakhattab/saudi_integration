<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="icon" type="image/png" href="img/favicon.png">
  <title> {{$setting->title}} </title>
  <!-- CSS Files -->
  <link id="pagestyle" href="css/app.min.css" rel="stylesheet" />
  <link href="css/font.awesome.css" rel="stylesheet" />
  <link href="css/style.css" rel="stylesheet" />
</head>

<body class="g-sidenav-show ">

  <div class="page-header min-vh-100">
    <div class="container">
      <div class="row">
        <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-lg-0 ">
          <div class="card card-plain">
            <div class="card-header pb-0 text-start">
              <h2 class="font-weight-bolder mb-3">Login</h2>
              <p class="mb-0">Enter your user name and password to Login</p>
            </div>
            <div class="card-body">
              <form action="index.html">
                <div class="mb-3">
                  <input type="text" class="form-control form-control-lg" placeholder="User Name">
                </div>
                <div class="mb-3">
                  <input type="password" class="form-control form-control-lg" placeholder="Password">
                </div>

                <div class="text-center">
                  <button type="submit" class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-4 mb-0">Login</button>
                </div>
              </form>
            </div>

          </div>
        </div>
        <div class="col-6 d-md-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
          <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center">
            <img src="img/pattern-lines.svg" alt="pattern-lines" class="position-absolute opacity-4 start-0">
            <div class="position-relative">
              <img class="max-width-500 w-100 position-relative z-index-2" src="img/rocket-white.png" alt="chat-img">
            </div>
            <h3 class="mt-5 text-white font-weight-bolder">" Welcome To {{$setting->title}} "</h3>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- ================================================== -->
  <!-- ================================================== -->
  <!-- ================================================== -->
  <!-- ================== JS Files ====================== -->
  <!-- ================================================== -->
  <!-- ================================================== -->
  <!-- ================================================== -->
  <script src="js/popper.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <!-- plugins -->
  <script src="js/plugins/perfect-scrollbar.min.js"></script>
  <script src="js/plugins/smooth-scrollbar.min.js"></script>
  <script src="js/plugins/chartjs.min.js"></script>
  <script src="js/plugins/threejs.js"></script>
  <script src="js/plugins/orbit-controls.js"></script>
  <!-- dashboard Js -->
  <script src="js/app.min.js"></script>
  <!-- custom Js -->
  <script src="js/custom.js"></script>
</body>

</html>
