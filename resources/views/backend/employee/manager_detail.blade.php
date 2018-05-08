@extends ('backend.layouts.master') @section ('content')
 	<div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Detail Karyawan</h3>
            </div>
                <div class="xs tabls">
                        <div class="bs-example4" data-example-id="contextual-table">
                        <table class="table table-bordered" id="schoolsname-data">
                          <thead>
                            <tr class="active">
                              <td style="font-weight: bold" width="20%">Nama Karyawan</td>
                              <td>{{$employee->name}}</td>
                             </tr>
                             <tr>
                              <td style="font-weight: bold">NIK</td>
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
                             <tr>
                              <td style="font-weight: bold">Tanggal Lahir</td>
                              <td>{{$employee->birthday}}</td>
                             </tr>
                             <tr class="">
                              <td style="font-weight: bold">Agama</td>
                              <td>{{$employee->religion}}</td>
                             </tr>
                             <tr class="active">
                              <td style="font-weight: bold">Alamat</td>
                              <td>{{$employee->address}}</td>
                             </tr>
                             <tr class="">
                              <td style="font-weight: bold">Nomor Telepon</td>
                              <td>{{$employee->phone}}</td>
                             </tr>
                             <tr class="active">
                              <td style="font-weight: bold">Pendidikan Terakhir</td>
                              <td>{{$employee->education}}</td>
                             </tr>
                             <tr class="">
                              <td style="font-weight: bold">Nomor Rekening</td>
                              <td>{{$employee->account_number}}</td>
                             </tr>
                          </thead>
                        </table>
                        <div class="box-footer">
                              <button class="btn-default btn" type="reset" onclick="window.location='{{ url('/manager/employee ')}}'">Cancel</button>
                         </div>
                       </div>
                    </div>
                  </div>
        </div>
      </div>
@endsection
