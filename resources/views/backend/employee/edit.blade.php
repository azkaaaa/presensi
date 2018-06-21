@extends ('backend.layouts.master') @section ('content')
  <div class="row">
    <!-- @if(!empty($errors->all()))
          <div class="alert alert-danger">
          Error
        </div>
        @endif -->
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Data Diri</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form method="POST" action="{{ url('/admin/employee/'.$employee->id)}}" class="form-horizontal">
             <input type="hidden" name="_method" value="PUT">
              <input type="hidden" name="_token" value="{{csrf_token()}}">
              <div class="box-body">
                <div class="form-group {{($errors->has('name')?'has-error':'')}}">
                  <label for="inputName" class="col-sm-2 control-label">Nama Karyawan</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" placeholder="Karyawan" name="name" value="{{ $employee->name}}">
                    <p class="text-danger">{{$errors->first('name')}}</p>
                  </div>
                </div>
                <div class="form-group {{($errors->has('nik')?'has-error':'')}}">
                  <label for="inputNIK" class="col-sm-2 control-label">NIK</label>
                  <div class="col-sm-10">
                    <input type="number" class="form-control" placeholder="NIK" name="nik" value="{{ $employee->nik}}">
                    <p class="text-danger">{{$errors->first('nik')}}</p>
                  </div>
                </div>
                <div class="form-group {{($errors->has('id_card')?'has-error':'')}}">
                  <label for="inputID" class="col-sm-2 control-label">ID Kartu</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="id_card" value="{{ $employee->id_card}}">
                    <p class="text-danger">{{$errors->first('id_card')}}</p>
                  </div>
                </div>
                <div class="form-group {{($errors->has('birthday')?'has-error':'')}}">
                  <label for="inputBirthday" class="col-sm-2 control-label">Tanggal Lahir</label>
                  <div class="col-sm-10">
                    <input type="date" class="form-control" name="birthday" value="{{ $employee->birthday}}">
                    <p class="text-danger">{{$errors->first('birthday')}}</p>
                  </div>
                </div>
                <div class="form-group {{($errors->has('address')?'has-error':'')}}">
                  <label for="inputAddress" class="col-sm-2 control-label">Alamat</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="address" value="{{$employee->address}}">
                    <p class="text-danger">{{$errors->first('address')}}</p>
                  </div>
                </div>
                <div class="form-group {{($errors->has('phone')?'has-error':'')}}">
                  <label for="inputPhone" class="col-sm-2 control-label">Nomor Telepon</label>
                  <div class="col-sm-10">
                    <input type="number" class="form-control" name="phone" value="{{$employee->phone}}">
                    <p class="text-danger">{{$errors->first('phone')}}</p>
                  </div>
                </div>
                <div class="form-group {{($errors->has('account_number')?'has-error':'')}}">
                  <label for="inputAccount" class="col-sm-2 control-label">Nomor Rekening</label>
                  <div class="col-sm-10">
                    <input type="number" class="form-control" name="account_number" value="{{$employee->account_number}}">
                    <p class="text-danger">{{$errors->first('account_number')}}</p>
                  </div>
                </div>
                <div class="form-group{{ $errors->has('position_id') ? ' has-error' : '' }}">
                    <label for="level" class="col-md-2 control-label">Posisi</label>
                    <div class="col-md-10">
                        <select class="form-control" name="position_id">
                              <option value="{{$employee->position->id}}">{{$employee->position->name}}</option>
                              @foreach($position as $data)
                              <option value="{{$data->id}}">{{$data->name}}</option>
                              @endforeach
                        </select>
                        <p class="text-danger">{{$errors->first('position_id')}}</p>
                    </div>
                </div>
              </div>
              <!-- /.box-body -->

            <!--   <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div> -->
            <!-- </form> -->
          </div>
        </div>
        <!--/.col (left) -->
        <!-- right column -->
        <div class="col-md-6">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Data Login</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <!-- <form class="form-horizontal"> -->
              <div class="box-body">
                <div class="form-group {{($errors->has('email')?'has-error':'')}}">
                  <label for="inputEmail" class="col-sm-2 control-label">Email</label>
                  <div class="col-sm-10">
                    <input type="email" class="form-control" placeholder="Email" name="email" value="{{$user->email}}">
                    <p class="text-danger">{{$errors->first('email')}}</p>
                  </div>
                </div>
                <div class="form-group {{($errors->has('password')?'has-error':'')}}">
                  <label for="inputPassword" class="col-sm-2 control-label">Password</label>
                  <div class="col-sm-10">
                    <input type="password" class="form-control" placeholder="Password" name="password">
                    <p class="text-danger">{{$errors->first('password')}}</p>
                  </div>
                </div>
                <div class="form-group{{ $errors->has('level') ? ' has-error' : '' }}">
                    <label for="level" class="col-md-2 control-label">Level</label>
                    <div class="col-md-10">
                        <select class="form-control" name="level">
                              <option value="{{$employee->user->level}}">{{$employee->user->level}}</option>
                              <option value="Admin">Admin</option>
                              <option value="Karyawan">Karyawan</option>
                              <option value="Manajer">Manajer</option>
                        </select>
                        <p class="text-danger">{{$errors->first('level')}}</p>
                    </div>
                </div>
                <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                    <label for="level" class="col-md-2 control-label">Status</label>
                    <div class="col-md-10">
                        <select class="form-control" name="status">
                              <option value="1">Aktif</option>
                              <option value="0">Tidak Aktif</option>
                        </select>
                        <p class="text-danger">{{$errors->first('status')}}</p>
                    </div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                <button class="btn-default btn" type="reset" onclick="window.location='{{ url('/admin/employee')}}'">Kembali</button>
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
