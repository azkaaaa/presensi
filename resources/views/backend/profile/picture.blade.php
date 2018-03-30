@extends ('backend.layouts.master') @section ('content')
<div class="row">
 	<!-- left column -->
        <div class="col-md-8">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Update Foto Profil</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="POST" action="{{ route('user.changepicture.save') }}" class="form-horizontal" enctype="multipart/form-data">
			  <input type="hidden" name="_method" value="PUT">
              <input type="hidden" name="_token" value="{{csrf_token()}}">
              <div class="box-body">
              	<div class="form-group">
					<label for="inputImage" class="col-sm-2 control-label">Input Image</label>
					<div class="col-sm-8">
						<img src="http://placehold.it/100x100" id="showpicture" style="max-width:200px;max-height:200px;float:left;" />
					</div>
				</div>
                <div class="form-group">
					<label for="inputFile" class="col-sm-2 control-label">Upload Foto</label>
					<div class="col-sm-8">
						<input type="file" class="form-control" id="inputpicture" name="profile_picture">
					</div>
				</div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button class="btn-default btn" type="reset" onclick="window.location='{{ route('user.profile.index')}}'">Kembali</button>
                <!-- <button type="submit" class="btn btn-info pull-right">Sign in</button> -->
                <button type="submit" class="btn btn-primary">Update</button>
              </div>
              <!-- /.box-footer -->
              <!-- @include('backend.layouts.errors'); -->
            </form>
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (right) -->
      </div>

@section('js')
	<script type="text/javascript">

	      function readURL(input) {
	        if (input.files && input.files[0]) {
	            var reader = new FileReader();

	            reader.onload = function (e) {
	                $('#showpicture').attr('src', e.target.result);
	            }

	            reader.readAsDataURL(input.files[0]);
	        }
	    }

	    $("#inputpicture").change(function () {
	        readURL(this);
	    });

	</script>
@stop
@endsection