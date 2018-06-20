@extends ('backend.layouts.master') @section ('content')
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
            </div>
            <!-- /.box-body -->
          </div>
    </div>
        <!-- left column -->
        <div class="col-md-9">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Detail Karyawan</h3>
            </div>
                <div class="xs tabls">
                        <div class="bs-example4" data-example-id="contextual-table">
                        <table class="table table-bordered" id="schoolsname-data">
                          <thead>
                             <tr>
                              <td style="font-weight: bold" width="20%">NIK</td>
                              <td>{{$employee->nik}}</td>
                             </tr>
                             <tr class="active">
                              <td style="font-weight: bold">ID Card</td>
                              <td>{{$employee->id_card}}</td>
                             </tr>
                             <tr>
                              <td style="font-weight: bold">Email</td>
                              <td>{{$employee->email}}</td>
                             </tr>
                            <tr class="active">
                              <td style="font-weight: bold">Jabatan</td>
                              <td>{{$employee->position_name}}</td>
                             </tr>
                             <tr class="">
                              <td style="font-weight: bold">Alamat</td>
                              <td>{{$employee->address}}</td>
                             </tr>
                             <tr class="active">
                              <td style="font-weight: bold">Nomor Rekening</td>
                              <td>{{$employee->account_number}}</td>
                             </tr>
                             <tr class="">
                              <td style="font-weight: bold">Status</td>
                              @if($employee->status == 1)<td><span class="label label-success">Aktif</span></td>
                              @elseif($employee->status == 0)<td><span class="label label-danger">Tidak Aktif</span></td>
                              @endif
                             </tr>
                          </thead>
                        </table>
                        <div class="box-footer">
                              <button class="btn-default btn" type="reset" onclick="window.location='{{ url('/admin/employee ')}}'">Cancel</button>
                         </div>
                       </div>
                    </div>
                  </div>
        </div>
      </div>
@endsection
