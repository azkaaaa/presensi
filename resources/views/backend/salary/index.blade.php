@extends ('backend.layouts.master') @section ('content')
<!-- Small boxes (Stat box) -->
<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Daftar Salary</h3>
              <form method="POST" action="{{url('/admin/salary')}}" class="form-horizontal">
              <input type="hidden" name="_token" value="{{csrf_token()}}">
              <!-- /.box-body -->
              <div class="box-footer">
                <!-- <button type="submit" class="btn btn-info pull-right">Sign in</button> -->
                @if($salary)
                <button style="float:right" type="submit" class="btn btn-primary" disabled="">Gaji Bulan Ini Telah Dibuat</button>
                @else
                <button style="float:right" type="submit" class="btn btn-primary">Buat Gaji Bulan Ini</button>
                @endif
              </div>
              <!-- /.box-footer -->
              <!-- @include('backend.layouts.errors'); -->
            </form>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered table-striped" id="salaries-data">
                <thead>
                <tr>
                  <th>Nama Karyawan</th>
                  <th>Gaji Bersih</th>
                  <th>Total Tunjangan</th>
                  <th>Gaji Lembur</th>
                  <th>Total Gaji</th>
                  <th width="23%">Aksi</th>
                </tr>
                </thead>
              </table>
            </div>

            <script type="text/javascript">
            $(function() {
                var oTable = $('#salaries-data').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ url("/admin/data-salary") }}'
                    },
                    columns: [
                    {data: 'name', name: 'employees.name'},
                    {data: 'total_salary', render: $.fn.dataTable.render.number(',', '.', 2, ''), name: 'total_salary'},
                    {data: 'total_allowance', render: $.fn.dataTable.render.number(',', '.', 2, ''), name: 'total_allowance'},
                    {data: 'total_overtime', render: $.fn.dataTable.render.number(',', '.', 2, ''), name: 'total_overtime'},
                    {data: 'total_all', render: $.fn.dataTable.render.number(',', '.', 2, ''), name: 'total_all'},
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
