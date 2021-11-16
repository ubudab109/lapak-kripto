@extends('user.master',['menu'=>'pocket'])
@section('title', isset($title) ? $title : '')
@section('style')
<style>
    .status-filter {
        background: #182346 !important;
        border-color: #182346 !important;
        color: white !important;
    }
    .modal-dark {
        background: #182346 !important;
        color: white !important;
    }
</style>
@endsection
@section('content')
    <div class="row mb-5">
        <div class="col-12">
            <div class="card text-white bg-info">
                <div class="card-header">
                    Balance
                </div>
                <div class="card-body">
                    <div class="col-lg-4 col-sm-4 col-md-4">
                        <div class="card text-white bg-info border-0" style="font-size: 20px">
                            <div class="card-body">
                                <i class="fas fa-money-check"></i>{{__(' ')}}{{number_format($wallets->balance, 2)}}{{__(' ')}}$
                                @if((empty($nid_back ) && empty($nid_front)) && empty($selfie) || (($nid_back->status == STATUS_PENDING) && ($nid_front->status == STATUS_PENDING) && ($selfie->status == STATUS_PENDING)) || (($nid_back->status == STATUS_REJECTED) && ($nid_front->status == STATUS_REJECTED) && ($selfie->status == STATUS_REJECTED)))
                                    <a onclick="alert('Harap Memverifikasi KYC Terlebih Dahulu')" class="btn" title="Topup" style="color: white"> <i class="fas fa-undo-alt"></i> </a>

                                @else 

                                    <a class="btn btn-primary" style="border-radius: 20px" href="{{route('topup')}}" class="btn" title="Topup" style="color: white"> Topup </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="user-management">
        <div class="row">
            <div class="col-12">
                <ul class="nav user-management-nav mb-3" id="pills-tab" role="tablist">
                    @if(isset($settings['payment_method_xendit_payment_gateway']) && $settings['payment_method_xendit_payment_gateway'] == 1)
                    <li class="nav-item">
                        <a data-id="active_users" class="nav-link active" id="pills-va-tab" data-toggle="pill" href="#pills-va" role="tab" aria-controls="pills-va" aria-selected="true">
                            <span>{{__('Virtual Account')}}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a data-id="va_tab" class="nav-link ewallet_tab" id="pills-ewallet-tab" data-toggle="pill" href="#pills-ewallet" role="tab" aria-controls="pills-ewallet" aria-selected="true">
                            <span>{{__('E-Wallet')}}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a data-id="retail_tab" class="nav-link" id="pills-retail-tab" data-toggle="pill" href="#pills-retail" role="tab" aria-controls="pills-suspended-user" aria-selected="true">
                            <span>{{__('Retail')}}</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a data-id="qris_tab" class="nav-link" id="pills-qris-tab" data-toggle="pill" href="#pills-qris" role="tab" aria-controls="pills-qris" aria-selected="true">
                            <span>{{__('QRIS')}}</span>
                        </a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a data-id="bank_tab" class="nav-link active" id="pills-bank-tab" data-toggle="pill" href="#pills-bank" role="tab" aria-controls="pills-bank" aria-selected="true">
                            {{__('Bank Deposit')}}
                        </a>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    @if(isset($settings['payment_method_xendit_payment_gateway']) && $settings['payment_method_xendit_payment_gateway'] == 1)
                    <div class="tab-pane show active" id="pills-va" role="tabpanel" aria-labelledby="pills-va-tab">
                        @include('user.pocket.partials.va-transaction')
                    </div>
                    <div class="tab-pane" id="pills-ewallet" role="tabpanel" aria-labelledby="pills-ewallet-tab">
                        @include('user.pocket.partials.ewallet-transaction')
                    </div>
                    <div class="tab-pane" id="pills-retail" role="tabpanel" aria-labelledby="pills-retail-tab">
                        @include('user.pocket.partials.retail-transaction')
                    </div>
                    <div class="tab-pane" id="pills-qris" role="tabpanel" aria-labelledby="pills-qris-tab">
                        @include('user.pocket.partials.qris-transaction')
                    </div>
                    @endif
                    <div class="tab-pane active" id="pills-bank" role="tabpanel" aria-labelledby="pills-bank-tab">
                        @include('user.pocket.partials.bank-transaction')
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    {{-- MODAL DETAIL VA HISTORY --}}
    <div class="modal fade" id="invoice-va" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Detail Payment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-white">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Transaction ID : </td>
                                    <td id="id_va"></td>
                                </tr>
                                <tr>
                                    <td>Bank Name : </td>
                                    <td id="bank_va"></td>
                                </tr>
                                <tr>
                                    <td>Account Name : </td>
                                    <td id="account_va"></td>
                                </tr>
                                <tr>
                                    <td>Virtual Account : </td>
                                    <td id="va_number"></td>
                                </tr>
                                <tr>
                                    <td>Topup Amount : </td>
                                    <td id="topup_va"></td>
                                </tr>
                                <tr>
                                    <td>Expired : </td>
                                    <td id="expired_va"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>
    {{-- END --}}


    {{-- MODAL DETAIL EWALLET HISTORY --}}
    <div class="modal fade" id="invoice-ewallet" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Detail Payment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-white">
                <div class="row justify-content-center">
                    <div class="col-12" id="detail-ewallet-invoice">
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>
    {{-- END --}}

    {{-- MODAL DETAIL EWALLET HISTORY --}}
    <div class="modal fade" id="invoice-retail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Detail Payment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-white">
                <div class="row justify-content-center">
                    <div class="col-12" id="detail-retail-invoice">
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>
    {{-- END --}}


    {{-- MODAL QRIS --}}
    <div class="modal fade" id="invoice-qris" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Detail Payment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-white">
                <div class="row justify-content-center">
                    <div class="col-12" id="detail-qris-invoice">
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>
    {{-- END --}}


    {{-- MODAL BANK --}}
    <div class="modal fade" id="invoice-bank" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle-1">Detail Payment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-white">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Transaction ID : </td>
                                    <td id="id_bank"></td>
                                </tr>
                                <tr>
                                    <td>Bank Name : </td>
                                    <td id="bank_name"></td>
                                </tr>
                                <tr>
                                    <td>Account Number : </td>
                                    <td id="rek_number"></td>
                                </tr>
                                <tr>
                                    <td>Dolar Topup : </td>
                                    <td id="topup_dollar"></td>
                                </tr>
                                <tr>
                                    <td>Topup Amount : </td>
                                    <td id="topup_bank"></td>
                                </tr>
                                <tr>
                                    <td>Status : </td>
                                    <td id="status_bank"></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="row justify-content-center">
                            <div class="col-lg-8 col-md-8 col-sm-12" id="media_trans">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
    </div>
    {{-- END --}}


