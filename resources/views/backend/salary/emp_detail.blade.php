@extends ('backend.layouts.master') @section ('content')
<div class="row">
        <!-- left column -->
        <div class="col-md-9">
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Detail Gaji</h3>
            </div>
                <div class="xs tabls">
                        <div class="bs-example4" data-example-id="contextual-table">
                        <table class="table table-bordered" id="schoolsname-data">
                          <thead>
                             <tr>
                              <td style="font-weight: bold" width="20%">Nama Karyawan</td>
                              <td>{{$salary->employee_name}}</td>
                             </tr>
                             <tr class="active">
                              <td style="font-weight: bold">Total Kehadiran</td>
                              <td>{{$salary->total_presences}}</td>
                             </tr>
                             <tr class="">
                              <td style="font-weight: bold">Total Lembur</td>
                              <td>{{$salary->all_overtime}}</td>
                             </tr>
                             <tr class="active">
                              <td style="font-weight: bold">Gaji Bersih</td>
                              <td>Rp {{number_format($salary->salary,2,",",".")}}</td>
                             </tr>
                             <tr class="">
                              <td style="font-weight: bold">Total Transport</td>
                              <td>Rp {{number_format($salary->total_transport,2,",",".")}}</td>
                             </tr>
                            <tr class="active">
                              <td style="font-weight: bold">Total Lembur</td>
                              <td>Rp {{number_format($salary->total_overtime,2,",",".")}}</td>
                             </tr>
                             <tr class="">
                              <td style="font-weight: bold">Total Gaji</td>
                              <td><b>Rp {{ number_format($salary->total_salary,2,",",".")}}</b></td>
                             </tr>
                          </thead>
                        </table>
                        <div class="box-footer">
                              <button class="btn-default btn" type="reset" onclick="window.location='{{ url('/admin/employeesalary ')}}'">Cancel</button>
                         </div>
                       </div>
                    </div>
                  </div>
        </div>
      </div>
@endsection
