@extends('admin.master',['menu'=>'transaction', 'sub_menu'=>'transaction_withdrawal'])
@section('title', isset($title) ? $title : '')
@section('style')
@endsection
@section('content')
    <!-- breadcrumb -->
    <div class="custom-breadcrumb">
        <div class="row">
            <div class="col-12">
                <ul>
                    <li>{{__('Transaction History')}} </li>
                    <li class="active-item">{{__('Withdrawal History')}}</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /breadcrumb -->

    <!-- User Management -->
    <div class="user-management wallet-transaction-area">
        <div class="row">
            <div class="col-12">

                <div class="header-bar">
                    <ul class="nav wallet-transaction user-management-nav mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-deposit-tab" data-toggle="pill" href="#pills-deposit"
                               role="tab" aria-controls="pills-deposit" aria-selected="true">
                                {{__('Pending Withdrawal List')}}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-withdraw-tab" data-toggle="pill" href="#pills-withdraw"
                               role="tab" aria-controls="pills-withdraw" aria-selected="true">
                                {{__('Rejected Withdrawal List')}}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-success-withdraw-tab" data-toggle="pill"
                               href="#pills-success-withdraw" role="tab" aria-controls="pills-success-withdraw"
                               aria-selected="true">
                                {{__('Accepted Withdrawal List')}}
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-deposit" role="tabpanel"
                             aria-labelledby="pills-deposit-tab">
                            <div class="table-area">
                                <div class="table-responsive">
                                    <table id="table" class="table table-borderless custom-table display text-center"
                                           width="100%">
                                        <thead>
                                        <tr>
                                            <th scope="col" class="all">{{__('Transaction ID')}}</th>
                                            <th scope="col" class="all">{{__('Bank')}}</th>
                                            <th scope="col" class="all">{{__('Status')}}</th>
                                            <th scope="col" class="all">{{__('Dollar Amount')}}</th>
                                            <th scope="col" class="all">{{__('Total Withdraw')}}</th>
                                            <th scope="col" class="all">{{__('Receipt')}}</th>
                                            <th scope="col" class="all">{{__('Actions')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-withdraw" role="tabpanel"
                             aria-labelledby="pills-withdraw-tab">
                            <div class="table-area">
                                <div class="table-responsive">
                                    <table id="reject-withdrawal"
                                           class="table table-borderless custom-table display text-left" width="100%">
                                        <thead>
                                        <tr>
                                            <th scope="col" class="all">{{__('Transaction ID')}}</th>
                                            <th scope="col" class="all">{{__('Bank')}}</th>
                                            <th scope="col" class="all">{{__('Status')}}</th>
                                            <th scope="col" class="all">{{__('Dollar Amount')}}</th>
                                            <th scope="col" class="all">{{__('Total Withdraw')}}</th>
                                            <th scope="col" class="all">{{__('Receipt')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-success-withdraw" role="tabpanel"
                             aria-labelledby="pills-success-withdraw-tab">
                            <div class="table-area">
                                <div class="table-responsive">
                                    <table id="success-withdrawal"
                                           class="table table-borderless custom-table display text-left" width="100%">
                                        <thead>
                                        <tr>
                                            <th scope="col" class="all">{{__('Transaction ID')}}</th>
                                            <th scope="col" class="all">{{__('Bank')}}</th>
                                            <th scope="col" class="all">{{__('Status')}}</th>
                                            <th scope="col" class="all">{{__('Dollar Amount')}}</th>
                                            <th scope="col" class="all">{{__('Total Withdraw')}}</th>
                                            <th scope="col" class="all">{{__('Receipt')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="accept_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Accept Payment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body text-white">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="form-group buy_coin_address_input mt-4">
                            <div class="uplode-catagory">
                                <h5 class="modal-title" id="exampleModalLongTitle">{{__('Upload Proof of Transaction')}}</h5>
                                <span></span>
                            </div>
                            <div id="file-upload" class="section-p">
                                <input type="hidden" name="admin_approval_picture_id" value="">
                                <input type="file" placeholder="0.00" name="admin_approval_picture" value="" id="file" ref="file" class="dropify" data-default-file="{{asset('assets/img/placeholder-image.png')}}" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="submit-wd">Submit</button>
            </div>
            </div>
        </div>
    </div>
    <!-- /User Management -->
@endsection

@section('script')
    <script>
        $('#table').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 25,
            responsive: false,
            ajax: '{{route('adminPendingWithdrawal')}}',
            autoWidth: false,
            language: {
                paginate: {
                    next: 'Next &#8250;',
                    previous: '&#8249; Previous'
                }
            },
            columns: [
                {"data": "transaction_id","orderable": true},
                {"data": "bank","orderable": false},
                {"data": "status","orderable": true},
                {"data": "dollar_amount","orderable": true},
                {"data": "total_wd","orderable": false},
                {"data": "media","orderable": false},
                {"data": "actions"}
            ]
        });
    </script>
    <script>
        $('#reject-withdrawal').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 25,
            responsive: false,
            ajax: '{{route('adminRejectedWithdrawal')}}',
            autoWidth: false,
            language: {
                paginate: {
                    next: 'Next &#8250;',
                    previous: '&#8249; Previous'
                }
            },
            columns: [
                {"data": "transaction_id","orderable": true},
                {"data": "bank","orderable": false},
                {"data": "status","orderable": true},
                {"data": "dollar_amount","orderable": true},
                {"data": "total_wd","orderable": false},
                {"data": "media","orderable": false},
            ]
        });
    </script>
    <script>
        $('#success-withdrawal').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 25,
            responsive: false,
            ajax: '{{route('adminActiveWithdrawal')}}',
            autoWidth: false,
            language: {
                paginate: {
                    next: 'Next &#8250;',
                    previous: '&#8249; Previous'
                }
            },
            columns: [
                {"data": "transaction_id","orderable": true},
                {"data": "bank","orderable": false},
                {"data": "status","orderable": true},
                {"data": "dollar_amount","orderable": true},
                {"data": "total_wd","orderable": false},
                {"data": "media","orderable": false},
            ]
        });
    </script>
    <script>
        function approveWd(id)
        {   
            var url = "{{route('acceptWithdraw', ':id')}}"
            url = url.replace(':id', id)
            var file = $("#file").prop('files')[0];
            var form = new FormData();
            form.append('admin_approval_picture',file);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: url,
                dataType: 'json',
                processData: false,
                contentType: false,
                data: form,
                success: function(res) {
                    alert('Status Withdraw Berhasil Disetujui!');
                    window.location.reload();
                },
                error: function(err) {
                    alert('Harap Periksa Semua Form')
                }
            })
        }
        function openModalAccept(transId) {
            $("#submit-wd").on('click', function() {
                approveWd(transId)
            })
        }
    </script>
@endsection
