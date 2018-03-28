@extends ('backend.layouts.master') @section ('content')
<!-- Small boxes (Stat box) -->
<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Daftar Jabatan</h3>
              <button style="float:right" class="btn btn-primary" onclick="location.href='{{ url('/admin/position/create ')}}'"><i class="icon-plus"><span> Tambah Jabatan</span></i></button>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered table-striped" id="positions-data">
                <thead>
                <tr>
                  <th>Nama Jabatan</th>
                  <th>Gaji Pokok</th>
                  <th width="15%">Aksi</th>
                </tr>
                </thead>
              </table>
            </div>

            <script type="text/javascript">
            $(function() {
                var oTable = $('#positions-data').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ url("/admin/data-position") }}'
                    },
                    columns: [
                    {data: 'name', name: 'name'},
                    {data: 'salary', render: $.fn.dataTable.render.number(',', '.', 2, ''), name: 'salary'},
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
