@extends('user.master',['menu'=>'setting', 'sub_menu'=>'bank'])
@section('title', isset($title) ? $title : '')
@section('style')
@endsection
@section('content')
<div class="user-management">
  <div class="row">
      <div class="col-12">
        <div class="header-bar">
          <div class="table-title">
            <a class="btn btn-primary text-white" data-toggle="modal" data-target="#add-bank">Add New Bank</a>
          </div>
        </div>
        <div class="table-area">
          <div class="table-responsive">
              <table id="table-bank" class="table table-borderless custom-table display text-center" style="width: 100%;">
                  <thead>
                    <tr>
                        <th scope="col" class="all">{{__('Bank Name')}}</th>
                        <th scope="col" class="desktop">{{__('Account Number')}}</th>
                        <th scope="col" class="desktop">{{__('Holder Name')}}</th>
                        <th scope="col" class="all">{{__('Action')}}</th>
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

{{-- MODAL ADD BANK --}}
<div class="modal fade" id="add-bank" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="add-bank">Add New Bank</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('addNewBank')}}" method="POST">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="bank_name">Bank Name</label>
            <input type="text" name="bank_name" id="bank_name" class="form-control" placeholder="Ex: BCA, BNI, Mandiri, etc" />
          </div>
          <div class="form-group">
            <label for="bank_name">Account Number</label>
            <input type="text" name="account_holder_address" id="account_holder_address" class="form-control" placeholder="Ex: 542XXXXXX (Rek Number)" />
          </div>
          <div class="form-group">
            <label for="bank_name">Account Name</label>
            <input type="text" name="account_holder_name" id="account_holder_name" class="form-control" placeholder="Ex: Rizky Firdaus" />
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
{{-- END --}}


{{-- MODAL ADD BANK --}}
<div class="modal fade" id="bank-update" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Update Bank</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="bank_name">Bank Name</label>
            <input type="text" name="bank_name" id="bank_name_edit" class="form-control" placeholder="Ex: BCA, BNI, Mandiri, etc" />
            <input type="hidden" id="id_edit"/>
          </div>
          <div class="form-group">
            <label for="bank_name">Account Number</label>
            <input type="text" name="account_holder_address_" id="account_holder_address_edit" class="form-control" placeholder="Ex: 542XXXXXX (Rek Number)" />
          </div>
          <div class="form-group">
            <label for="bank_name">Account Name</label>
            <input type="text" name="account_holder_name" id="account_holder_name_edit" class="form-control" placeholder="Ex: Rizky Firdaus" />
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" id="update-bank-btn">Submit</button>
        </div>
    </div>
  </div>
</div>
{{-- END --}}


@endsection

@section('script')
  <script>
    function detailBank(id) {
      var url = "{{route('detailBank',':id')}}"
      url = url.replace(':id', id);
      $.ajax({
          type : 'GET',
          url : url,
          dataType : 'json',
          success : function(res) {
            $("#bank_name_edit").val(res.bank_name);
            $("#account_holder_address_edit").val(res.account_holder_address);
            $("#account_holder_name_edit").val(res.account_holder_name);
            $("#id_edit").val(res.id);
          },
          error : function(err) {
            alert('Terjadi kesalahan. Klik Ok untuk memuat ulang halaman ini');
            window.location.reload();
          }
      })
    }

    $("#update-bank-btn").on('click',function(e) {
      e.preventDefault();
      var bankName    = $("#bank_name_edit").val();
      var rekNumber   = $("#account_holder_address_edit").val();
      var nameHolder  = $("#account_holder_name_edit").val();
      var idBank      = $("#id_edit").val();
      var url         = "{{route('updateBank', ':id')}}"
      url             = url.replace(':id', idBank);
      var form = new FormData();
      form.append('bank_name', bankName);
      form.append('account_holder_address', rekNumber);
      form.append('account_holder_name', nameHolder)
      $.ajax({
        type: 'POST',
        url: url,
        data: form,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(res) {
          alert('Bank Berhasil Diubah. Klik Oke untuk memuat ulang halaman');
          window.location.reload();
        },
        error: function(err) {
          alert('Terjadi Kesalahan. Klik Oke untuk memuat ulang halaman');
          // window.location.reload();
        }
      })
    })

    $(document).ready(() => {
      // TABLE VA
      var table_va = $("#table-bank").DataTable({
            processing: true,
            serverSide: true,
            pageLength: 10,
            retrieve: true,
            bLengthChange: true,
            responsive: true,
            ajax: {
                url : '{{route('bankSetting')}}',
            },
            autoWidth: false,
            language: {
                paginate: {
                    next: 'Next &#8250;',
                    previous: '&#8249; Previous'
                }
            },
            columns: [
                    {"data": "bank_name","orderable": true},
                    {"data": "account_holder_address","orderable": true},
                    {"data": "account_holder_name","orderable": true},
                    {"data": "action","orderable": false},
                ],
        });
    })
    
  </script>
@endsection
