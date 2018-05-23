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
              <form name="form1" method="get" action="{{ url('admin/result') }}"><br>
              <table align="center" class="table table-bordered table-highlight">
              <thead>
              <tr>
              <th id="ignore" bgcolor="#DBEAF5" width="400" colspan="2"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif"><font size="2">BOBOT KEPENTINGAN KRITERIA</font> </font></strong></div></th></tr></thead>
              <tbody>
                  @foreach($kriteria as $data)       
                <tr>
                  <td width="200"> 

                {{$data->nama_kriteria}} ({{$data->costbenefit}})
                  
                </td>
                <td width="200">

                    <input id="kepentingan{{$data->id_kriteria}}" name="kepentingan{{$data->id_kriteria}} ?>" type="text" value="{{$data->kepentingan}}">

                    </td>
                </tr>
                  @endforeach
                
                </tbody>  
              </table>
              <br/>
               <table align="center" class="table table-bordered table-highlight">
              <thead>
              <tr>
              <th id="ignore" bgcolor="#DBEAF5" width="400" colspan="2"><div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif"><font size="2">PILIH ALTERNATIF</font> </font></strong></div></th></tr></thead>
              <tbody>
              @foreach($alternative as $data)       

                <tr>
                
                  <td width="50"> 
                    <input id="alternatif{{$data->id_alternatif}}" name="alternatif{{$data->id_alternatif}}" type="checkbox" value="true" checked>
                    </td>
                <td width="350"> 
                {{$data->nama_alternatif}}
                </td>
                </tr>
                @endforeach
                <tr>
                  <td colspan="2"><input class="btn btn-success" type="submit" name="button" value="Proses"></td>
                </tr>
                </tbody>
              </table>
              <br>
            </form>
            </div>

           

            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
@endsection
