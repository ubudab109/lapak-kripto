<!DOCTYPE HTML>
<html class="no-js" lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="The Highly Secured Bitcoin Wallet">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:type" content="article" />
    <meta property="og:title" content="{{allsetting('app_title')}}"/>
    <meta property="og:image" content="{{asset('assets/user/images/logo.svg')}}">
    <meta property="og:site_name" content="Cpoket"/>
    <meta property="og:url" content="{{url()->current()}}"/>
    <meta property="og:type" content="{{allsetting('app_title')}}"/>
    <meta itemscope itemtype="{{ url()->current() }}/{{allsetting('app_title')}}" />
    <meta itemprop="headline" content="{{allsetting('app_title')}}" />
    <meta itemprop="image" content="{{asset('assets/user/images/logo.svg')}}" />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('assets/user/css/bootstrap.min.css')}}">
    <!-- metismenu CSS -->
    <link rel="stylesheet" href="{{asset('assets/user/css/metisMenu.min.css')}}">
    {{--for toast message--}}
    <link href="{{asset('assets/toast/vanillatoasts.css')}}" rel="stylesheet" >
    <!-- Datatable CSS -->
    <link rel="stylesheet" href="{{asset('assets/user/css/datatable/datatables.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/user/css/datatable/dataTables.bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/user/css/datatable/dataTables.jqueryui.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/user/css/datatable/jquery.dataTables.min.css')}}">

    <link rel="stylesheet" href="{{asset('assets/user/css/jquery.scrollbar.css')}}">
    <link rel="stylesheet" href="{{asset('assets/user/css/font-awesome.min.css')}}">


    {{--    dropify css  --}}
    <link rel="stylesheet" href="{{asset('assets/dropify/dropify.css')}}">

    <!-- Style CSS -->
    <link rel="stylesheet" href="{{asset('assets/user/style.css')}}">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="{{asset('assets/user/css/responsive.css')}}">

    @yield('style')
    <title>{{allsetting('app_title')}}::@yield('title')</title>
    <script src="https://kit.fontawesome.com/d817027240.js" crossorigin="anonymous"></script>
</head>

<body class="cp-user-body-bg">
<!-- top bar -->
<div class="cp-user-main-wrapper">
    <div class="container-fluid">
        <div style="color: #155724;background-color: #d4edda;border-color: #c3e6cb;"
             class="alert-float alert alert-success d-none" id="web_socket_notification">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
            <div class="web_socket_notification_html"></div>
        </div>
        <div class="row justify-content-center">
          <div class="col-12 text-white">
            <div class="card bg-success">
              <div class="card-header">Payment Success</div>
              <div class="card-body">
                <h3 class="text-white">
                  Payment Success. You Will Be Redirect To Pocket Page
                </h3>
                <span id="time">05:00</span>
              </div>
            </div>
          </div>
        </div>
    </div>
</div>
<!-- /main wrapper -->

<!-- js file start -->
<script src="{{asset('js/app.js')}}"></script> 
<!-- JavaScript -->
<script src="{{asset('assets/user/js/jquery.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
{{-- <script src="{{asset('assets/user/js/bootstrap.min.js')}}"></script> --}}
<script src="{{asset('assets/user/js/metisMenu.min.js')}}"></script>
{{--toast message--}}
<script src="{{asset('assets/toast/vanillatoasts.js')}}"></script>

<script src="{{asset('assets/user/js/jquery.scrollbar.min.js')}}"></script>
<script>
  function startTimer(duration, display) {
      var timer = duration, minutes, seconds;
      var end =setInterval(function () {
          minutes = parseInt(timer / 60, 10)
          seconds = parseInt(timer % 60, 10);

          minutes = minutes < 10 ? "0" + minutes : minutes;
          seconds = seconds < 10 ? "0" + seconds : seconds;

          display.textContent = minutes + ":" + seconds;

          if (--timer < 0) {
              window.location = "{{ route('myPocket') }}";
              clearInterval(end);
          }
      }, 1000);
  }
  window.onload = function () {
      var fiveMinutes = 5,
          display = document.querySelector('#time');
      startTimer(fiveMinutes, display);
  };
</script>
</body>
</html>


