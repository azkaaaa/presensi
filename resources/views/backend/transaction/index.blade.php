@extends ('backend.layouts.master') @section ('content')
<!-- Small boxes (Stat box) -->
<div class="row">
  <div class="col-xs-12">
    <div class="box">

      <div class="box-header">
        <h3 class="box-title"><b>Daftar Transaksi</b></h3>
      </div>

      <div class="box-body">
        <table class="table table-bordered table-striped" id="transactions-data">
          <thead>
            <tr>
              <th>No. Transaksi</th>
              <th>Total Harga</th>
              <th>User ID</th>
              <th>Status</th>
              <th>Order Date</th>
              <th width="15%">Aksi</th>
            </tr>
          </thead>
        </table>
      </div>

      <script type="text/javascript">
        $(function() {
          var oTable = $('#transactions-data').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
              url: '{{ url("/admin/data-transaction") }}'
            },
            columns: [
              {data: 'transaction_no', name: 'transaction_no'},
              {data: 'total_price', render: $.fn.dataTable.render.number(',', '.', 2, ''), name: 'total_price'},
              {data: 'user_name', name: 'users.name'},
              {data: 'status', name: 'status'},
              {data: 'order_date', name: 'order_date'},
              {data: 'action', 'searchable': false, 'orderable':false }
            ],
          });
        });
      </script>

    </div>
  </div>
</div>
@endsection
