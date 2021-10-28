@extends('user.master',['menu'=>'topup'])
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

    .img-payment {
        width: 50px;
        display: block;
        top: 0;
        left: 0;
        right: 0;
    }

    /* Solid border */
    hr.solid {
        border-top: 3px solid #bbb;
    }
</style>
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
                        <h4>{{__('Topup Pocket')}}</h4>
                    </div>
                    <div class="cp-user-buy-coin-content-area">
                        <div class="cp-user-coin-info">
                            <form action="{{route('buyCoinsProcess')}}" method="POST" enctype="multipart/form-data" id="buy_coin">
                                @csrf
                                <div class="form-group">
                                    <label>{{__('IDR Amount')}}</label>
                                    <input onkeyup="keyupAmount(this.value)" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" autocomplete="off" id="amount" name="idr_amount" class="form-control" placeholder="{{__('Your Amount')}}">
                                    <span style="color: red" id="error_amount"></span>
                                </div>
                                
                                <div class="cp-user-payment-type d-none" id="payment_type_channel">
                                    <h3>{{__('Payment Type')}}</h3>
                                    @if(isset($settings['payment_method_bank_deposit']) && $settings['payment_method_bank_deposit'] == 1)
                                        <div class="form-group">
                                            <input type="radio" value="{{BANK_DEPOSIT}}" onchange="formBank()" class="check_payment" id="f-option" name="payment_type">
                                            <label for="f-option">{{__('Bank Deposit')}}</label>
                                        </div>
                                    @endif
                                    @if(isset($settings['payment_method_xendit_payment_gateway']) && $settings['payment_method_xendit_payment_gateway'] == 1)
                                        <div class="form-group">
                                            <input type="radio" value="{{XENDIT}}" class="check_payment" onchange="getPaymentChannels()" id="f-option-1" name="payment_type">
                                            <label for="f-option-1">{{__('Online Payment Virtual Account')}}</label>
                                        </div>
                                    @endif
                                </div>

                                {{-- FOR BANK DEPOSIT --}}
                                <div class="check-box-list bank_payment payment_method d-none" id="bank-deposit">
                                    <div class="form-group">
                                        <label>{{__('Select Bank')}}</label>
                                        <div class="cp-select-area">
                                        <select name="bank_id" class="bank-id form-control" id="bank_id" onchange="getBank()">
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

                                {{-- FOR PAYMENT GATEWAY --}}
                                <div class="check-box-list bank_payment payment_method d-none" id="payment-gate">
                                    {{-- VA --}}
                                    <div>
                                        <h5 class="text-white">Virtual Account</h5>
                                        <hr class="solid" />
                                        <div id="virtual-account" class="row mb-5">
                                            
                                        </div>
                                    </div>

                                    {{-- E Wallet --}}
                                    <div>
                                        <h5 class="text-white">E Wallet</h5>
                                        <hr class="solid" />
                                        <div id="ewallet" class="row mb-5">

                                        </div>
                                    </div>

                                    {{-- RETAIL --}}
                                    <div>
                                        <h5 class="text-white">Retail</h5>
                                        <hr class="solid" />
                                        <div id="retail" class="row mb-5">

                                        </div>
                                    </div>

                                    {{-- QRIS --}}
                                    <div>
                                        <h5 class="text-white">QRIS</h5>
                                        <hr class="solid" />
                                        <div id="qris" class="row mb-5">

                                        </div>
                                    </div>
                                </div>
                                <div id="button-buy">

                                </div>
                                {{-- <button id="buy_button" type="submit" class="btn theme-btn">{{__('Buy Now')}}</button> --}}
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
                        <div class="bank-details" id="bank_details">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- OVO --}}
    <div class="modal fade" id="ovo-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                <div id="form-ovo-phone" class="form-group">
                    <label>{{__('OVO Phone Number')}}</label>
                    <div class="input-group mb-2 mr-sm-2">
                        <div class="input-group-prepend">
                            <div class="input-group-text">+62</div>
                        </div>
                        <input type="text" autocomplete="off" id="ovo_number" name="ovo_number" class="form-control" placeholder="{{__('Your Phone Number: Ex: 858xxxxxxx')}}">
                        </div>
                </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" onclick="payChargeEwallet('ID_OVO','{{route('createEwalletCharge', Auth::id())}}')" class="btn btn-primary">Pay</button>
            </div>
            </div>
        </div>
    </div>

    
    {{-- OVO MODAL INVOICE --}}
    <div class="modal fade" id="ovo-modal-invoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row justify-content-center">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Transaction ID : </td>
                                    <td id="trans_id"></td>
                                </tr>
                                <tr>
                                    <td>OVO Number : </td>
                                    <td id="ovo_number"></td>
                                </tr>
                                <tr>
                                    <td>Total : </td>
                                    <td id="total_ovo"></td>
                                </tr>
                                <tr>
                                    <td>Status : </td>
                                    <td id="status_ovo"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                        <h3>Silakan periksa aplikasi OVO Anda</h3>
                        <p>Harap konfirmasi pembayaran dengan aplikasi OVO anda. Halaman ini akan diperbarui setelah pembayaran Anda dikonfirmasi.</p>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>

    {{-- EWALLET MODAL TO PAY --}}
    <div class="modal fade" id="wallet-modal-invoice" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-12 col-md-12 col-sm-12 text-center">
                            <h3>Silakan periksa aplikasi E-Wallet Anda</h3>
                            <p>Setelah Membayar Harap Klik Tombol 'SUBMIT' Dibawah</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
            
                <button type="button" onclick="window.location.href = '{{route('myPocket')}}'" class="btn btn-primary">SUBMIT</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script src="{{asset('assets/user/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/dropify/dropify.js')}}"></script>
