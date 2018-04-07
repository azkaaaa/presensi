@extends ('backend.layouts.master') @section ('content')
 	<div class="row">
 	<!-- left column -->
        <div class="col-md-6">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Form Edit Tunjangan</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="POST" action="{{ url('/admin/allowance/'.$allowance->id)}}" class="form-horizontal">
              <input type="hidden" name="_method" value="PUT">
              <input type="hidden" name="_token" value="{{csrf_token()}}">
              <div class="box-body">
                <div class="form-group {{($errors->has('name')?'has-error':'')}}">
                  <label for="inputName" class="col-sm-2 control-label">Nama Tunjangan</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Tunjangan" name="name" value="{{ $allowance->name}}">
		           <p class="text-danger">{{$errors->first('name')}}</p>
                  </div>
                </div>
                <div class="form-group {{($errors->has('price')?'has-error':'')}}">
                  <label for="inputSalary" class="col-sm-2 control-label">Besar Tunjangan</label>
                  <div class="col-sm-10">
                    <input type="number" class="form-control" placeholder="Besar Tunjangan" name="price" value="{{ $allowance->price}}">
		           <p class="text-danger">{{$errors->first('price')}}</p>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button class="btn-default btn" type="reset" onclick="window.location='{{ url('/admin/allowance')}}'">Kembali</button>
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
