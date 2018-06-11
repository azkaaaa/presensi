@extends ('backend.layouts.master') @section ('content')
<!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            @if($salary)
            <div class="inner">
              <h3>Sudah Dibuat</h3>
              <p>Gaji Bulan Ini</p>
            </div>
            @else
            <div class="inner">
              <h3 style="color: #000000">Belum Dibuat</h3>
              <p>Gaji Bulan Ini</p>
            </div>
            @endif
            <div class="icon">
              <i class="ion ion-cash"></i>
            </div>
            <a href="{{ url('/admin/salary') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            @if($schedule)
            <div class="inner">
              <h3>Sudah Dibuat</h3>
              <p>Jadwal Bulan Ini</p>
            </div>
            @else
            <div class="inner">
              <h3 style="color: #000000">Belum Dibuat</h3>
              <p>Jadwal Bulan Ini</p>
            </div>
            @endif
            <div class="icon">
              <i class="ion ion-calendar"></i>
            </div>
            <a href="{{ url('/admin/schedule') }}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>44</h3>

              <p>User Registrations</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>65</h3>

              <p>Unique Visitors</p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->


      </div>
      <div class="row">
        <div class="col-md-12">
        <div class="box">
        <div id="perf_div"></div>
        @columnchart('Finances', 'perf_div')
      </div>
      </div>
      </div>


      <!-- TABLE: LATEST ORDERS -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Presensi Hari Ini</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="table-responsive">
                <table class="table no-margin">
                  <thead>
                  <tr>
                    <th>Nama Karyawan</th>
                    <th>Jam Masuk</th>
                    <th>Jam Keluar</th>
                    <th>Keterangan</th>
                  </tr>
                  </thead>
                  <tbody>
                  @foreach($presences as $row)
                  <tr>
                    <td>{{ $row->employee_name }}</a></td>
                    <td>{{ $row->time_in }}</td>
                    <td>{{ $row->time_out }}</span></td>
                    @if($row->additional == 'Tepat')
                    <td><span class="label label-success">{{ $row->additional }}</td>
                    @else
                    <td><span class="label label-danger">{{ $row->additional }}</td>
                    @endif
                  </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer clearfix">
              <!-- <a href="javascript:void(0)" class="btn btn-sm btn-info btn-flat pull-left">Place New Order</a> -->
              <a href="{{ url('admin/presence/data') }}" class="btn btn-sm btn-info btn-flat pull-right">Lihat Semua Presensi</a>
            </div>
            <!-- /.box-footer -->
          </div>
@endsection
