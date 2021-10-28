@extends('user.master',['menu'=>'coin', 'sub_menu'=>'buy_coin'])
@section('title', isset($title) ? $title : '')
@section('style')
<style>
    .modal.fade .modal-bottom,
    .modal.fade .modal-left,
    .modal.fade .modal-right,
    .modal.fade .modal-top {
        position: fixed;
        z-index: 1055;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        margin: 0;
        max-width: 100%
    }
     .modal.fade .modal-right {
     left: auto !important;
     transform: translate3d(100%, 0, 0);
     transition: transform .3s cubic-bezier(.25, .8, .25, 1)
    }

    .modal.fade.show .modal-bottom,
    .modal.fade.show .modal-left,
    .modal.fade.show .modal-right,
    .modal.fade.show .modal-top {
        transform: translate3d(0, 0, 0)
    }

    .w-xl {
        width: 320px;
        height: 100%;
    }

    .modal-content,
    .modal-footer,
    .modal-header {
        border: none
    }
    .bs-placeholder {
        background-color: #212E55 !important;
        border: 1px solid #2B3C70 !important;
    }

    .btn-light {
        background-color: #212E55 !important;
        border: 1px solid #2B3C70 !important;
        color: white !important;
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">
@endsection
@section('content')
    <div class="row">
        <div id="modal-backdrop-dark" class="modal bg-dark fade" data-backdrop="false">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content" style="background: black; height: 100%;">
                <div class="modal-body text-center">
                    <div id="preloader">
                       <img src="{{asset('assets/landing/img/loader.gif')}}" alt="">
                    </div>  
                </div>
              </div>
            </div>
          </div>
        <div class="col-xl-6 mb-xl-0 mb-4">
            <div class="card cp-user-custom-card">
                <div class="card-body">
                    <div class="cp-user-card-header-area">
                        <h4>{{__('Buy Our Coin From Here')}}</h4>
                    </div>
                    @if((empty($nid_back ) && empty($nid_front)) && empty($selfie) || (($nid_back->status == STATUS_PENDING) && ($nid_front->status == STATUS_PENDING) && ($selfie->status == STATUS_PENDING)) || (($nid_back->status == STATUS_REJECTED) && ($nid_front->status == STATUS_REJECTED) && ($selfie->status == STATUS_REJECTED)))
                    <h4 class="mb-3" style="color: red">HARAP MEMVERIFIKASI KYC SEBELUM MELAKUKAN TRANSAKSI PEMBELIAN COIN</h4>
                    @endif
                    <div class="cp-user-buy-coin-content-area">
                        <div class="cp-user-coin-info">
                            <form action="{{route('buyCoinsProcess')}}" method="POST" enctype="multipart/form-data" id="buy_coin">
                                @csrf
                                <div class="form-group">
                                    <label for="coin_name">{{__('Select Coin')}}</label>
                                    <select class="form-control coin" onchange="getRates(this.value)" name="coin_name" id="coin_name" data-live-search="true" required>
                                        <option value="" selected disabled>Select Coin</option>
                                        @foreach ($wallets as $item)
                                            <option value="{{$item['id']}}" data-name="{{$item['traded_currency_unit']}}">{{$item['traded_currency_unit']}}</option>
                                        @endforeach
                                    </select>
                                      
                                </div>
                                <div class="form-group">
                                    <label>{{__('IDR Amount')}}</label>
                                    <input type="hidden" name="" id="temp_price">
                                    <input onkeyup="keyupAmount(this.value)" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" autocomplete="off" id="amount" name="idr_amount" class="form-control" placeholder="{{__('Your Amount')}}">
                                    <ul class="coin_price" style="color: green; font-weight: bolder;">
                                        <li>1 <span id="coin_name_val"></span>  <span class="coinAmount"></span> = <span class="CoinInDoller" id="coint_val"> </span></li>
                                        
                                        <li><span class="text-red" style="color: red !important" id="error_amount"></span></li>
                                    </ul>
                                </div>
                                <div class="form-group">
                                    <label>{{__('Coin Address')}}</label>
                                    <input type="text" required class="form-control" name="address" id="address_user">
                                    <span style="color: red">Harap memerika kembali Address Anda. Sesuaikan Address dengan Coin yang anda beli. Proses pengiriman dilakukan secara manual. Coin akan sampai ke wallet Anda dalam waktu 1 - 10 menit. Kesalahan dalam menginput Address diluar tanggung jawab kami.</span>
                                </div>
                                <div class="form-group">
                                    <label for="">{{__('Total Coin')}}</label>
                                    <input type="text" name="total_coin" id="total_coin" readonly class="form-control">
                                </div>
                                <div class="cp-user-payment-type">
                                    <h3>{{__('Payment Type')}}</h3>
                                    @if(isset($settings['payment_method_coin_payment']) && $settings['payment_method_coin_payment'] == 1)
                                        <div class="form-group">
                                            <input type="radio" onclick="call_coin_payment();" onchange="$('.payment_method').addClass('d-none');$('.bank-details').addClass('d-none');$('.bank-details').removeClass('d-block');$('.btc_payment').toggleClass('d-none');" value="{{BTC}}" id="coin-option" name="payment_type">
                                            <label for="coin-option">{{__('Coin Payment')}}</label>
                                        </div>
                                    @endif
                                    @if(isset($settings['payment_method_bank_deposit']) && $settings['payment_method_bank_deposit'] == 1)
                                        <div class="form-group">
                                            <input type="radio" value="{{BANK_DEPOSIT}}" onchange="$('.payment_method').addClass('d-none');$('.bank-details').addClass('d-block');$('.bank-details').removeClass('d-none');$('.bank_payment').toggleClass('d-none');" id="f-option" name="payment_type">
                                            <label for="f-option">{{__('Bank Deposit')}}</label>
                                        </div>
                                    @endif
                                    @if(isset($settings['payment_method_xendit_payment_gateway']) && $settings['payment_method_xendit_payment_gateway'] == 1)
                                        <div class="form-group">
                                            <input type="radio" onchange="$('.bank_payment').addClass('d-none');" value="{{BALANCE_IDR}}" id="idr-balance" name="payment_type">
                                            <label for="idr-balance">{{__('IDR Balance')}}</label>
                                        </div>
                                    @endif
                                </div>
                                <div class="check-box-list btc_payment payment_method d-none">

                                    <div class="form-group buy_coin_address_input ">
                                        <p>
                                            <span id="coinpayment_address"></span>
                                        </p>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label for="">{{__('Payable Coin')}}</label>
                                                <input class="form-control" disabled type="text" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                                       readonly name="total_price" id="total_price" placeholder="Amount">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="">{{__('Select')}}</label>
                                                <div class="cp-select-area">
                                                <select name="payment_coin_type" class="selet-im vodiapicker form-control " id="payment_type">
                                                    @foreach(paymentTypes() as $key => $paymentType)
                                                        <option
                                                            value="{{$key}}">
                                                            {{$paymentType}}
                                                        </option>

                                                    @endforeach
                                                </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="check-box-list bank_payment payment_method d-none">
                                    <div class="form-group">
                                        <label>{{__('Select Bank')}}</label>
                                        <div class="cp-select-area">
                                        <select name="bank_id" class="bank-id form-control " >
                                            <option value="">{{__('Select')}}</option>
                                            @if(isset($banks[0]))
                                                @foreach($banks as $value)
                                                    <option @if((old('bank_id') != null) && (old('bank_id') == $value->id)) @endif value="{{ $value->id }}">{{$value->bank_name}}</option>
                                                    <span class="text-danger"><strong>{{ $errors->first('bank_id') }}</strong></span>
                                                @endforeach
                                            @endif
                                        </select>
                                        </div>
                                    </div>
                                    <div class="form-group buy_coin_address_input mt-4">
                                        <div id="file-upload" class="section-p">
                                            <input type="hidden" name="bank_deposit_id" value="">
                                            <input type="file" placeholder="0.00" name="sleep" value="" id="file" ref="file" class="dropify" data-default-file="{{asset('assets/img/placeholder-image.png')}}" />
                                        </div>
                                    </div>

                                </div>
                                @if((empty($nid_back ) && empty($nid_front)) && empty($selfie) || (($nid_back->status == STATUS_PENDING) && ($nid_front->status == STATUS_PENDING) && ($selfie->status == STATUS_PENDING)) || (($nid_back->status == STATUS_REJECTED) && ($nid_front->status == STATUS_REJECTED) && ($selfie->status == STATUS_REJECTED))) 
                                    <button id="buy_button" onclick="alert('Harap Memverifikasi KYC Terlebih Dahulu')" class="btn theme-btn">{{__('Buy Now')}}</button>

                                @else
                                    <button id="buy_button" type="submit" class="btn theme-btn">{{__('Buy Now')}}</button>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card cp-user-custom-card">
                <div class="card-body">
                    <div class="cp-user-card-header-area">
                        <h4>Bank Details</h4>
                    </div>
                    <div class="cp-user-coin-rate">
                        <div class="img" id="r-side-img">
                            <img src="{{ asset('assets/user/images/buy-coin-vector.svg') }}" class="img-fluid" alt="">
                        </div>
                        <div class="bank-details">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js"></script>

    <script>
        var price = '';
        $("#buy_button").attr('disabled', true);
        $("#buy_button").css('cursor','not-allowed');
        $('.coin').selectpicker();

        function numberWithCommas(x) {
            var	number_string = x.toString(),
                split	= number_string.split('.'),
                sisa 	= split[0].length % 3,
                rupiah 	= split[0].substr(0, sisa),
                ribuan 	= split[0].substr(sisa).match(/\d{1,3}/gi);
                    
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }
            rupiah = split[1] != undefined ? rupiah : rupiah;

            return rupiah;
        }

        // GET RATES COIN
        function getRates(val)
        {
            var coin = $("#coin_name option:selected").text();
            var url = "{{route('ind.getRates', ':pair')}}";
            url = url.replace(':pair', val);
            $.ajax({
                type: 'GET',
                url: url,
                dataType: 'json',
                success: function(res) {
                    var data = res.ticker;
                    $("#coin_name_val").text(coin);
                    $("#coint_val").text('Rp. ' + numberWithCommas(data.buy));
                    $("#temp_price").val(data.buy);
                    $("#total_coin").val('');
                    $("#amount").val('');
 
                },
                error: function(err) {
                    alert('error');
                }
            })
        }

        

        function keyupAmount(val)
        {   
            var totalGet = '';
            var price = $("#temp_price").val();
            if (val < 50000) {
                $("#error_amount").text('Minimum Buy 50.000');
                $("#buy_button").attr('disabled', true);
                $("#buy_button").css('cursor','not-allowed');
            } else {
                $("#error_amount").text('');
                $("#buy_button").attr('disabled', false);
                $("#buy_button").css('cursor','pointer');
                totalGet += val / price;
                $("#total_coin").val(totalGet);
            } 

            totalGet += '';
        }
        //bank details

        $('.bank-id').change(function () {
            var id = $(this).val();
            $.ajax({
                url: "{{route('bankDetails')}}?val=" + id,
                type: "get",
                success: function (data) {
                    $('div.bank-details').html(data.data_genetare);
                    $('#r-side-img').hide();
                },
                error: function (jqXHR, textStatus, errorThrown) {

                }
            });
        });
    </script>

    <script>
        //change payment type

        $('#payment_type').change(function () {
            var id = $(this).val();
            var amount = $('input[name=coin]').val();
            var pay_type = document.querySelector('input[name="payment_type"]:checked').value;
            var payment_type = $('#payment_type').val();
            call_coin_rate(amount,pay_type,payment_type);

        });
    </script>

    <script>
        function call_coin_rate(amount,pay_type,payment_type) {
            $.ajax({
                type: "POST",
                url: "{{ route('buyCoinRate') }}",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'amount': amount,
                    'payment_type': payment_type,
                    'pay_type': pay_type,
                },
                dataType: 'JSON',

                success: function (data) {
                    $('.coinAmount').text(data.amount);
                    $('.CoinInDoller').text(data.coin_price);
                    $('.totalBTC').text(data.btc_dlr);
                    $('#total_price').val(data.btc_dlr);
                    $('.coinType').text(data.coin_type);
                },
                error: function () {
                    $('.btc-price').addClass('d-none');
                    $('.private-sell-submit').attr('disabled', false);
                }
            });
        }
    </script>

    <script>
        function delay(callback, ms) {
            var timer = 0;
            return function () {
                var context = this, args = arguments;
                clearTimeout(timer);
                timer = setTimeout(function () {
                    callback.apply(context, args);
                }, ms || 0);
            };
        }

        function call_coin_payment() {
            var amount = $('input[name=coin]').val();
            var pay_type = document.querySelector('input[name="payment_type"]:checked').value;
            var payment_type = $('#payment_type').val();
            call_coin_rate(amount,pay_type,payment_type);
        }

        // $("#amount").keyup(delay(function (e) {
        //     var amount = $('input[name=coin]').val();
        //     var pay_type = document.querySelector('input[name="payment_type"]:checked').value;
        //     var payment_type = $('#payment_type').val();

        //     call_coin_rate(amount,pay_type,payment_type);

        // },500));

    </script>
@endsection
