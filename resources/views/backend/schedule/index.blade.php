@extends ('backend.layouts.master') @section ('content')
<!-- Small boxes (Stat box) -->
<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Daftar Schedule</h3>
              <button style="float:right" class="btn btn-primary" onclick="location.href='{{ url('/admin/schedule/create ')}}'"><i class="icon-plus"><span> Tambah Schedule</span></i></button>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered table-striped" id="schedules-data">
                <thead>
                <tr>
                  <th>Minggu</th>
                  <th>Shift</th>
                  <th>Karyawan</th>
                  <th>Libur</th>
                  <th>Status</th>
                  <th width="15%">Aksi</th>
                </tr>
                </thead>
              </table>
            </div>

            <script type="text/javascript">
            $(function() {
                var oTable = $('#schedules-data').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ url("/admin/data-schedule") }}'
                    },
                    columns: [
                    {data: 'week_name', name: 'weeks.name'},
                    {data: 'shift_name', name: 'shifts.name'},
                    {data: 'employee_name', name: 'employees.name'},
                    {data: 'day_name', name: 'days.name'},
                    {data: 'status', name: 'status'},
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