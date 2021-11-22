@extends('user.master',['menu'=>'pocket', 'sub_menu'=>'topup'])
@section('title', isset($title) ? $title : '')
@section('style')
@endsection
@section('content')
    <div class="loader" id="loader"></div>
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
                            <form enctype="multipart/form-data" id="buy_coin">
                                <div class="form-group">
                                    <label>{{__('Dollar Amount')}}</label> <br />
                                    <span class="bade badge-success" id="dollar_rate"></span>
                                    <div class="input-group mb-3">
                                        <input oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" autocomplete="off" id="amount" name="idr_amount" class="form-control" placeholder="{{__('Your Amount')}}">
                                        <div class="input-group-append">
                                          <span class="input-group-text" id="basic-addon2">$</span>
                                        </div>
                                      </div>
                                    <span style="color: red" id="error_amount"></span>
                                    {{-- still hard code --}}
                                    <input type="hidden" name="" id="dollar_buy" value="16200"> 
                                </div>

                                <div class="form-group">
                                    <label>{{__('Total Pay')}}</label>
                                    <input readonly type="hidden" id="total_idr_dollar" name="idr_total" class="form-control" />
                                    <input readonly type="text" id="total_idr_dollar_show" name="idr_total_show" class="form-control" />
                                    <span class="bade badge-success">Admin Fee: {{$fees}}%</span>
                                </div>
                                
                                <div class="cp-user-payment-type d-none" id="payment_type_channel">
                                    <h3>{{__('Payment Type')}}</h3>
                                    @if(isset($settings['payment_method_bank_deposit']) && $settings['payment_method_bank_deposit'] == 1)
                                        <div class="form-group">
                                            <input type="radio" value="{{BANK_DEPOSIT}}" class="check_payment" id="f-option" name="payment_type">
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
    var dollars = 0;
    var totalIdr = 0;

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


    $(document).ready(() => {
        $.ajax({
            type: 'GET',
            url: "{{route('getDollarKurs')}}",
            dataType: 'json',
            success: function (res) {
                dollars += parseFloat(res.conversion_rate);
                $("#dollar_rate").text('1$ = Rp. ' + numberWithCommas(res.conversion_rate))
                $("#loader").addClass('hide-loader');
            }, 
            error: function (res) {
                alert('Terjadi kesahalan, Mohon memuat ulang halaman ini')
                window.location.reload();
            }
        });
    });

    

    $("#amount").on("keyup", () => {
        var dollar = dollars;
        var minimum = "{{$minimum}}";
        if ($("#amount").val() == '') {
            $(':button').prop('disabled', true); // Disable all the buttons
            $("#error_amount").text('Dollar Input is Required');
            $("#total_idr_dollar").val('')
            $("#total_idr_dollar_show").val('');
        } else {
            if ($("#amount").val() < parseFloat(minimum)) {
                $(':button').prop('disabled', true); // Disable all the buttons
                $("#error_amount").text('Minimum Topup $' + minimum);
                $("#total_idr_dollar").val('')
                $("#total_idr_dollar_show").val('');
            } else {
                $("#payment_type_channel").removeClass("d-none");
                $(':button').prop('disabled', false); // Enable all the button
                $("#error_amount").text('');
                var dollarDepo = $("#amount").val();
                var tempRupiah = dollarDepo * dollar;
                var fee = tempRupiah * 0.1;
                var total = tempRupiah + fee;
                totalIdr += total;
                $("#total_idr_dollar_show").val('Rp. ' + numberWithCommas(total));
                console.log(totalIdr);
            }

        }

    })

    $(".check_payment").change(function() {
        if ($('input.check_payment').is(':checked')) { 
            $("#bank-deposit").removeClass('d-none');
        } else {
            $("#bank-deposit").addClass('d-none');
        }
    });
    // GET BANK DETAIL PAYMENT BANK MANUAL DEPOSIT
    $('#bank-id').change(function () {
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
        var idr = totalIdr;
        var file = $("#file").prop('files')[0];
        var form = new FormData();
        form.append('bank_code', bank);
        form.append('bank_id',bank_id);
        form.append('amount', amount);
        form.append('sleep',file);
        form.append('total_topup',idr);
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
