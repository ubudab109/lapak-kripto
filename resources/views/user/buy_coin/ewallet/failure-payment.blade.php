@extends('user.master',['menu'=>'coin', 'sub_menu'=>'buy_coin'])
@section('title', 'Lapak Kripto')
@section('content')
  <div class="row justify-content-center">
    <div class="col-12 text-white">
      <div class="card bg-danger">
        <div class="card-header">Payment Failed</div>
        <div class="card-body">
          <h3 class="text-white">
            Payment Failed. You Will Be Redirect To Pocket Page
          </h3>
          <span id="time">05:00</span>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('script')
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

  // function redirect()
  // {

  // }

  window.onload = function () {
      var fiveMinutes = 5,
          display = document.querySelector('#time');
      startTimer(fiveMinutes, display);
  };
</script>
@endsection
