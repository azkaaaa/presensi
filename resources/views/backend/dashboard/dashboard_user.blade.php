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
            @if($spk)
            <div class="inner">
              <h3>Sudah Dibuat</h3>
              <p>SPK Bulan Ini</p>
            </div>
            @else
            <div class="inner">
              <h3 style="color: #000000">Belum Dibuat</h3>
              <p>SPK Bulan Ini</p>
            </div>
            @endif
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
            @if($total_transaction)
            <div class="inner">
              <h3>Rp {{ number_format($total_transaction->total_all ,2, ',' , '.')  }}</h3>
              <p>Total Transaksi Bulan Ini</p>
            </div>
            @else
            <div class="inner">
              <h3 style="color: #000000">0</h3>
              <p>Total Transaksi Bulan Ini</p>
            </div>
            @endif
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

      <div class="row">
        <div class="col-md-12">
        <div class="box">
        <div id="trans_div"></div>
@columnchart('Transaction', 'trans_div')
      </div>
      </div>
      </div>


   
@endsection