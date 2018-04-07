@extends ('backend.layouts.master') @section ('content')
<!-- Small boxes (Stat box) -->
<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Daftar Tunjangan Karyawan</h3>
              <button style="float:right" class="btn btn-primary" onclick="location.href='{{ url('/admin/empallowance/create ')}}'"><i class="icon-plus"><span> Tambah Tunjangan Karyawan</span></i></button>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered table-striped" id="empallowances-data">
                <thead>
                <tr>
                  <th>Nama Karyawan</th>
                  <th>Tunjangan</th>
                  <th>Besar Tunjangan</th>
                  <th width="15%">Aksi</th>
                </tr>
                </thead>
              </table>
            </div>

            <script type="text/javascript">
            $(function() {
                var oTable = $('#empallowances-data').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ url("/admin/data-empallowance") }}'
                    },
                    columns: [
                    {data: 'employee_name', name: 'employees.name'},
                    {data: 'allowance_name', name: 'allowances.name'},
                    {data: 'allowance_price', name: 'allowances.price'},
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
