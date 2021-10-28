@extends('user.master',['menu'=>'coin','sub_menu'=>'buy_coin_history'])
@section('title', isset($title) ? $title : '')
@section('style')
<style>
    
</style>
@endsection
@section('content')
    <div class="row">
        <div class="col-xl-12 mb-xl-0 mb-4">
            <div class="card cp-user-custom-card">
                <div class="card-body">
                    <div class="cp-user-card-header-area">
                        <h4>{{__('Buy Coin History')}}</h4>
                    </div>
                    <div class="cp-user-buy-coin-content-area">
                        <div class="cp-user-wallet-table table-responsive">
                            <table id="table" class="table">
                                <thead>
                                <tr>
                                    <th>{{__('Address')}}</th>
                                    <th>{{__('Coin Amount')}}</th>
                                    <th>{{__('Payment Type')}}</th>
                                    <th>{{__('TXID')}}</th>
                                    <th>{{__('Status')}}</th>
                                    <th>{{__('Created At')}}</th>
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
    <div class="modal fade" id="hash_instruction" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">TXID Instruction</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                  <label for="hash">TX ID</label>
                  <div class="input-group mb-3">
                    <input type="text" readonly class="form-control" id="hash">
                  </div>
              </div>
              <div class="col-lg-12">
                  <ol style="list-style: auto">
                      <li>Silahkan salin TX ID Anda.</li>
                      <li>Anda bisa melihat history transaksi Anda pada Blockchain dengan menyesuaikan coin yang Anda beli.</li>
                      <li>
                        Berikut beberapa website yang Kami rekomendasikan untuk melihat transaksi TXID Anda:
                        <ul>
                            <li><a href="https://blockchair.com/" target="blank">https://blockchair.com/</a> </li>
                            <li><a href="https://btc.com/" target="blank">https://btc.com/</a> </li>
                            <li><a href="https://www.blockchain.com/" target="blank">https://www.blockchain.com/</a> </li>
                        </ul>
                    </li>
                  </ol>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
@endsection

@section('script')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $('#table').DataTable({
            processing: true,
            serverSide: true,
            pageLength: 10,
            retrieve: true,
            bLengthChange: true,
            responsive: true,
            ajax: '{{route('buyCoinHistory')}}',
            order: [4, 'desc'],
            autoWidth: false,
            language: {
                paginate: {
                    next: 'Next &#8250;',
                    previous: '&#8249; Previous'
                }
            },
            columns: [
                {"data": "address","orderable": false},
                {"data": "coin","orderable": false},
                {"data": "type","orderable": true},
                {"data": "transaction","orderable": false},
                {"data": "status","orderable": false},
                {"data": "created_at","orderable": false},
            ],
        });
    </script>
    <script>
        function openHash(id) {
            var hash = $(`#hash-${id}`).data('hash');
            $("#hash").val('');
            $("#hash").val(hash.toString());
        }
    </script>
@endsection
