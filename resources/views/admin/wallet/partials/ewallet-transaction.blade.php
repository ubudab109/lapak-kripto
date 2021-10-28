<div class="header-bar">
  <div class="table-title">
    <h3>Ewallet Transaction History</h3>
  </div>
  <div class="form-group">
    <label for="status-ewallet">Filter Status</label>
    <select class="form-control status-filter" id="status-ewallet">
      <option value="">ALL</option>
      <option value="SUCCEEDED">Success</option>
      <option value="PENDING">Pending</option>
      <option value="FAILED">Failed</option>
    </select>
  </div>
</div>
<div class="table-area">
  <div class="table-responsive">
      <table id="table-ewallet" class="table table-borderless custom-table display text-center" style="width: 100%;">
          <thead>
          <tr>
              <th scope="col" class="all">{{__('Transaction ID')}}</th>
              <th scope="col" class="all">{{__('User')}}</th>
              <th scope="col" class="all">{{__('Total Topup')}}</th>
              <th scope="col" class="all">{{__('Status')}}</th>
              <th scope="col" class="all">{{__('Merchant')}}</th>
              <th scope="col" class="all">{{__('Action')}}</th>
          </tr>
          </thead>
          <tbody>
          </tbody>
      </table>
  </div>

</div>