@extends ('backend.layouts.master') @section ('content')
<!-- Small boxes (Stat box) -->
<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Daftar Tunjangan</h3>
              <button style="float:right" class="btn btn-primary" onclick="location.href='{{ url('/admin/allowance/create ')}}'"><i class="icon-plus"><span> Tambah Tunjangan</span></i></button>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered table-striped" id="allowances-data">
                <thead>
                <tr>
                  <th>Tunjangan</th>
                  <th>Besar Tunjangan</th>
                  <th width="15%">Aksi</th>
                </tr>
                </thead>
              </table>
            </div>

            <script type="text/javascript">
            $(function() {
                var oTable = $('#allowances-data').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ url("/admin/data-allowance") }}'
                    },
                    columns: [
                    {data: 'name', name: 'name'},
                    {data: 'price', render: $.fn.dataTable.render.number(',', '.', 2, ''), name: 'price'},
                    {data: 'action', 'searchable': false, 'orderable':false }
                ],
                });
            });
          </script>

            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
@endsection
