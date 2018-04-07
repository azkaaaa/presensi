@extends ('backend.layouts.master') @section ('content')
 	<div class="row">
 	<!-- left column -->
        <div class="col-md-6">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Form Edit Tunjangan Karyawan</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="POST" action="{{ url('/admin/empallowance/'.$employee_allowance->id)}}" class="form-horizontal">
              <input type="hidden" name="_method" value="PUT">
              <input type="hidden" name="_token" value="{{csrf_token()}}">
              <div class="box-body">
                <div class="form-group{{ $errors->has('employee_id') ? ' has-error' : '' }}">
                    <label for="level" class="col-md-2 control-label">Karyawan</label>
                    <div class="col-md-10">
                        <select class="form-control" name="employee_id">
                              <option value="{{$employee_allowance->employee->id}}">{{$employee_allowance->employee->name}}</option>
                              @foreach($employee as $data)
                              <option value="{{$data->id}}">{{$data->name}}</option>
                              @endforeach
                        </select>
                        <p class="text-danger">{{$errors->first('employee_id')}}</p>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('allowance_id') ? ' has-error' : '' }}">
                    <label for="level" class="col-md-2 control-label">Tunjangan</label>
                    <div class="col-md-10">
                        <select class="form-control" name="allowance_id">
                              <option value="{{$employee_allowance->allowance->id}}">{{$employee_allowance->allowance->name}}</option>
                              @foreach($allowance as $data)
                              <option value="{{$data->id}}">{{$data->name}}</option>
                              @endforeach
                        </select>
                        <p class="text-danger">{{$errors->first('allowance_id')}}</p>
                    </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button class="btn-default btn" type="reset" onclick="window.location='{{ url('/admin/empallowance')}}'">Kembali</button>
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
