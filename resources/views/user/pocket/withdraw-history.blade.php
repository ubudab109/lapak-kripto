@extends('user.master',['menu'=>'pocket', 'sub_menu'=>'withdraw'])
@section('title', 'Withdraw History')
@section('style')
@endsection
@section('content')
<div class="user-management">
  <div class="row">
      <div class="col-12">
        <div class="table-area">
          <div class="table-responsive">
              <table id="table-withdraw" class="table table-borderless custom-table display text-center" style="width: 100%;">
                  <thead>
                    <tr>
                        <th scope="col" class="all">{{__('Transaction ID')}}</th>
                        <th scope="col" class="desktop">{{__('Bank')}}</th>
                        <th scope="col" class="desktop">{{__('Status')}}</th>
                        <th scope="col" class="desktop">{{__('Dollar Amount')}}</th>
                        <th scope="col" class="desktop">{{__('Total Withdraw')}}</th>
                        <th scope="col" class="desktop">{{__('Receipt')}}</th>
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


@endsection

@section('script')
  <script>
    $(document).ready(() => {
      // TABLE VA
      var table_va = $("#table-withdraw").DataTable({
            processing: true,
            serverSide: true,
            pageLength: 10,
            retrieve: true,
            bLengthChange: true,
            responsive: true,
            ajax: {
                url : '{{route('withdrawHistory')}}',
            },
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
                ],
        });
    })
    
  </script>
@endsection
