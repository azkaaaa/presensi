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
                  <th width="18%">Aksi</th>
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

            <script>
              function myFunction() {
                  if(!confirm("Apa anda yakin menghapus data ini"))
                  event.preventDefault();
              }
            </script>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
@endsection
