@extends ('backend.layouts.master') @section ('content')
<!-- Small boxes (Stat box) -->
<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Daftar Schedule</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered table-striped" id="schedules-employee-data">
                <thead>
                <tr>
                  <th>Bulan</th>
                  <th>Minggu</th>
                  <th>Shift</th>
                  <th>Karyawan</th>
                  <th>Libur</th>
                  <th>Status</th>
                </tr>
                </thead>
              </table>
            </div>

            <script type="text/javascript">
            $(function() {
                var oTable = $('#schedules-employee-data').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ url("/employee/data-schedule-employee") }}'
                    },
                    columns: [
                    {data: 'month_name', name: 'months.name'},
                    {data: 'week_name', name: 'weeks.name'},
                    {data: 'shift_name', name: 'shifts.name'},
                    {data: 'employee_name', name: 'employees.name'},
                    {data: 'day_name', name: 'days.name'},
                    {data: 'status', name: 'status'}
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
