@extends ('backend.layouts.master') @section ('content')
      <!-- /.row -->
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Daftar Gaji Sebelumnya</h3>

              <div class="box-tools">
                <div class="input-group input-group-sm" style="width: 150px;">
                  <form method="GET" action="{{route('admin.salary.search')}}" class="form-horizontal">
                              <select class="form-control pull-left" name="month">
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
                            
                              <select class="form-control pull-left" name="years">
                                    <option value="2017">2017</option>
                                    <option value="2018">2018</option>
                                    <option value="2019">2019</option>
                              </select>
                    <!-- /.box-body -->
                    <div class="input-group-btn">
                      <button type="submit" class="btn btn-default">Cari</button>
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
                  <td>{{ Carbon\Carbon::parse($row->created_at)->format('F') }}</td>
                  <td>{{ Carbon\Carbon::parse($row->created_at)->format('Y') }}</td>
                  <td>{{ number_format($row->total_all, 2, ',', '.') }}</td>
                  <td><span class="label label-success">Approved</span></td>
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
