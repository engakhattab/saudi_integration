<!DOCTYPE html>
<html>

<head>
    <title>Login</title>

    @include('sales.layouts.assets.head')
    @include('layouts.loader.mainLoader.loaderCss')

</head>

<body class="g-sidenav-show ">
    @include('layouts.loader.mainLoader.loader')
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
              <form action="{{route('login')}}" method="post" id="LoginForm" enctype="multipart/form-data">
                  @csrf
                <div class="mb-3 ">
                  <input type="text" class="form-control form-control-lg" name="user_name" placeholder="User Name">
                </div>
                <div class="mb-3 ">
                  <input type="password" class="form-control form-control-lg" name="password" placeholder="Password">
                </div>

                <div class="text-center ">
                  <button type="submit" id="loginButton" class="btn btn-lg bg-gradient-primary btn-lg w-100 mt-4 mb-0"><i id="lockId" class="fa fa-lock" style="margin-left: 6px"></i> Login</button>
                </div>
              </form>
            </div>

          </div>
        </div>
        <div class="col-6 d-md-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
          <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center">
            <img src="{{asset('assets/sales/img/pattern-lines.svg')}}" alt="pattern-lines" class="position-absolute opacity-4 start-0">
            <div class="position-relative">
              <img class="max-width-500 w-100 position-relative z-index-2" src="{{asset('assets/sales/img/rocket-white.png')}}" alt="chat-img">
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
  @include('sales.layouts.assets.scripts')

    <script>
        $("form#LoginForm").submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var url = $('#LoginForm').attr('action');

          function playAudio() {
            var x = new Audio('http://localhost/amricana/public/sound/eventually-590.ogg');
            // Show loading animation.
            var playPromise = x.play();

            if (playPromise !== undefined) {
              playPromise.then(_ => {
                x.play();
              })
                .catch(error => {
                });

            }
          }

          $.ajax({
                url:url,
                type: 'POST',
                data: formData,
                beforeSend: function(){
                    $('#loginButton').html('<span class="spinner-border spinner-border-sm mr-2" ' +
                        ' ></span> <span style="margin-left: 4px;">working</span>').attr('disabled', true);

                },
                complete: function(){


                },
                success: function (data) {
                    if (data == 200){
                        toastr.success('login successfully');
                        window.setTimeout(function() {
                            window.location.href='sales';
                        }, 1000);
                      playAudio();

                    }else {
                        toastr.error('wrong password');
                        $('#loginButton').html(`<i id="lockId" class="fa fa-lock" style="margin-left: 6px"></i> Login`).attr('disabled', false);
                    }

                },
                error: function (data) {
                    if (data.status === 500) {
                        $('#loginButton').html(`<i id="lockId" class="fa fa-lock" style="margin-left: 6px"></i> Login`).attr('disabled', false);
                        toastr.error('هناك خطأ ما');
                    }
                    else if (data.status === 422) {
                        $('#loginButton').html(`<i id="lockId" class="fa fa-lock" style="margin-left: 6px"></i> Login`).attr('disabled', false);
                        var errors = $.parseJSON(data.responseText);
                        $.each(errors, function (key, value) {
                            if ($.isPlainObject(value)) {
                                $.each(value, function (key, value) {
                                    toastr.error(value,key);
                                });

                            } else {
                            }
                        });
                    }else {
                        $('#loginButton').html(`<i id="lockId" class="fa fa-lock" style="margin-left: 6px"></i> Login`).attr('disabled', false);

                        toastr.error('there in an error');
                    }
                },//end error method

                cache: false,
                contentType: false,
                processData: false
            });
        });

    </script>

</body>

</html>
