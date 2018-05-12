@extends ('backend.layouts.master') @section ('content')
      <!-- /.row -->
      <div class="row">
        <div class="col-xs-12">
        @if(session()->has('salary_found'))
        <div class="alert alert-success" role="alert">
          @lang('alert.salary_found',['name'=>session()->get('salary_found')])
        </div>
        @endif
        @if(session()->has('salary_not_found'))
        <div class="alert alert-danger" role="alert">
          @lang('alert.salary_not_found',['name'=>session()->get('salary_not_found')])
        </div>
        @endif
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Daftar Presensi Sebelumnya</h3>

              <div class="box-tools">
                <div class="input-group input-group-sm">
                    @if (Auth::user()->level == 'Admin')
                    <form method="GET" action="{{route('admin.salary.search')}}" class="form-horizontal">
                    @elseif (Auth::user()->level == 'Manajer')
                    <form method="GET" action="{{route('manager.salary.search')}}" class="form-horizontal">
                    @endif
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
                                    <option value="{{ $row->years }}">{{ $row->years }}</option>
                                    @endforeach
                                    @endif
                              </select>
                            </div>
                    <!-- /.box-body -->
                        <div class="col-md-4">
                          <div class="input-group-btn">
                            <button type="submit" class="btn btn-info">Cari</button>
                          </div>
                          @if (Auth::user()->level == 'Admin')
                          <div class="input-group-btn">
                            <button class="btn-default btn" type="reset" onclick="window.location='{{ route('admin.historysalary.data')}}'">Kembali</button>
                          </div>
                          @elseif (Auth::user()->level == 'Manajer')
                          <div class="input-group-btn">
                            <button class="btn-default btn" type="reset" onclick="window.location='{{ route('manager.historysalary.data')}}'">Kembali</button>
                          </div>
                          @endif
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
                  <th>Total Gaji</th>
                  <th>Status</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <?php $no = 1; ?>
              @if($salary)
              @foreach($salary as $row)
              <tbody>
                <tr>
                  <td>{{$no}}</td>
                  <td>{{ date("F", mktime(0, 0, 0, $row->month, 1)) }}</td>
                  <td>{{ $row->years }}</td>
                  <td>{{ number_format($row->total_all, 2, ',', '.') }}</td>
                  <td><span class="label label-success">Approved</span></td>
                  @if (Auth::user()->level == 'Admin')
                  <td style="width: 20px; float: left"><a href="{{route('admin.printsalary.save', $row->list)}}" class="btn btn-primary" ><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> Print</a></td>
                  @elseif (Auth::user()->level == 'Manajer')
                  <td style="width: 20px; float: left"><a href="{{route('manager.printsalary.save', $row->list)}}" class="btn btn-primary" ><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> Print</a></td>
                  @endif
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
