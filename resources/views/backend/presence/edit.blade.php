@extends ('backend.layouts.master') @section ('content')
 	<div class="row">
 	<!-- left column -->
        <div class="col-md-6">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Form Perijinan Lembur Karyawan</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="POST" action="{{ url('/admin/presence/'.$presence->id)}}" class="form-horizontal">
              <input type="hidden" name="_method" value="PUT">
              <input type="hidden" name="_token" value="{{csrf_token()}}">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputName" class="col-sm-2 control-label">Nama Karyawan</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" value="{{ $employee->name}}" readonly="">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputSalary" class="col-sm-2 control-label">Jabatan</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" value="{{ $position->name}}" readonly="">
                  </div>
                </div>
                <div class="form-group {{($errors->has('overtime')?'has-error':'')}}">
                  <label for="inputSalary" class="col-sm-2 control-label">Jam Lembur</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="overtime">
                         <option value="1">1</option>
                         <option value="2">2</option>
                         <option value="3">3</option>
                     </select>
		           <p class="text-danger">{{$errors->first('overtime')}}</p>
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