@endsection

@section('script')
<script>
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

    $(document).ready(function() {
        // TABLE VA
        var table_va = $("#table-va").DataTable({
            processing: true,
            serverSide: true,
            pageLength: 10,
            retrieve: true,
            bLengthChange: true,
            responsive: true,
            ajax: {
                url : '{{route('vaHistory')}}',
                data: function (d) {
                    d.status = $('#status-va').val()
                }
            },
            autoWidth: false,
            language: {
                paginate: {
                    next: 'Next &#8250;',
                    previous: '&#8249; Previous'
                }
            },
            columns: [
                    {"data": "external_id","orderable": true},
                    {"data": "total_topup","orderable": true},
                    {"data": "status","orderable": true},
                    {"data": "payment_merchant","orderable": true},
                    {"data": "virtual_account_number","orderable": false},
                    {"data": "expired_at","orderable": true},
                    {"data": "action","orderable": false},
                ],
        });

        $("#status-va").change(() => {
            table_va.draw();
        });
        // END TABLE VA

        // TABLE E WALLET
        var table_ewallet = $("#table-ewallet").DataTable({
            processing: true,
            serverSide: true,
            pageLength: 10,
            retrieve: true,
            bLengthChange: true,
            responsive: true,
            ajax: {
                url : '{{route('eWalletHistory')}}',
                data: function (d) {
                    d.status = $('#status-ewallet').val()
                }
            },
            autoWidth: false,
            language: {
                paginate: {
                    next: 'Next &#8250;',
                    previous: '&#8249; Previous'
                }
            },
            columns: [
                    {"data": "external_id","orderable": true},
                    {"data": "total_topup","orderable": true},
                    {"data": "status","orderable": true},
                    {"data": "payment_merchant","orderable": true},
                    {"data": "action","orderable": false},
                ],
        });

        $("#status-ewallet").change(() => {
            table_ewallet.draw();
        });
        // END EWALLET TABLE

        // TABLE RETAIL
        var table_retail = $("#table-retail").DataTable({
            processing: true,
            serverSide: true,
            pageLength: 10,
            retrieve: true,
            bLengthChange: true,
            responsive: true,
            ajax: {
                url : '{{route('retailHistory')}}',
                data: function (d) {
                    d.status = $('#status-retail').val()
                }
            },
            autoWidth: false,
            language: {
                paginate: {
                    next: 'Next &#8250;',
                    previous: '&#8249; Previous'
                }
            },
            columns: [
                    {"data": "external_id","orderable": true},
                    {"data": "total_topup","orderable": true},
                    {"data": "status","orderable": true},
                    {"data": "payment_merchant","orderable": true},
                    {"data": "payment_code","orderable": false},
                    {"data": "expired_at","orderable": true},
                    {"data": "action","orderable": false},
                ],
        });

        $("#status-retail").change(() => {
            table_retail.draw();
        });
        // END RETAIL TABLE

        // QRIS TABLE
        var table_qris = $("#table-qris").DataTable({
            processing: true,
            serverSide: true,
            pageLength: 10,
            retrieve: true,
            bLengthChange: true,
            responsive: true,
            ajax: {
                url : '{{route('qrisHistory')}}',
                data: function (d) {
                    d.status = $('#status-qris').val()
                }
            },
            autoWidth: false,
            language: {
                paginate: {
                    next: 'Next &#8250;',
                    previous: '&#8249; Previous'
                }
            },
            columns: [
                    {"data": "external_id","orderable": true},
                    {"data": "total_topup","orderable": true},
                    {"data": "status","orderable": true},
                    {"data": "payment_merchant","orderable": false},
                    {"data": "created_at","orderable": true},
                    {"data": "action","orderable": false},
                ],
        });

        $("#status-qris").change(() => {
            table_qris.draw();
        });
        // END


        // TABLE BANK DEPO
        var table_bank = $("#table-bank").DataTable({
            processing: true,
            serverSide: true,
            pageLength: 10,
            retrieve: true,
            bLengthChange: true,
            responsive: true,
            ajax: {
                url : '{{route('bankDepoHistory')}}',
                data: function (d) {
                    d.status = $('#status-bank').val()
                }
            },
            autoWidth: false,
            language: {
                paginate: {
                    next: 'Next &#8250;',
                    previous: '&#8249; Previous'
                }
            },
            columns: [
                    {"data": "external_id","orderable": true},
                    {"data": "idr","orderable": true},
                    {"data": "dollar","orderable": true},
                    {"data": "status","orderable": true},
                    {"data": "payment_merchant","orderable": true},
                    {"data": "virtual_account_number","orderable": false},
                    {"data": "action","orderable": false},
                ],
        });

        $("#status-bank").change(() => {
            table_bank.draw();
        });
        // END TABLE VA
    });

    // SHOW INVOICE VA
    function showVa(id) {
        var url = "{{route('showTopupHistory', ':id')}}";
        url = url.replace(':id', id);
        $.ajax({
            type: 'GET',
            url: url,
            dataType: 'json',
            success: function(res) {
                $("#id_va").text(res.external_id);
                $("#bank_va").text(res.payment_merchant);
                $("#account_va").text(res.user.first_name + ' ' + res.user.last_name);
                $("#va_number").text(res.virtual_account_number);
                $("#topup_va").text(formatRupiah(String(res.total_topup), 'Rp. '));
                $("#expired_va").text(formatDate(new Date(res.expired_at)));
            }, 
            error: function(err) {
                alert('Terjadi Kesalahan. Silahkan Memuat Ulang Halaman Ini');
            }
        })
    }
    
    // SHOW INVOICE EWALLET
    function showEwallet(id) {
        var url = "{{route('showTopupHistory', ':id')}}";
        url = url.replace(':id', id);
        $.ajax({
            type: 'GET',
            url: url,
            dataType: 'json',
            success: function(res) {
                $("#detail-ewallet-invoice").html('');
                if (res.payment_merchant == 'OVO') {
                    var append = `
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>Transaction ID : </td>
                                <td>${res.external_id}</td>
                            </tr>
                            <tr>
                                <td>Merchant Name : </td>
                                <td>${res.payment_merchant}</td>
                            </tr>
                            <tr>
                                <td>Number Phone : </td>
                                <td>${res.virtual_account_number}</td>
                            </tr>
                            <tr>
                                <td>Topup Amount : </td>
                                <td>${res.total_topup}</td>
                            </tr>
                            <tr>
                                <td>Status : </td>
                                <td>${res.status}</td>
                            </tr>
                            <tr>
                                <td>Paid At : </td>
                                <td>${res.status == 'SUCCEEDED' ? formatDate(new Date(res.updated_at)) : ''}</td>
                            </tr>
                        </tbody>
                    </table>
                    `
                } else {
                    var buttonPay = `
                        <div class="row justify-content-center mb-2">
                            <h3>Pay Here</h3>
                        </div>
                        <div class="row justify-content-center">
                            <a class="btn btn-info mr-3" target="_blank" href="${res.payout_web_link}">Web Payment</a>
                            <a class="btn btn-primary" target="_blank" href="${res.payout_mobile_link}">Mobile Payment</a>
                        </div>
                    `;
                    var append = `
                    <div class="row">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Transaction ID : </td>
                                    <td>${res.external_id}</td>
                                </tr>
                                <tr>
                                    <td>Merchant Name : </td>
                                    <td>${res.payment_merchant}</td>
                                </tr>
                                <tr>
                                    <td>Topup Amount : </td>
                                    <td>${res.total_topup}</td>
                                </tr>
                                <tr>
                                    <td>Status : </td>
                                    <td>${res.status}</td>
                                </tr>
                                <tr>
                                    <td>Paid At : </td>
                                    <td>${res.status == 'SUCCEEDED' ? formatDate(new Date(res.updated_at)) : ''}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    ${res.status == 'SUCCEEDED' ? '' : buttonPay}
                    `
                }
                $("#detail-ewallet-invoice").append(append)
            }, 
            error: function(err) {
                alert('Terjadi Kesalahan. Silahkan Memuat Ulang Halaman Ini');
            }
        })
    }

    // SHOW INVOICE RETAIL
    function showRetail(id) {
        var url = "{{route('showTopupHistory', ':id')}}";
        url = url.replace(':id', id);
        $.ajax({
            type: 'GET',
            url: url,
            dataType: 'json',
            success: function(res) {
                $("#detail-ewallet-invoice").html('');
                if (res.payment_merchant == 'INDOMARET') {
                    var barcode = `
                    <div id="print-area-idm">
                        <div class="row justify-content-center mb-2">
                            <h3>Barcode</h3>
                        </div>
                        <div class="row justify-content-center mb-2">
                            <div class="col-lg-8 text-center" style="color: #676B79">    
                                <p>Harap mengunjungi Indomaret terdekat. Tunjukan Kode Pembayaran ${res.payment_code} kepada Kasir atau scan Barcode yang tertera</p>
                            </div>
                        </div>
                        <div class="row justify-content-center mb-3">
                            <div class='col-lg-4 col-md-4 col-sm-4' id='retail_qr'>
                            
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <a class="btn btn-info mr-3" onclick="downloadQr('print-area-idm')">Download</a>
                    </div>
                    `;
                    var append = `
                    <div class='row'>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Transaction ID : </td>
                                    <td>${res.external_id}</td>
                                </tr>
                                <tr>
                                    <td>Merchant Name : </td>
                                    <td>${res.payment_merchant}</td>
                                </tr>
                                <tr>
                                    <td>Payment Code : </td>
                                    <td>${res.payment_code}</td>
                                </tr>
                                <tr>
                                    <td>Topup Amount : </td>
                                    <td>${res.total_topup}</td>
                                </tr>
                                <tr>
                                    <td>Status : </td>
                                    <td>${res.status}</td>
                                </tr>
                                <tr>
                                    <td>Paid At : </td>
                                    <td>${res.status == 'COMPLETED' ? formatDate(new Date(res.updated_at)) : ''}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    ${res.status != 'COMPLETED' ? barcode : ''}
                    `
                } else {
                    var buttonPay = `
                        <div class="row justify-content-center mb-2">
                            <h3>Barcode</h3>
                        </div>
                        <div class="row justify-content-center mb-4">
                            <div class='col-lg-4 col-md-4 col-sm-4' id='retail_qr'>
                            
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <a class="btn btn-info mr-3" target="_blank" href="{{alfamartQRURL()}}/${res.payment_code}">Generate QR</a>
                        </div>
                    `;
                    var append = `
                    <div class="row">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Transaction ID : </td>
                                    <td>${res.external_id}</td>
                                </tr>
                                <tr>
                                    <td>Merchant Name : </td>
                                    <td>${res.payment_merchant}</td>
                                </tr>
                                <tr>
                                    <td>Topup Amount : </td>
                                    <td>${res.total_topup}</td>
                                </tr>
                                <tr>
                                    <td>Status : </td>
                                    <td>${res.status}</td>
                                </tr>
                                <tr>
                                    <td>Paid At : </td>
                                    <td>${res.status == 'COMPLETED' ? formatDate(new Date(res.updated_at)) : ''}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    ${res.status == 'COMPLETED' ? '' : buttonPay}
                    `
                   
                }
                $("#detail-ewallet-invoice").append(append);
                new QRCode(document.getElementById("retail_qr"), {
                        text: `'${res.payment_code}'`,
                        width: 250,
                        height: 250,
                    });

            }, 
            error: function(err) {
                alert('Terjadi Kesalahan. Silahkan Memuat Ulang Halaman Ini');
            }
        })
    }

    // SHOW INVOICE QRIS
    function showQris(id) {
        var url = "{{route('showTopupHistory', ':id')}}";
        url = url.replace(':id', id);
        $.ajax({
            type: 'GET',
            url: url,
            dataType: 'json',
            success: function(res) {
                var button = `
                    <div class="row justify-content-center mb-2">
                        <h3>QR CODE</h3>
                    </div>
                    <div class="row justify-content-center mb-3" id="qris-qr">
                    </div>
                    <div class="row justify-content-center">
                        <a class="btn btn-info mr-3" onclick="downloadQr('qris-qr')">Download</a>
                    </div>
                `
                $("#detail-qris-invoice").html('');
                $("#detail-qris-invoice").append(`
                    <div class="row">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <td>Transaction ID : </td>
                                    <td>${res.external_id}</td>
                                </tr>
                                <tr>
                                    <td>Merchant Name : </td>
                                    <td>${res.payment_merchant}</td>
                                </tr>
                                <tr>
                                    <td>Topup Amount : </td>
                                    <td>${res.total_topup}</td>
                                </tr>
                                <tr>
                                    <td>Status : </td>
                                    <td>${res.status}</td>
                                </tr>
                                <tr>
                                    <td>Generate Date : </td>
                                    <td>${formatDate(new Date(res.created_at))}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    ${res.status != 'COMPLETED' ? button : ''}
                `);

                new QRCode(document.getElementById("qris-qr"), {
                        text: `'${res.payment_code}'`,
                        width: 250,
                        height: 250,
                    });
            }, 
            error: function(err) {
                alert('Terjadi Kesalahan. Silahkan Memuat Ulang Halaman Ini');
            }
        })
    }
    
    function showBank(id) {
        var url = "{{route('showTopupHistory', ':id')}}";
        url = url.replace(':id', id);
        $.ajax({
            type: 'GET',
            url: url,
            dataType: 'json',
            success: function(res) {
                $("#id_bank").text(res.external_id);
                $("#bank_name").text(res.payment_merchant);
                $("#rek_number").text(res.virtual_account_number);
                $("#topup_dollar").text(res.dollar_topup + ' $');
                $("#topup_bank").text('Rp. ' + numberWithCommas(res.total_topup));
                $("#status_bank").text(res.status);
                $("#media_trans").html('')
                $("#media_trans").append(`
                    <img src="{{asset('uploaded_file/topup')}}/${res.media}" style="width: 100%;" alt="Bukti transaksi" />
                `)
            }, 
            error: function(err) {
                alert('Terjadi Kesalahan. Silahkan Memuat Ulang Halaman Ini');
            }
        })
    }


    // DOWNLOAD QR
    function downloadQr(divId) {
        console.log(divId);
        html2canvas(document.getElementById(divId),		{
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
</script>
@endsection
