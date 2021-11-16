<div class="header-bar">
  <div class="table-title">
    <h3>Bank Deposit Topup History</h3>
  </div>
  <div class="form-group">
    <label for="status-va">Filter Status</label>
    <select class="form-control status-filter" id="status-bank">
      <option value="">ALL</option>
      <option value="COMPLETED">Complete</option>
      <option value="PENDING">Pending</option>
      <option value="FAILED">Failed</option>
    </select>
  </div>
</div>
<div class="table-area">
  <div class="table-responsive">
      <table id="table-bank" class="table table-borderless custom-table display text-center" style="width: 100%;">
          <thead>
          <tr>
              <th scope="col" class="all">{{__('Transaction ID')}}</th>
              <th scope="col" class="desktop">{{__('Dollar Amount')}}</th>
              <th scope="col" class="desktop">{{__('IDR Total')}}</th>
              <th scope="col" class="all">{{__('User')}}</th>
              <th scope="col" class="desktop">{{__('Total Topup')}}</th>
              <th scope="col" class="all">{{__('Status')}}</th>
              <th scope="col" class="desktop">{{__('Merchant')}}</th>
              <th scope="col" class="desktop">{{__('Account Number')}}</th>
              <th scope="col" class="all">{{__('Action')}}</th>
          </tr>
          </thead>
          <tbody>
          </tbody>
      </table>
  </div>

</div>