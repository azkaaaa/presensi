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

              <?php
              function tampiltabel($arr)
              {
                echo '<table class="table table-bordered table-highlight">';
                  for ($i=0;$i<count($arr);$i++)
                  {
                  echo '<tr>';
                    for ($j=0;$j<count($arr[$i]);$j++)
                    {
                      echo '<td>'.$arr[$i][$j].'</td>';
                    }
                  echo '</tr>';
                  }
                echo '</table>';
              }

              function tampilbaris($arr)
              {
                echo '<table class="table table-bordered table-highlight">';
                echo '<tr>';
                    for ($i=0;$i<count($arr);$i++)
                    {
                      echo '<td>'.$arr[$i].'</td>';
                    }
                echo "</tr>";
                echo '</table>';
              }

              function tampilkolom($arr)
              {
                echo '<table class="table table-bordered table-highlight">';
                for ($i=0;$i<count($arr);$i++)
                {
                  echo '<tr>';
                      echo '<td >'.$arr[$i].'</td>';
                  echo "</tr>";
                 }
                echo '</table>';
              }

              ?>

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

              <input type="button" class="btn btn-success" value="Perhitungan" onclick="document.getElementById('perhitungan').style.display='block';"/>

              <div id="perhitungan" style="display:none;">
              <br />
              <h4 class="heading">
              Alternatif :
              </h4>
              <?php tampilbaris($alternatif); ?>
              <br />
              <h4 class="heading">
              Kriteria :
              </h4>

              <?php tampilbaris($kriteria); ?>
              <br />
              <h4 class="heading">
              Costbenefit :
              </h4>
              <?php tampilbaris($costbenefit); ?>
              <br />
              <h4 class="heading">
              Kepentingan :
              </h4>
              <?php tampilbaris($kepentingan); ?>
              <br />
              <h4 class="heading">
              Alternatif Kriteria :
              </h4>
              <?php tampiltabel($alternatifkriteria); ?>
              <br />
              <h4 class="heading">
              Pembagi :
              </h4>
              <?php tampilbaris($pembagi); ?>
              <br />
              <h4 class="heading">
              Normalisasi :
              </h4>
              <?php tampiltabel($normalisasi); ?>
              <br />
              <h4 class="heading">
              Terbobot :
              </h4>
              <?php tampiltabel($terbobot); ?>
              <br />
              <h4 class="heading">
              A+ :
              </h4>
              <?php tampilbaris($aplus); ?>
              <br />
              <h4 class="heading">
              A- :
              </h4>
              <?php tampilbaris($amin); ?>
              <br />
              <h4 class="heading">
              D+ :
              </h4>
              <?php tampilkolom($dplus); ?>
              <br />
              <h4 class="heading">
              D- :
              </h4>
              <?php tampilkolom($dmin); ?>
              <br />
              <h4 class="heading">
              Hasil :
              </h4>
              <?php tampilkolom($hasil); ?>
              <br />
              <h4 class="heading">
              Hasil Ranking :
              </h4>
              <?php tampilkolom($hasilrangkingsemua); ?>
              <br />
              <h4 class="heading">
              Alternatif Ranking :
              </h4>
              <?php tampilkolom($alternatifrangking); ?>
              <br />
              </div>

            </div>

           

            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
@endsection
