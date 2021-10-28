<div class="header-bar">
  <div class="table-title">
    <h3>Retail Transaction History</h3>
  </div>
  <div class="form-group">
    <label for="status-ewallet">Filter Status</label>
    <select class="form-control status-filter" id="status-retail">
      <option value="">ALL</option>
      <option value="COMPLETED">Complete</option>
      <option value="ACTIVE">Active</option>
      <option value="INACTIVE">Inactive</option>
      <option value="SETTLING">In Process</option>
      <option value="PENDING">Pending</option>
      <option value="EXPIRED">Expired</option>
    </select>
  </div>
</div>
<div class="table-area">
  <div class="table-responsive">
      <table id="table-retail" class="table table-borderless custom-table display text-center" style="width: 100%;">
          <thead>
          <tr>
              <th scope="col" class="all">{{__('Transaction ID')}}</th>
              <th scope="col" class="all">{{__('User')}}</th>
              <th scope="col" class="all">{{__('Total Topup')}}</th>
              <th scope="col" class="all">{{__('Status')}}</th>
              <th scope="col" class="all">{{__('Merchant')}}</th>
              <th scope="col" class="all">{{__('Payment Code')}}</th>
              <th scope="col" class="desktop">{{__('Expired At')}}</th>
              <th scope="col" class="all">{{__('Action')}}</th>
          </tr>
          </thead>
          <tbody>
          </tbody>
      </table>
  </div>

</div>