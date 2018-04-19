<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #dddddd;
}
</style>
<table>
  <tr>
    <th style="width: 130px">Karyawan</th>
    <th>Tanggal</th>
    <th>Jam Masuk</th>
    <th>Jam Keluar</th>
    <th>Shift</th>
    <th>Status Kerja</th>
    <th>Ket</th>
    <th>Status Lembur</th>
    <th>Jam Lembur</th>
  </tr>
  @foreach($presences as $row)
  <tr>
    <td>{{ $row->employee_name }}</td>
    <td>{{ date('d M Y', strtotime($row->date)) }}</td>
    <td>{{ $row->time_in }}</td>
    <td>{{ $row->time_out }}</td>
    <td>{{ $row->shift }}</td>
    <td>{{ $row->info }}</td>
    <td>{{ $row->additional }}</td>
    <td>{{ $row->overtime_status }}</td>
    <td>{{ $row->overtime }}</td>
  </tr>
  @endforeach
  <tr>
    <td colspan="8"><center><b>Total Lembur</b></center></td>
    <td><b>{{ $total->total_overtime }} Jam</b></td>
  </tr>
</table>