<script src="{{asset('assets/dropify/form-file-uploads.js')}}"></script>
<script type="text/javascript">
    $("#amount").on("keyup", () => {
        if ($("#amount").val() == '') {
            $(':button').prop('disabled', true); // Disable all the buttons
            $("#error_amount").text('MININUM TOPUP = Rp. 50.000')
        } else {
            if ($("#amount").val() < 50000) {
                $(':button').prop('disabled', true); // Disable all the buttons
                $("#error_amount").text('MININUM TOPUP = Rp. 50.000')
            } else {
                $("#payment_type_channel").removeClass("d-none");
                $(':button').prop('disabled', false); // Enable all the button
                $("#error_amount").text('')
            }

        }

    })

    // Validation keyup phone number ovo
    $("#ovo_number").on('input propertychange paste', function (e) {
        $(this).val($(this).val().replace(/[^0-9]/g, ''));
        var val = $(this).val()
        var reg = /^0/gi;
        if (val.match(reg)) {
            $(this).val(val.replace(reg, ''));
        }
    });

    // RUPIAH FORMAT
    function formatRupiah(angka, prefix){
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
        split   		= number_string.split(','),
        sisa     		= split[0].length % 3,
        rupiah     		= split[0].substr(0, sisa),
        ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
    
        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if(ribuan){
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
    
        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }

    // FORM BANK DEPOSIT MANUAl
    function formBank() {
        $('.payment_method').addClass('d-none');$('.bank-details').addClass('d-block');$('.bank-details').removeClass('d-none');$('.bank_payment').toggleClass('d-none');
        $("#payment-gate").addClass('d-none');   
    }

    // LIST PAYMENT CHANNELS
    function getPaymentChannels() {
        $("#bank-deposit").addClass('d-none');
        $("#payment-gate").removeClass('d-none');
        $("#virtual-account").html('')
        $("#ewallet").html('')
        $("#retail").html('')
        $("#qris").html('')
        $.ajax({
            type: 'GET',
            url: '{{route('listPaymentChannels')}}',
            dataType: 'json',
            success: function(res) {
                res.map((val, i) => {
                    if (val.channel_category == 'VIRTUAL_ACCOUNT') {
                        $("#virtual-account").append(`
                            <div class="col-lg-4 col-md-12 col-sm-12 mb-2">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="form-check">
                                        <input class="form-check-input" onchange="createVa('${val.channel_code}')" type="radio" name="payment_code" id="${val.channel_code}">
                                        <img class="img-payment" src="{{asset('payment/${val.channel_code}.png')}}" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `)
                    }

                    if (val.channel_category == 'EWALLET') {
                        $("#ewallet").append(`
                            <div class="col-lg-4 col-md-12 col-sm-12 mb-2">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="form-check">
                                        <input class="form-check-input" onchange="createChargeWallet('ID_${val.channel_code}')" type="radio" name="payment_code" id="${val.channel_code}">
                                        <img class="img-payment" src="{{asset('payment/${val.channel_code}.png')}}" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `)
                    }

                    if (val.channel_category == 'RETAIL_OUTLET') {
                        $("#retail").append(`
                            <div class="col-lg-4 col-md-12 col-sm-12 mb-2">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="form-check">
                                        <input class="form-check-input" onchange="createRetailPayment('${val.channel_code}')" type="radio" name="payment_code" id="${val.channel_code}">
                                        <img class="img-payment" src="{{asset('payment/${val.channel_code}.png')}}" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `)
                    }

                    if (val.channel_category == 'QRIS') {
                        $("#qris").append(`
                            <div class="col-lg-4 col-md-12 col-sm-12 mb-2">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="form-check">
                                        <input class="form-check-input" type="radio" onchange="createQrCode()" name="payment_code" id="${val.channel_code}">
                                        <img class="img-payment" src="{{asset('payment/${val.channel_code}.png')}}" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `)
                    }
                })
            },
            error: function(res) {
                alert('Terjadi Kesalahan. Harap Memuat Ulang Halaman Ini');
            }
        })
    }

    // DATE FORMAT
    function formatDate(date) {
        var hours = date.getHours();
        var minutes = date.getMinutes();
        var ampm = hours >= 12 ? 'pm' : 'am';
        hours = hours % 12;
        hours = hours ? hours : 12; // the hour '0' should be '12'
        minutes = minutes < 10 ? '0'+minutes : minutes;
        var strTime = hours + ':' + minutes + ' ' + ampm;
        return date.getMonth()+1 + "/" + date.getDate() + "/" + date.getFullYear() + " " + strTime;
    }

    // ON CHANGE TO CREATE VA
    function createVa(bankCode) {
        var amount = $("#amount").val();
        var userId = "{{Auth::id()}}"
        var url = "{{route('createFixedVa', ':id')}}";
        url = url.replace(':id', userId);
        $("#button-buy").html(`
                            <button id="buy_button" onclick="payCreateVa('${bankCode}','${amount}','${url}')" type="button" class="btn theme-btn">Submit</button> 
                        `);
        
    }

    // PROCESS TO PAY VA
    function payCreateVa(bankCode, amount, url) {
        $('#bank_details').html('');
        var form = new FormData();
        form.append('bank_code', bankCode);
        form.append('amount', amount);
        $.ajax({
            type: 'POST',
            url: url,
            dataType: 'json',
            processData: false,
            contentType: false,
            data: form,
            success: function(res) {
                $('#r-side-img').hide();
                $('#bank_details').html('');
                $("#button-buy").html(`
                            <button style="cursor: not-allowed;" disabled type="button" class="btn theme-btn">Submit</button> 
                        `);
                $(".form-check-input").prop('disabled', true);
                $("#bank_details").append(`
                    <h3 class="text-center">Bank Details</h3>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Transaction ID : </td>
                                    <td>${res.external_id}</td>
                                </tr>
                                <tr>
                                    <td>Bank Name : </td>
                                    <td>${res.bank_code}</td>
                                </tr>
                                <tr>
                                    <td>Account Name : </td>
                                    <td>${res.name}</td>
                                </tr>
                                <tr>
                                    <td>Virtual Account : </td>
                                    <td>${res.account_number}</td>
                                </tr>
                                <tr>
                                    <td>Topup Amount : </td>
                                    <td>${formatRupiah(String(res.expected_amount), 'Rp. ')}</td>
                                </tr>
                                <tr>
                                    <td>Expired : </td>
                                    <td>${formatDate(new Date(res.expiration_date))}</td>
                                </tr>
                            </tbody>
                            
                        </table>
                `)
            },
            error: function(err) {
                alert('Harap Mengisi Jumlah Topup');
            }
        })
    }

    // ON CHANGE E WALLET PAYMENT
    function createChargeWallet(walletChannel) {
        var userId = "{{Auth::id()}}"
        var url = "{{route('createEwalletCharge', ':id')}}";
        url = url.replace(':id', userId);
        if (walletChannel == 'ID_OVO') {
            $("#button-buy").html(`
                            <button id="buy_button" data-toggle="modal" data-target="#ovo-modal" type="button" class="btn theme-btn">Submit</button> 
                        `);
        } else {
            $("#button-buy").html(`
                            <button id="buy_button" onclick="payChargeEwallet('${walletChannel}','${url}')" type="button" class="btn theme-btn">Submit</button> 
                        `);
        }
        
    }

    // Process to pay e wallet
    function payChargeEwallet(walletChannel, url) {
        $('#bank_details').html('');
        var amount = $("#amount").val();
        var form = new FormData();
        form.append('channelCode', walletChannel);
        form.append('amount', amount);

        if (walletChannel == 'ID_OVO') {
            var phone = $("#ovo_number").val();
            form.append('phone_number',`+62${phone}`);
        }

        $.ajax({
            type: 'POST',
            url: url,
            dataType: 'json',
            processData: false,
            contentType: false,
            data: form,
            success: function(res) {
                $("#button-buy").html(`
                            <button style="cursor: not-allowed;" disabled type="button" class="btn theme-btn">Submit</button> 
                        `);
                $(".form-check-input").prop('disabled', true);
                $('#bank_details').html('');
                $('#r-side-img').hide();


                if (walletChannel == 'ID_OVO') {
                    $("#ovo-modal").modal('hide');
                    $("#ovo-modal-invoice").modal('show');
                    $("#trans_id").text(res.reference_id);
                    $("#ovo_number").text(`+62${phone}`);
                    $("#total_ovo").text(res.charge_amount);
                    $("#status_ovo").text(res.status);
                    setInterval(eventCallbackEwallet(res.id), 3000);
                } else {
                    $("#bank_details").append(`
                    <h3 class="text-center">Payment Details</h3>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Transaction ID : </td>
                                    <td>${res.reference_id}</td>
                                </tr>
                                <tr>
                                    <td>Wallet Name : </td>
                                    <td>${res.channel_code == 'ID_DANA' ? 'DANA' : 'LINK AJA'}</td>
                                </tr>
                                <tr>
                                    <td>Topup Amount : </td>
                                    <td>${formatRupiah(String(res.capture_amount), 'Rp. ')}</td>
                                </tr>
                                <tr>
                                    <td>Status : </td>
                                    <td>${res.status}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="col-lg-12 col-md-8 col-sm-8">
                            <a class="btn btn-primary text-white" onclick="redirectPage('${res.actions.mobile_web_checkout_url}')">Pay Here</a>
                        </div>
                    `)
                }
            },
            error: function(res) {
                alert('Harap Mengisi Jumlah Topup');
            }
        })
    }

    // REDIRECT TO PAYMENT EWALLET
    function redirectPage(url)
    {
        window.open(url)
        $("#wallet-modal-invoice").modal('show')
    }


    // CALLBACK PAY E WALLET WITH OVO
    function eventCallbackEwallet(id)
    {
        var form = new FormData();
        form.append('id', id);
        $.ajax({
            type: 'POST',
            url: "{{ route('ewallet.status')}}",
            data: form,
            processData: false,
            contentType: false,
            success: function(res) {
                alert('Pembayaran BERHASIL. Klik OKE untuk melanjutkan')
                window.location.reload();
            },
            error: function(err) {
                alert('Pembayaran GAGAl. Klik OKE untuk melanjutkan');
            }
        })
    }

    // Create retail payment
    function createRetailPayment(retail) {
        $("#button-buy").html('');
        var userId = "{{Auth::id()}}"
        var url = "{{route('createRetailPayment', ':id')}}";
        url = url.replace(':id', userId);
        $("#button-buy").html(`
                        <button id="buy_button" onclick="processRetailPayment('${retail}','${url}')" type="button" class="btn theme-btn">Submit</button> 
                    `);
    }

    // PROCESS PAY RETAIL PAYMENT
    function processRetailPayment(retail, url) {
        $('#bank_details').html('');
        var amount = $("#amount").val();
        var form = new FormData();
        form.append('retail_name', retail);
        form.append('amount', amount);
        $.ajax({
            type: 'POST',
            url: url,
            dataType: 'json',
            processData: false,
            contentType: false,
            data: form,
            success: function(res) {
                $('#r-side-img').hide();
                $('#bank_details').html('');
                $("#button-buy").html(`
                            <button style="cursor: not-allowed;" disabled type="button" class="btn theme-btn">Submit</button> 
                        `);
                $(".form-check-input").prop('disabled', true);
                $("#bank_details").append(`
                    <div id="area-print-retail">
                        <div class="row justify-content-center">
                            <h3 class="text-center">Payment Details</h3>
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>Transaction ID : </td>
                                            <td>${res.external_id}</td>
                                        </tr>
                                        <tr>
                                            <td>Retail Name : </td>
                                            <td>${res.retail_outlet_name}</td>
                                        </tr>
                                        <tr>
                                            <td>Account Name : </td>
                                            <td>${res.name}</td>
                                        </tr>
                                        <tr>
                                            <td>Payment Code : </td>
                                            <td>${res.payment_code}</td>
                                        </tr>
                                        <tr>
                                            <td>Topup Amount : </td>
                                            <td>${formatRupiah(String(res.expected_amount), 'Rp. ')}</td>
                                        </tr>
                                        <tr>
                                            <td>Expired : </td>
                                            <td>${formatDate(new Date(res.expiration_date))}</td>
                                        </tr>
                                    </tbody>
                                    
                                </table>
                        </div>
                        <div class="row justify-content-center mb-6">
                            <div id="qr-code" class="col-lg-4 col-md-4 col-sm-4"></div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-12 col-md-8 col-sm-8" id="button-barcode-retail">
                            
                        </div>
                    </div>
                `);

                if (res.retail_outlet_name == 'ALFAMART') {
                    $("#button-barcode-retail").append(`
                        <a class="btn btn-primary text-white" target="_blank" href="https://retail-outlet-barcode-dev.xendit.co/alfamart/${res.payment_code}">Download</a>
                    `)
                } else {
                    $("#button-barcode-retail").append(`
                        <a class="btn btn-primary text-white" onclick="downloadTemplate()">Download</a>
                    `)
                }
                new QRCode(document.getElementById("qr-code"), {
                    text: `'${res.payment_code}'`,
                    width: 250,
                    height: 250,
                });
                
            },
            error: function(err) {
                alert('Harap Mengisi Jumlah Topup');
            }
        })
    }

    // Download QR Retail Indomaret
    function downloadTemplate() {
        html2canvas(document.getElementById("area-print-retail"),		{
                allowTaint: true,
                useCORS: true
            }).then(function (canvas) {
                var anchorTag = document.createElement("a");
                document.body.appendChild(anchorTag);
                anchorTag.download = "qrCode.jpg";
                anchorTag.href = canvas.toDataURL();
                anchorTag.target = '_blank';
                anchorTag.click();
            });
    }

    // Create QR Code
    function createQrCode() {
        $("#button-buy").html('');
        var userId = "{{Auth::id()}}"
        var url = "{{route('qrCodePayment', ':id')}}";
        url = url.replace(':id', userId)
        $("#button-buy").html(`
                        <button id="buy_button" onclick="processQrPayment('${url}')" type="button" class="btn theme-btn">Submit</button> 
                    `);
    }

    // process qris
    function processQrPayment(url) {
        var amount = $("#amount").val();
        var form = new FormData();
        form.append('amount', amount);
        $.ajax({
            type: 'POST',
            url: url,
            dataType: 'json',
            processData: false,
            contentType: false,
            data: form,
            success: function(res) {
                $('#r-side-img').hide();
                $('#bank_details').html('');
                $("#button-buy").html(`
                            <button style="cursor: not-allowed;" disabled type="button" class="btn theme-btn">Submit</button> 
                        `);
                $(".form-check-input").prop('disabled', true);
                $("#bank_details").append(`
                    <div id="area-print-retail">
                        <div class="row justify-content-center">
                            <h3 class="text-center">Payment Details</h3>
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>Transaction ID : </td>
                                            <td>${res.external_id}</td>
                                        </tr>
                                        <tr>
                                            <td>Topup Amount : </td>
                                            <td>${formatRupiah(String(res.amount), 'Rp. ')}</td>
                                        </tr>
                                        <tr>
                                            <td>Status : </td>
                                            <td>${res.status}</td>
                                        </tr>
                                    </tbody>
                                    
                                </table>
                        </div>
                        <div class="row justify-content-center mb-6">
                            <div id="qr-code" class="col-lg-4 col-md-4 col-sm-4"></div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-12 col-md-8 col-sm-8" id="button-barcode-qr">
                            
                        </div>
                    </div>
                `);

                $("#button-barcode-qr").append(`
                        <a class="btn btn-primary text-white" onclick="downloadTemplate()">Download</a>
                    `)
                new QRCode(document.getElementById("qr-code"), {
                    text: `'${res.qr_string}'`,
                    width: 250,
                    height: 250,
                });
            },
            error: function(err) {
                alert('Harap Mengisi Total Topup')
            }
        })
    }

    // GET BANK DETAIL PAYMENT BANK MANUAL DEPOSIT
    function getBank() {
        var id = $("#bank_id").val();
        $('#bank_details').html('');
        $("#button-buy").html('');
        $.ajax({
            url: "{{route('bankDetails')}}?val=" + id,
            type: "get",
            success: function (data) {
                $('#bank_details').html(data.data_genetare);
                $('#r-side-img').hide();
                $("#button-buy").html(`
                        <button id="buy_button" onclick="bankProcess()" type="button" class="btn theme-btn">Submit</button> 
                    `);
            },
            error: function (jqXHR, textStatus, errorThrown) {

            }
        });
    }

    function bankProcess() {
        var bank = $("#bank_id option:selected").text();
        var bank_id = $("#bank_id").val();
        var amount = $("#amount").val();
        var file = $("#file").prop('files')[0];
        var form = new FormData();
        form.append('bank_code', bank);
        form.append('bank_id',bank_id);
        form.append('amount', amount);
        form.append('sleep',file);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: "{{route('processTopup')}}",
            dataType: 'json',
            processData: false,
            contentType: false,
            data: form,
            success: function(res) {
                alert('Transaksi Berhasil!. Silahkan Menunggu Konfirmasi dari Admin');
                window.location.href = "{{route('myPocket')}}"
            },
            error: function(err) {
                alert('Harap Periksa Semua Form')
            }
        })
    }
</script>
@endsection
