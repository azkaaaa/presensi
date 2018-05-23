@extends ('backend.layouts.master') @section ('content')
<!-- Small boxes (Stat box) -->
<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Metode TOPSIS</h3>
              <!-- <button style="float:right" class="btn btn-primary" onclick="location.href='{{ url('/admin/position/create ')}}'"><i class="icon-plus"><span> Tambah Jabatan</span></i></button> -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered table-highlight">
              <thead>
                <tr>
                    <th>Ranking</th>
                    <th>Alternatif</th>
                    <th>Nilai</th>
                  </tr>
                  </thead>
                  <tbody>
              <?php
                for ($i=0;$i<count($hasilrangkingsemua);$i++)
                { 
              ?>
                  <tr>
                    <td><?php echo ($i+1); ?></td>
                    <td><?php echo $alternatifrangkingsemua[$i]; ?></td>
                    <td><?php echo $hasilrangkingsemua[$i]; ?></td>
                  </tr>
              <?php
                }
              ?>
              </tbody>
              </table>
              <br />
              <br />
              <h4 class="heading">Alternatif LokasiTerbaik : </h4><h4 class="heading"><span class="label label-success">  {{ $alternatifrangking }} </span></h4> <h4 class="heading"> Dengan Nilai Terbesar : </h4><h4 class="heading"><span class="label label-success">  {{ $hasilrangking }}</span></h4>
              <br />
            </div>

           

            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
@endsection
