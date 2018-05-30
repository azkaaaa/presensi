@extends ('backend.layouts.master') @section ('content')
<div class="row">
        <!-- left column -->
        <div class="col-md-9">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Detail Presensi</h3>
            </div>
                <div class="xs tabls">
                        <div class="bs-example4" data-example-id="contextual-table">
                        <table class="table table-bordered" id="schoolsname-data">
                          <thead>
                             <tr>
                              <td style="font-weight: bold" width="20%">Nama Karyawan</td>
                              <td>{{$presence->employee_name}}</td>
                             </tr>
                             <tr class="active">
                              <td style="font-weight: bold">Posisi</td>
                              <td>{{$presence->position_name}}</td>
                             </tr>
                             <tr>
                              <td style="font-weight: bold">Tanggal</td>
                              <td>{{$presence->date}}</td>
                             </tr>
                            <tr class="active">
                              <td style="font-weight: bold">Jam Masuk</td>
                              <td>{{$presence->time_in}}</td>
                             </tr>
                             <tr>
                              <td style="font-weight: bold">Jam Keluar</td>
                              <td>{{$presence->time_out}}</td>
                             </tr>
                             <tr class="active">
                              <td style="font-weight: bold">Shift</td>
                              <td>{{$presence->shift}}</td>
                             </tr>
                             <tr class="">
                              <td style="font-weight: bold">Status Kerja</td>
                              <td>{{$presence->info}}</td>
                             </tr>
                             <tr class="active">
                              <td style="font-weight: bold">Keterangan</td>
                              <td>{{$presence->additional}}</td>
                             </tr>
                             <tr class="">
                              <td style="font-weight: bold">Status Lembur</td>
                              <td>{{$presence->overtime_status}}</td>
                             </tr>
                             <tr class="active">
                              <td style="font-weight: bold">Jam Lembur</td>
                              <td>{{$presence->overtime}}</td>
                             </tr>
                             <tr class="">
                              <td style="font-weight: bold">Webcam</td>
                              <td><img width="100px" src="{{ URL::asset('admin/uploads/presence/'.$presence->capture) }}" alt="User profile picture"></td>
                             </tr>
                          </thead>
                        </table>
                        <div class="box-footer">
                              <button class="btn-default btn" type="reset" onclick="window.location='{{ url('/admin/presence ')}}'">Cancel</button>
                         </div>
                       </div>
                    </div>
                  </div>
        </div>
      </div>
@endsection
