@extends('user.master',['menu'=>'pocket', 'sub_menu'=>'withdraw'])
@section('title', 'Withdraw')
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
                        <h4>{{__('Withdraw Balance')}}</h4>
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
                                </div>

                                <div class="form-group">
                                    <label>{{__('Total Receipt')}}</label>
                                    <input readonly type="text" id="total_idr_dollar_show" name="idr_total_show" class="form-control" />
                                    <span class="bade badge-success">Admin Fee: {{$fees}}</span>
                                </div>
                                
                                <div class="check-box-list bank_payment payment_method" id="bank-deposit">
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
                              </div>
                              <div id="button-buy">

                              </div>
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
        var mininum = "{{$min_wd}}";
        var maximum = "{{$max_wd}}";
        var fees = "{{$value_fees}}";
        if ($("#amount").val() == '') {
            $(':button').prop('disabled', true); // Disable all the buttons
            $("#error_amount").text('Dollar Input is Required');
            $("#total_idr_dollar").val('')
            $("#total_idr_dollar_show").val('');
        } else {
            if ($("#amount").val() < parseFloat(mininum)) {
              $(':button').prop('disabled', true); // Disable all the buttons
              $("#error_amount").text('Mininum WD ' + mininum + '$');
              $("#total_idr_dollar").val('')
              $("#total_idr_dollar_show").val('');
            } else if ($("#amount").val() > parseFloat(maximum)) {
              $(':button').prop('disabled', true); // Disable all the buttons
              $("#error_amount").text('Maximum WD ' + maximum + '$');
              $("#total_idr_dollar").val('')
              $("#total_idr_dollar_show").val('');
            } else {
              $("#payment_type_channel").removeClass("d-none");
              $(':button').prop('disabled', false); // Enable all the button
              $("#error_amount").text('');
              var dollarDepo = $("#amount").val();
              var tempRupiah = dollarDepo * dollars;
              var fee = tempRupiah * fees;
              var total = tempRupiah - fee;
              totalIdr += total;
              $("#total_idr_dollar_show").val('Rp. ' + numberWithCommas(total));
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
            url: "{{route('bankDetailsUser')}}?val=" + id,
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
        var form = new FormData();
        form.append('bank_id',bank_id);
        form.append('dollar_amount', amount);
        form.append('total_wd',totalIdr);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: "{{route('withdrawProcess')}}",
            dataType: 'json',
            processData: false,
            contentType: false,
            data: form,
            success: function(res) {
                alert('Transaksi Berhasil!. Silahkan Menunggu Konfirmasi dari Admin');
                window.location.href = "{{route('myPocket')}}"
            },
            error: function(err) {
              alert(err.responseJSON.message)
            }
        })
    }

</script>
@endsection
