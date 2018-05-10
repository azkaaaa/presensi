<style>
table {
    font-family: arial, sans-serif;
    border-collapse: collapse;
    width: 100%;
    font-size: 12px;
}

td, th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
}

/*tr:nth-child(even) {
    background-color: #dddddd;
}*/
</style>
<table>
            <tr>
                <td colspan="6">
                    <table>
                        <tr>
                            <td><a style="font-weight: bold; font-size: 20px;"><center>Cafe Omboy</a><br>
                                <center>Jalan Boulevard Raya Blok RGA No.1, Jakasetia, Bekasi<br><br>

                                <a style="font-weight: bold;">Penggajian Bulan {{ $month }}</a><br>
                                {{ date('d-m-Y', strtotime($date)) }}<br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
  <tr>
    <th style="width: 130px">Nama Karyawan</th>
    <th>Gaji Pokok</th>
    <th style="width: 30px">Kehadiran</th>
    <th>Transport</th>
    <th>Lembur</th>
    <th>Gaji</th>
  </tr>
  @foreach($salary as $row)
  <tr>
    <td>{{ $row->employee_name }}</td>
    <td>Rp {{ number_format($row->salary, 2, ',', '.') }}</td>
    <td><center>{{ $row->total_presences }}</center></td>
    <td>Rp {{ number_format($row->total_transport, 2, ',', '.') }}</td>
    <td>Rp {{ number_format($row->total_overtime, 2, ',', '.') }}</td>
    <td>Rp {{ number_format($row->total_salary, 2, ',', '.') }}</td>
  </tr>
  @endforeach
  <tr>
    <td colspan="5"><center><b>Total</b></center></td>
    <td><b>Rp {{ number_format($total->total_all, 2, ',', '.') }}</b></td>
  </tr>
</table>