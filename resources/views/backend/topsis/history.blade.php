@extends ('backend.layouts.master') @section ('content')
      <!-- /.row -->
      <div class="row">
        <div class="col-xs-12">
        @if(session()->has('topsis_found'))
        <div class="alert alert-success" role="alert">
          @lang('alert.topsis_found',['name'=>session()->get('topsis_found')])
        </div>
        @endif
        @if(session()->has('topsis_not_found'))
        <div class="alert alert-danger" role="alert">
          @lang('alert.topsis_not_found',['name'=>session()->get('topsis_not_found')])
        </div>
        @endif
          <div class="box" >
            <div class="box-header">
              <h3 class="box-title"><b>Peringkat Karyawan Per Tahun</b></h3>

              <div class="box-tools">
                <div class="input-group input-group-sm">
                  <form method="GET" action="{{route('admin.topsis.search')}}" class="form-horizontal">

                            <div class="col-md-5" >
                              <select class="form-control pull-left" style="width: 100px" name="years">
                                    <option>Tahun</option>
                                    <option value="2017">2017</option>
                                    <option value="2018">2018</option>
                                    <option value="2019">2019</option>
                              </select>
                            </div>
                    <!-- /.box-body -->
                        <div class="col-md-4" style="margin-left: -5%">
                          <div class="input-group-btn">
                            <button type="submit" class="btn btn-info">Cari</button>
                          </div>
                          <div class="input-group-btn">
                            <button class="btn-default btn" type="reset" onclick="window.location='{{ route('admin.historytopsis.data')}}'">Kembali</button>
                          </div>
                      </div>
                  </form>
                </div>
              </div>
            </div>
            <!-- /.box-header -->

            <div class="box-body"  style="width: 50%">
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Tahun</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <?php $no = 1; ?>
              @if($topsis)
              @foreach($topsis as $row)
              <tbody>
                <tr>
                  <td>{{$no}}</td>
                  <td>{{ $row->year }}</td>
                  <td style="width: 20px; float: left"><a href="{{route('admin.printtopsis.save', Carbon\Carbon::parse($row->created_at)->format('Y'))}}" class="btn-sm btn-primary" > Print</a></td>
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
          </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
@endsection
