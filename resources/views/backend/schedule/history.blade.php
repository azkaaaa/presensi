@extends ('backend.layouts.master') @section ('content')
      <!-- /.row -->
      <div class="row">
        <div class="col-xs-12">
        @if(session()->has('schedule_found'))
        <div class="alert alert-success" role="alert">
          @lang('alert.schedule_found',['name'=>session()->get('schedule_found')])
        </div>
        @endif
        @if(session()->has('schedule_not_found'))
        <div class="alert alert-danger" role="alert">
          @lang('alert.schedule_not_found',['name'=>session()->get('schedule_not_found')])
        </div>
        @endif
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Daftar Jadwal Sebelumnya</h3>

              <div class="box-tools">
                <div class="input-group input-group-sm">
                  <form method="GET" action="{{route('admin.schedule.search')}}" class="form-horizontal">
                    <div class="col-md-3">
                              <select class="form-control pull-left" style="width: 100px" name="month">
                                    <option>Bulan</option>
                                    <option value="1">Januari</option>
                                    <option value="2">Februari</option>
                                    <option value="3">Maret</option>
                                    <option value="4">April</option>
                                    <option value="5">Mei</option>
                                    <option value="6">Juni</option>
                                    <option value="7">Juli</option>
                                    <option value="8">Agustus</option>
                                    <option value="9">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                              </select>
                            </div>
                            <div class="col-md-3">
                              <select class="form-control pull-left" style="width: 100px" name="years">
                                    <option>Tahun</option>
                                    @if($years)
                                    @foreach($years as $row)
                                    <option value="{{ $row->year }}">{{ $row->year }}</option>
                                    @endforeach
                                    @endif
                              </select>
                            </div>
                    <!-- /.box-body -->
                        <div class="col-md-4">
                          <div class="input-group-btn">
                            <button type="submit" class="btn btn-info">Cari</button>
                          </div>
                          <div class="input-group-btn">
                            <button class="btn-default btn" type="reset" onclick="window.location='{{ route('admin.historyschedule.index')}}'">Kembali</button>
                          </div>
                      </div>
                  </form>
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Bulan</th>
                  <th>Tahun</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <?php $no = 1; ?>
              @if($schedule)
              @foreach($schedule as $row)
              <tbody>
                <tr>
                  <td>{{$no}}</td>
                  <td>{{ $row->month_name }}</td>
                  <td>{{ $row->year }}</td>
                  <td style="width: 20px; float: left"><a href="{{route('admin.printsalary.save', $row->list)}}" class="btn btn-primary" ><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> Print</a></td>
                </tr>
                </tbody>
                <?php $no++; ?>
                @endforeach

                @else
                <tr>
                  <td colspan="5"><center>Tidak ada data.</td>
                </tr>
              @endif
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
@endsection
