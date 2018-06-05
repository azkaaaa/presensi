@extends ('backend.layouts.master') @section ('content')
 	<div class="row">
 	<!-- left column -->
        <div class="col-md-8">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Form Schedule</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="POST" action="{{url('/admin/schedule')}}" class="form-horizontal">
			       <input type="hidden" name="_token" value="{{csrf_token()}}">
              <div class="box-body">
                <div class="form-group {{($errors->has('month')?'has-error':'')}}">
                  <label for="inputName" class="col-sm-2 control-label">Jadwal Bulan</label>

                  <div class="col-sm-10">
                    <select class="form-control pull-left" style="width: 200px" name="month">
                              @foreach($month as $data)
                                <option value="{{$data->id}}">{{$data->name}}</option>
                              @endforeach
                              </select>
                    <p class="text-danger">{{$errors->first('month')}}</p>
                  </div>
                  </div>
                  <!-- <div class="form-group {{($errors->has('schedule_week')?'has-error':'')}}">
                  <label for="inputName" class="col-sm-2 control-label">Jadwal Minggu</label>
                  <div class="col-sm-10">
                    <select class="form-control pull-left" style="width: 300px" name="schedule_week">
                                <option value="week_12">Minggu Pertama dan Kedua</option>
                                <option value="week_34">Minggu Ketiga dan Keempat</option>
                              </select>
                    <p class="text-danger">{{$errors->first('schedule_week')}}</p>
                  </div>

                </div> -->
                <div class="form-group {{($errors->has('jumlah_populasi')?'has-error':'')}}">
                  <label for="inputName" class="col-sm-2 control-label">Jumlah Populasi</label>

                  <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Jumlah Populasi" name="jumlah_populasi" value="10">
		                <p class="text-danger">{{$errors->first('jumlah_populasi')}}</p>
                  </div>
                </div>
                <div class="form-group {{($errors->has('probabilitas_crossover')?'has-error':'')}}">
                  <label for="inputSalary" class="col-sm-2 control-label">Probabilitas Crossover</label>

                  <div class="col-sm-10">
                    <input type="number" class="form-control" placeholder="Probabilitas Crossover" name="probabilitas_crossover" value="0.70">
		                <p class="text-danger">{{$errors->first('probabilitas_crossover')}}</p>
                  </div>
                </div>
                <div class="form-group {{($errors->has('probabilitas_mutasi')?'has-error':'')}}">
                  <label for="inputTransport" class="col-sm-2 control-label">Probabilitas Mutasi</label>

                  <div class="col-sm-10">
                    <input type="number" class="form-control" placeholder="Probabilitas Mutasi" name="probabilitas_mutasi" value="0.40">
                    <p class="text-danger">{{$errors->first('probabilitas_mutasi')}}</p>
                  </div>
                </div>
                <div class="form-group {{($errors->has('jumlah_generasi')?'has-error':'')}}">
                  <label for="inputTransport" class="col-sm-2 control-label">Jumlah Generasi</label>

                  <div class="col-sm-10">
                    <input type="number" class="form-control" placeholder="Jumlah Generasi" name="jumlah_generasi" value="10000">
                    <p class="text-danger">{{$errors->first('jumlah_generasi')}}</p>
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
