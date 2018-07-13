@extends ('backend.layouts.master') @section ('content')
 	<div class="row">
        <div class="col-xs-12">
 	<!-- left column -->
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Form Edit Kriteria</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="POST" action="{{ url('/manager/topsiskriteria/change/'.$kriteria->id_kriteria)}}" class="form-horizontal">
              <input type="hidden" name="_method" value="PUT">
              <input type="hidden" name="_token" value="{{csrf_token()}}">
              <div class="box-body">
                <div class="form-group {{($errors->has('nama_kriteria')?'has-error':'')}}">
                  <label for="inputName" class="col-sm-2 control-label">Nama Kriteria</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" placeholder="Nama Kriteria" name="nama_kriteria" value="{{ $kriteria->nama_kriteria}}" readonly="">
		           <p class="text-danger">{{$errors->first('nama_kriteria')}}</p>
                  </div>
                </div>
                <div class="form-group {{($errors->has('kepentingan')?'has-error':'')}}">
                  <label for="inputSalary" class="col-sm-2 control-label">Kepentingan</label>
                  <div class="col-sm-6">
                    <input type="number" class="form-control" placeholder="Kepentingan" name="kepentingan" value="{{ $kriteria->kepentingan}}">
		           <p class="text-danger">{{$errors->first('kepentingan')}}</p>
                  </div>
                </div>
                <div class="form-group {{($errors->has('costbenefit')?'has-error':'')}}">
                  <label for="inputTransport" class="col-sm-2 control-label">Cost Benefit</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" placeholder="Cost Benefit" name="costbenefit" value="{{ $kriteria->costbenefit}}" readonly="">
               <p class="text-danger">{{$errors->first('costbenefit')}}</p>
                  </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button class="btn-default btn" type="reset" onclick="window.location='{{ url('/manager/topsiskriteria')}}'">Kembali</button>
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
