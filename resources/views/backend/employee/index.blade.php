@extends ('backend.layouts.master') @section ('content')
<!-- Small boxes (Stat box) -->
<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Daftar Karyawan</h3>
              <button style="float:right" class="btn btn-primary" onclick="location.href='{{ url('/admin/employee/create ')}}'"><i class="icon-plus"><span> Tambah Karyawan</span></i></button>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered table-striped" id="employees-data">
                <thead>
                <tr>
                  <th>Nama Karyawan</th>
                  <th>NIK</th>
                  <th>Alamat</th>
                  <th>No Telepon</th>
                  <th>Jabatan</th>
                  <th width="23%">Aksi</th>
                </tr>
                </thead>
              </table>
            </div>

            <script type="text/javascript">
            $(function() {
                var oTable = $('#employees-data').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ url("/admin/data-employee") }}'
                    },
                    columns: [
                    {data: 'name', name: 'name'},
                    {data: 'nik', name: 'nik'},
                    {data: 'address', name: 'address'},
                    {data: 'phone', name: 'phone'},
                    {data: 'position_id', name: 'position_id'},
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
