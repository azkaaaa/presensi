@extends ('backend.layouts.master') @section ('content')

<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Metode TOPSIS</h3>
      </div>
      <div class="box-body">
        <form name="form1" method="post" action="{{ url('/manager/topsis/'.$employee->id)}}"><br>
          <input type="hidden" name="_method" value="PUT">
          <input type="hidden" name="_token" value="{{csrf_token()}}">
          <br/>
          <table align="center" class="table table-bordered table-highlight">
            <thead>
              <tr>
                <th id="ignore" bgcolor="#DBEAF5" width="400" colspan="5">
                  <div align="center">
                    <strong>
                      <font size="2" face="Arial, Helvetica, sans-serif">
                        <font size="2">PENILAIAN ALTERNATIF</font> 
                      </font>
                    </strong>
                  </div>
                </th>
              </tr>
            </thead>
            <tbody>    
      
              <tr>
                <td width="30%"> 
                Tanggung Jawab
                </td>
                <td> 
                  <input name="tanggung_jawab" type="radio" value="70"> Sangat Baik<br>
                </td>
                <td> 
                  <input name="tanggung_jawab" type="radio" value="50"> Baik<br>
                </td>
                <td> 
                  <input name="tanggung_jawab" type="radio" value="30"> Cukup Baik<br>
                </td>
                <td> 
                  <input name="tanggung_jawab" type="radio" value="10"> Tidak Baik<br>
                </td>
              </tr>
              <tr>
                <td width="30%"> 
                Kejujuran
                </td>
                <td> 
                  <input name="kejujuran" type="radio" value="70"> Sangat Baik<br>
                </td>
                <td> 
                  <input name="kejujuran" type="radio" value="50"> Baik<br>
                </td>
                <td> 
                  <input name="kejujuran" type="radio" value="30"> Cukup Baik<br>
                </td>
                <td> 
                  <input name="kejujuran" type="radio" value="10"> Tidak Baik<br>
                </td>
              </tr>
              <tr>
                <td width="30%"> 
                Skill
                </td>
                <td> 
                  <input name="skill" type="radio" value="70"> Sangat Baik<br>
                </td>
                <td> 
                  <input name="skill" type="radio" value="50"> Baik<br>
                </td>
                <td> 
                  <input name="skill" type="radio" value="30"> Cukup Baik<br>
                </td>
                <td> 
                  <input name="skill" type="radio" value="10"> Tidak Baik<br>
                </td>
              </tr>
              <tr>
                <td width="30%"> 
                Kerja Sama
                </td>
                <td> 
                  <input name="kerjasama" type="radio" value="70"> Sangat Baik<br>
                </td>
                <td> 
                  <input name="kerjasama" type="radio" value="50"> Baik<br>
                </td>
                <td> 
                  <input name="kerjasama" type="radio" value="30"> Cukup Baik<br>
                </td>
                <td> 
                  <input name="kerjasama" type="radio" value="10"> Tidak Baik<br>
                </td>
              </tr>
              <tr>
                <td> 
                  <input name="id_kriteria_tanggung_jawab" type="hidden" value="{{ $tanggung_jawab->id_kriteria }}"><br>
                  <input name="id_kriteria_kejujuran" type="hidden" value="{{ $kejujuran->id_kriteria }}"><br>
                  <input name="id_kriteria_skill" type="hidden" value="{{ $skill->id_kriteria }}"><br>
                  <input name="id_kriteria_kerjasama" type="hidden" value="{{ $kerjasama->id_kriteria }}"><br>
                </td>
              </tr>
              <tr>
                <td colspan="2">
                  <button type="submit" class="btn btn-primary">Simpan</button>
                </td>
              </tr>
            </tbody>
          </table>
          <br>
        </form>
        <button class="btn-default btn" type="reset" onclick="window.location='{{ url('/manager/topsis/createtopsis')}}'">Penilaian Kuantitatif Kriteria</button>
      </div>
    </div>
    <!-- /.box -->
  </div>
  <!-- /.col -->
</div>
@endsection
