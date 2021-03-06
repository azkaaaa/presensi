@extends ('backend.layouts.master') @section ('content')
<!-- Small boxes (Stat box) -->
<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Daftar Karyawan</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered table-striped" id="employees-data-manager">
                <thead>
                <tr>
                  <th>Nama Karyawan</th>
                  <th>NIK</th>
                  <th>Alamat</th>
                  <th>No Telepon</th>
                  <th>Posisi</th>
                  <th width="10%">Aksi</th>
                </tr>
                </thead>
              </table>
            </div>

            <script type="text/javascript">
            $(function() {
                var oTable = $('#employees-data-manager').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ url("/manager/data-employee-manager") }}'
                    },
                    columns: [
                    {data: 'name', name: 'employees.name'},
                    {data: 'nik', name: 'employees.nik'},
                    {data: 'address', name: 'employees.address'},
                    {data: 'phone', name: 'employees.phone'},
                    {data: 'position_name', name: 'positions.name'},
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
