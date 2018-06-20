@extends ('backend.layouts.master') @section ('content')

@if(session()->has('password_incorrect'))
<div class="alert alert-danger" role="alert">
  Password lama yang anda masukan salah.
</div>
@endif

@if(session()->has('password_not_same'))
<div class="alert alert-danger" role="alert">
  Password baru yang anda masukan tidak sama.
</div>
@endif

@if(session()->has('profile_picture_failed'))
<div class="alert alert-danger" role="alert">
  Foto profil anda gagal diperbarui.
</div>
@endif

<div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              @if($employee->profile_picture)
                <img class="profile-user-img img-responsive img-circle" src="{{ URL::asset('admin/uploads/profile_picture/'.$employee->profile_picture) }}" alt="User profile picture">
              @else
                <img class="profile-user-img img-responsive img-circle" src="{{ URL::asset('admin/dist/img/user.png')}}" alt="User profile picture">
              @endif

              <h3 class="profile-username text-center">{{ $employee->name}}</h3>

              <p class="text-muted text-center">{{ $employee->position_name}}</p>

              <ul class="list-group list-group-unbordered">
                <center>
                <li class="list-group-item">{{ date('d M Y', strtotime($employee->birthday)) }}
                </li>
                <li class="list-group-item">{{ $employee->phone}}</li>
                </center>
              </ul>

              <a href="{{ route('user.changepicture.index') }}" class="btn btn-primary btn-block"><b>Ganti Profil</b></a>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- About Me Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">About Me</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <strong><i class="fa fa-map-marker margin-r-5"></i> Alamat</strong>

              <p class="text-muted">{{ $employee->address}}</p>

              <hr>

         <!--      <strong><i class="fa fa-pencil margin-r-5"></i> Skills</strong>

              <p>
                <span class="label label-danger">UI Design</span>
                <span class="label label-success">Coding</span>
                <span class="label label-info">Javascript</span>
                <span class="label label-warning">PHP</span>
                <span class="label label-primary">Node.js</span>
              </p> -->

              <!-- <hr> -->

              <strong><i class="fa fa-file-text-o margin-r-5"></i> Catatan</strong>

              <p class="text-muted">Three Rules of Work:</br>
              1. Out of clutter find simplicity.</br>
              2. From discord find harmony.</br>
              3. In the middle of difficulty lies opportunity.</br></br>
              ― Albert Einstein
              </p>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#profile" data-toggle="tab">Personal Data</a></li>
              <li><a href="#password" data-toggle="tab">Ganti Password</a></li>
              <!-- <li><a href="#settings" data-toggle="tab">Settings</a></li> -->
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="profile">
               <form method="POST" class="form-horizontal" action="{{ url('/user/change/'.$employee->id)}}">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
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
                    <input type="number" class="form-control" placeholder="NIK" name="nik" value="{{ $employee->nik}}" readonly="">
                    <p class="text-danger">{{$errors->first('nik')}}</p>
                  </div>
                </div>
                <div class="form-group {{($errors->has('id_card')?'has-error':'')}}">
                  <label for="inputID" class="col-sm-2 control-label">ID Kartu</label>
                  <div class="col-sm-10">
                    <input type="text" class="form-control" name="id_card" value="{{ $employee->id_card}}" readonly="">
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
                    <label for="level" class="col-md-2 control-label">Jabatan</label>
                    <div class="col-md-10">
                        <select class="form-control" name="position_id">
                              <option value="{{$employee->position_id}}">{{$employee->position_name}}</option>
                              @foreach($position as $data)
                              <option value="{{$data->id}}">{{$data->name}}</option>
                              @endforeach
                        </select>
                        <p class="text-danger">{{$errors->first('position_id')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-10 control-label">
                      <div class="col-sm-10">
                        <label><a style="color: red">*</a>Hubungi admin untuk data yang tidak bisa dirubah</label>
                      </div>
                    </div>
                </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-danger">Ganti</button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="password">
                  <form method="POST" class="form-horizontal" action="{{ route('user.changepassword.save')}}">
                  <input type="hidden" name="_method" value="PUT">
                  <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div class="form-group {{($errors->has('email')?'has-error':'')}}">
                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>
                    <div class="col-sm-10">
                      <input type="email" class="form-control" placeholder="Email" name="email" value="{{ $user->email }}" disabled="">
                      <p class="text-danger">{{$errors->first('email')}}</p>
                    </div>
                  </div>
                  <div class="form-group {{($errors->has('oldpassword')?'has-error':'')}}">
                    <label for="inputPassword" class="col-sm-2 control-label">Password Lama</label>
                    <div class="col-sm-10">
                      <input type="password" class="form-control" placeholder="Password Lama" name="oldpassword">
                      <p class="text-danger">{{$errors->first('oldpassword')}}</p>
                   </div>
                  </div>
                  <div class="form-group {{($errors->has('newpassword')?'has-error':'')}}">
                    <label for="inputNewPassword" class="col-sm-2 control-label">Password Baru</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputNewPassword" placeholder="Password Baru" name="newpassword">
                      <p class="text-danger">{{$errors->first('newpassword')}}</p>
                    </div>
                  </div>
                  <div class="form-group {{($errors->has('confirmpassword')?'has-error':'')}}">
                    <label for="inputRePassword" class="col-sm-2 control-label">Konfirmasi Password</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="inputRePassword" placeholder="Konfirmasi Password" name="confirmpassword">
                      <p class="text-danger">{{$errors->first('confirmpassword')}}</p>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-md-10 control-label">
                      <div class="col-sm-10">
                        <label><a style="color: red">*</a>Hubungi admin untuk data yang tidak bisa dirubah</label>
                      </div>
                    </div>
                </div>
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-danger">Submit</button>
                    </div>
                  </div>
                </form>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
@endsection