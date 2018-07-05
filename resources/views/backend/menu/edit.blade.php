@extends ('backend.layouts.master') 

@section ('content')
<div class="row">
  <div class="col-md-11">
    <div class="box box-info">

      <div class="box-header with-border">
        <h3 class="box-title"><b>Form Edit Makanan</b></h3>
      </div>

      <form method="POST" action="{{ url('/admin/menu/'.$menu->id)}}" class="form-horizontal" enctype="multipart/form-data">
        <input type="hidden" name="_method" value="PUT">
        <input type="hidden" name="_token" value="{{csrf_token()}}">

        <div class="box-body">
          <div class="form-group {{($errors->has('name')?'has-error':'')}}">
            <label for="inputName" class="col-sm-2 control-label">Nama Menu</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" placeholder="Nama Menu" name="name" value="{{ $menu->name}}">
              <p class="text-danger">{{$errors->first('name')}}</p>
            </div>
          </div>

          <div class="form-group {{($errors->has('price')?'has-error':'')}}">
            <label for="inputPrice" class="col-sm-2 control-label">Harga</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" placeholder="Harga" name="price" value="{{ $menu->price}}">
              <p class="text-danger">{{$errors->first('price')}}</p>
            </div>
          </div>

          <div class="form-group {{($errors->has('type')?'has-error':'')}}">
            <label for="level" class="col-md-2 control-label">Jenis Menu</label>
            <div class="col-md-10">
              <select class="form-control" name="type">
                <option value="{{ $menu->type}}">{{ $menu->type}}</option>
                <option value="" disabled="">-----</option>
                <option value="Makanan">Makanan</option>
                <option value="Minuman">Minuman</option>
              </select>
              <p class="text-danger">{{$errors->first('type')}}</p>
            </div>
          </div>

          <div class="form-group {{($errors->has('status')?'has-error':'')}}">
            <label for="level" class="col-md-2 control-label">Status</label>
            <div class="col-md-10">
              <select class="form-control" name="status">
                <option value="{{ $menu->status}}">{{ $menu->status}}</option>
                <option value="" disabled="">-----</option>
                <option value="Aktif">Aktif</option>
                <option value="Tidak Aktif">Tidak Aktif</option>
              </select>
              <p class="text-danger">{{$errors->first('status')}}</p>
            </div>
          </div>

          <div class="form-group {{($errors->has('desc')?'has-error':'')}}">
            <label for="inputDesc" class="col-sm-2 control-label">Deskripsi</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" placeholder="Deskripsi" name="desc" value="{{ $menu->desc}}">
              <p class="text-danger">{{$errors->first('desc')}}</p>
            </div>
          </div>
        </div>

        <div class="box-footer">
          <button class="btn-default btn" type="reset" onclick="window.location='{{ url('/admin/menu')}}'">
            Kembali
          </button>

          <button type="submit" class="btn btn-primary">
            Simpan
          </button>
        </div>

      </form>
    </div>
  </div>
</div>
@endsection
