@extends ('backend.layouts.master') @section ('content')
<!-- Small boxes (Stat box) -->
<div class="row">
  <div class="col-xs-12">
    <div class="box">

      <div class="box-header">
        <h3 class="box-title"><b>Daftar Menu Makanan</b></h3>
        <button style="float:right" class="btn btn-primary" onclick="location.href='{{ url('/admin/menu/create ')}}'"><span> Tambah Makanan</span></button>
      </div>

      <div class="box-body">
        <table class="table table-bordered table-striped" id="menus-data">
          <thead>
            <tr>
              <th>Nama Makanan</th>
              <th>Harga</th>
              <th>Jenis Makanan</th>
              <th>Status</th>
              <th>Desc</th>
              <th style="width: 11%">Aksi</th>
            </tr>
          </thead>
        </table>
      </div>

      <script type="text/javascript">
        $(function() {
          var oTable = $('#menus-data').DataTable({
            processing: true,
            serverSide: true,

            ajax: {
              url: '{{ url("/admin/data-menu") }}'
            },

            columns: [
              {data: 'name', name: 'name'},
              {data: 'price', render: $.fn.dataTable.render.number('.', ',', 2, ''), name: 'price'},
              {data: 'type', name: 'type'},
              {data: 'status', name: 'status'},
              {data: 'desc', name: 'desc'},
              {data: 'action', 'searchable': false, 'orderable':false }
            ],
          });
        });
      </script>

      <script>
            function myFunction() {
                if(!confirm("Apa anda yakin menghapus data ini"))
                event.preventDefault();
            }
          </script>

    </div>
  </div>
</div>
@endsection
