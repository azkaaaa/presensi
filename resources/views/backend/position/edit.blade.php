@extends ('backend.layouts.master') @section ('content')
 	<div class="row">
 	<!-- left column -->
        <div class="col-md-6">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Form Edit Posisi</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="POST" action="{{ url('/admin/position/'.$position->id)}}" class="form-horizontal">
              <input type="hidden" name="_method" value="PUT">
              <input type="hidden" name="_token" value="{{csrf_token()}}">
              <div class="box-body">
                <div class="form-group {{($errors->has('name')?'has-error':'')}}">
                  <label for="inputName" class="col-sm-2 control-label">Nama Posisi</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Jabatan" name="name" value="{{ $position->name}}">
		           <p class="text-danger">{{$errors->first('name')}}</p>
                  </div>
                </div>
                <div class="form-group {{($errors->has('salary')?'has-error':'')}}">
                  <label for="inputSalary" class="col-sm-2 control-label">Gaji Pokok</label>
                  <div class="col-sm-10">
                    <input type="number" class="form-control" placeholder="Gaji Pokok" name="salary" value="{{ $position->salary}}">
		           <p class="text-danger">{{$errors->first('salary')}}</p>
                  </div>
                </div>
                <div class="form-group {{($errors->has('transport')?'has-error':'')}}">
                  <label for="inputTransport" class="col-sm-2 control-label">Uang Transport</label>
                  <div class="col-sm-10">
                    <input type="number" class="form-control" placeholder="Uang Transport" name="transport" value="{{ $position->salary}}">
               <p class="text-danger">{{$errors->first('transport')}}</p>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button class="btn-default btn" type="reset" onclick="window.location='{{ url('/admin/position')}}'">Kembali</button>
                <!-- <button type="submit" class="btn btn-info pull-right">Sign in</button> -->
                <button type="submit" class="btn btn-primary">Simpan</button>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (right) -->
      </div>
@endsection
