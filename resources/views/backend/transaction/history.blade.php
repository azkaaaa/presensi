@extends ('backend.layouts.master') @section ('content')
      <!-- /.row -->
      <div class="row">
        <div class="col-xs-12">
        @if(session()->has('transaction_found'))
        <div class="alert alert-success" role="alert">
          @lang('alert.transaction_found',['name'=>session()->get('transaction_found')])
        </div>
        @endif
        @if(session()->has('transaction_not_found'))
        <div class="alert alert-danger" role="alert">
          @lang('alert.transaction_not_found',['name'=>session()->get('transaction_not_found')])
        </div>
        @endif
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Daftar Transaksi</h3>

              <div class="box-tools">
                <div class="input-group input-group-sm">
                  <form method="GET" action="{{route('admin.transaction.search')}}" class="form-horizontal">
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
                                    <option value="2017">2017</option>
                                    <option value="2018">2018</option>
                                    <option value="2019">2019</option>
                              </select>
                            </div>
                    <!-- /.box-body -->
                        <div class="col-md-4">
                          <div class="input-group-btn">
                            <button type="submit" class="btn btn-info">Cari</button>
                          </div>
                          <div class="input-group-btn">
                            <button class="btn-default btn" type="reset" onclick="window.location='{{ route('admin.historytransaction.data')}}'">Kembali</button>
                          </div>
                      </div>
                  </form>
                </div>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <thead>
                <tr>
                  <th>No</th>
                  <th>Bulan</th>
                  <th>Tahun</th>
                  <th>Jumlah Pembayaran</th>
                  <th>Total Pembelian</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <?php $no = 1; ?>
              @if($transaction)
              @foreach($transaction as $row)
              <tbody>
                <tr>
                  <td>{{$no}}</td>
                  <td>{{ Carbon\Carbon::parse($row->order_date)->format('F') }}</td>
                  <td>{{ Carbon\Carbon::parse($row->order_date)->format('Y') }}</td>
                  <td>Rp{{ number_format($row->total_all, 2, ',', '.') }}</td>
                  <td>{{ $total_transaction->total_trans }}</td>
                  <td style="width: 20px; float: left"><a href="{{route('admin.printtransaction.save', Carbon\Carbon::parse($row->order_date)->format('m-Y'))}}" class="btn-sm btn-primary" >Print</a></td>
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
