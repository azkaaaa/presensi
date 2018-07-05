@extends ('backend.layouts.master') @section ('content')
 	<div class="row">
 	<!-- left column -->
        <div class="col-xs-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Form TOPSIS</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="POST" action="{{url('/admin/topsis')}}" class="form-horizontal">
			       <input type="hidden" name="_token" value="{{csrf_token()}}">
              <div class="box-body">

                  <div class="form-group {{($errors->has('year')?'has-error':'')}}">
                  <label for="inputYear" class="col-sm-2 control-label">Perhitungan</label>
                  <!-- div class="col-sm-10">
                    <select class="form-control pull-left" style="width: 300px" name="year">
                                <option value="2017">2017</option>
                                <option value="2018">2018</option>
                              </select>
                    <p class="text-danger">{{$errors->first('year')}}</p>
                  </div> -->
                  <div class="col-sm-10">
                    <select class="form-control pull-left" style="width: 100px" name="month">
                                    <option>Bulan</option>
                                    <option value="01">Januari</option>
                                    <option value="02">Februari</option>
                                    <option value="03">Maret</option>
                                    <option value="04">April</option>
                                    <option value="05">Mei</option>
                                    <option value="06">Juni</option>
                                    <option value="07">Juli</option>
                                    <option value="08">Agustus</option>
                                    <option value="09">September</option>
                                    <option value="10">Oktober</option>
                                    <option value="11">November</option>
                                    <option value="12">Desember</option>
                              </select>
                    <p class="text-danger">{{$errors->first('month')}}</p>
                  </div>
                </div>  
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button class="btn-default btn" type="reset" onclick="window.location='{{ url('/admin/schedule')}}'">Kembali</button>
                <!-- <button type="submit" class="btn btn-info pull-right">Sign in</button> -->
                <button type="submit" class="btn btn-primary">Simpan</button>
              </div>
              <!-- /.box-footer -->
              <!-- @include('backend.layouts.errors'); -->
            </form>
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (right) -->
      </div>
@endsection