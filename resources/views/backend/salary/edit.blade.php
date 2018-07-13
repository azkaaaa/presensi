@extends ('backend.layouts.master') @section ('content')
 	<div class="row">
 	<!-- left column -->
        <div class="col-md-6">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Form Tambah Bonus</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="POST" action="{{ url('/admin/salary/'.$salary->id)}}" class="form-horizontal">
              <input type="hidden" name="_method" value="PUT">
              <input type="hidden" name="_token" value="{{csrf_token()}}">
              <div class="box-body">
                <div class="form-group {{($errors->has('employee_name')?'has-error':'')}}">
                  <label for="inputName" class="col-sm-2 control-label">Nama Karyawan</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Jabatan" name="employee_name" value="{{ $salary->employee_name}}" readonly="">
		           <p class="text-danger">{{$errors->first('employee_name')}}</p>
                  </div>
                </div>
                <div class="form-group {{($errors->has('extra')?'has-error':'')}}">
                  <label for="inputSalary" class="col-sm-2 control-label">Jumlah Bonus</label>
                  <div class="col-sm-10">
                    <input type="number" class="form-control" placeholder="Bonus" name="extra">
		           <p class="text-danger">{{$errors->first('extra')}}</p>
                  </div>
                </div>
            
                <input type="hidden" class="form-control" placeholder="Jabatan" name="total_salary" value="{{ $salary->total_salary}}" readonly="">

              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button class="btn-default btn" type="reset" onclick="window.location='{{ url('/admin/employeesalary')}}'">Kembali</button>
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
