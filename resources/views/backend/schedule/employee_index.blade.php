@extends ('backend.layouts.master') @section ('content')
<!-- Small boxes (Stat box) -->
<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Daftar Jadwal Bulan</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered table-striped" id="schedules-employee-data">
                <thead>
                <tr>
                  <th>Bulan</th>
                  <th>Libur Minggu 1</th>
                  <th>Libur Minggu 2</th>
                  <th>Libur Minggu 3</th>
                  <th>Libur Minggu 4</th>
                  <th>Shift</th>
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
                    {data: 'first_week_name', name: 'days.name'},
                    {data: 'second_week_name', name: 'days.name'},
                    {data: 'third_week_name', name: 'days.name'},
                    {data: 'fourth_week_name', name: 'days.name'},
                    {data: 'shift_name', name: 'shifts.name'},
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
