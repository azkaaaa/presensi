@extends ('backend.layouts.master') @section ('content')
<!-- Small boxes (Stat box) -->
<div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Daftar Kriteria</h3>
        <button style="float:right" class="btn btn-primary" onclick="location.href='{{ url('/manager/topsis')}}'"><span> Buat Peringkat Karyawan</span></button>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table class="table table-bordered table-striped" id="kriterias-data">
                <thead>
                <tr>
                  <th>Nama Kriteria</th>
                  <th>Kepentingan</th>
                  <th>Cost Benefit</th>
                  <th width="15%">Aksi</th>
                </tr>
                </thead>

                            @foreach ($kriteria as $items)

                <tr>
                  <td>{{ $items->nama_kriteria }}</td>
                  <td>{{ $items->kepentingan }}</td>
                  <td>{{ $items->costbenefit }}</td>
                  <td width="15%"><a href="{{route('admin.topsiskriteria.edit', $items->id_kriteria)}}" class="btn-sm btn-primary" >Edit</a></td>
                </tr>
                                    @endforeach
              </table>

            </div>

            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
@endsection
