@extends ('backend.layouts.master') @section ('content')
 	<div class="row">
 	<!-- left column -->
        <div class="col-md-6">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Form Pergantian Libur Karyawan</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="POST" action="{{ url('/admin/schedule/'.$schedule->id)}}" class="form-horizontal">
              <input type="hidden" name="_method" value="PUT">
              <input type="hidden" name="_token" value="{{csrf_token()}}">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputName" class="col-sm-2 control-label">Nama Karyawan</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" value="{{ $schedule->employee_name}}" readonly="">
                  </div>
                </div>
                <div class="form-group">
                  <label for="inputSalary" class="col-sm-2 control-label">Shift</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" value="{{ $schedule->shift_name}}" readonly="">
                  </div>
                </div>
                <div class="form-group {{($errors->has('day_id')?'has-error':'')}}">
                  <label for="inputSalary" class="col-sm-2 control-label">Pergantian Hari</label>
                  <div class="col-sm-10">
                    <select class="form-control" name="day_id">
                         <option value="{{ $schedule->day_name}}">{{ $schedule->day_name}}</option>
                          @if($days)
                          @foreach($days as $row)
                          <option value="{{ $row->id }}">{{ $row->name }}</option>
                          @endforeach
                          @endif
                     </select>
		           <p class="text-danger">{{$errors->first('day_id')}}</p>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button class="btn-default btn" type="reset" onclick="window.location='{{ url('/admin/schedule')}}'">Kembali</button>
                <!-- <button type="submit" class="btn btn-info pull-right">Sign in</button> -->
                <button type="submit" class="btn btn-primary">Edit</button>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (right) -->
      </div>
@endsection
