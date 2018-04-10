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
    <th>Nama Karyawan</th>
    <th>Gaji Pokok</th>
    <th>Total Tunjangan</th>
    <th>Total Lembur</th>
    <th>Total Gaji</th>
  </tr>
  @foreach($salary as $row)
  <tr>
    <td>{{ $row->employee_name }}</td>
    <td>Rp {{ number_format($row->salary, 2, ',', '.') }}</td>
    <td>Rp {{ number_format($row->total_allowance, 2, ',', '.') }}</td>
    <td>Rp {{ number_format($row->total_overtime, 2, ',', '.') }}</td>
    <td>Rp {{ number_format($row->total_salary, 2, ',', '.') }}</td>
  </tr>
  @endforeach
  <tr>
    <td colspan="4"><center><b>Total</b></center></td>
    <td><b>Rp {{ number_format($total->total_all, 2, ',', '.') }}</b></td>
  </tr>
</table>