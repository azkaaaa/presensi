@extends ('backend.layouts.master') @section ('content')
<!-- Small boxes (Stat box) -->
<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Daftar Presensi Bulan {{ $dt->format('F') }}</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered table-striped" id="presences-employee-data">
                <thead>
                <tr>
                  <th width="160px">Nama Karyawan</th>
                  <th>Posisi</th>
                  <th>Tanggal</th>
                  <th>Jam Masuk</th>
                  <th>Jam Keluar</th>
                  <th>Shift</th>
                  <th>Status Kerja</th>
                  <th>Keterangan</th>
                  <th>Status Lembur</th>
                  <th>Jam Lembur</th>
                </tr>
                </thead>
              </table>
            </div>

            <script type="text/javascript">
            $(function() {
                var oTable = $('#presences-employee-data').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ url("/employee/data-presence-employee") }}'
                    },
                    columns: [
                    {data: 'employee_name', name: 'employees.name'},
                    {data: 'position_name', name: 'positions.name'},
                    {data: 'date', name: 'presences.date'},
                    {data: 'time_in', name: 'presences.time_in'},
                    {data: 'time_out', name: 'presences.time_out'},
                    {data: 'shift', name: 'presences.shift'},
                    {data: 'info', name: 'presences.info'},
                    {data: 'additional', name: 'presences.additional'},
                    {data: 'overtime_status', name: 'presences.overtime_status'},
                    {data: 'overtime', name: 'presences.overtime'}
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
