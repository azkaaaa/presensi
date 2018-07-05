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
      <td colspan="4">
            <table>
              <tr>
                    <td><a style="font-weight: bold; font-size: 20px;"><center>Cafe Omboy</a><br>
                      <center>Jalan Boulevard Raya Blok RGA No.1, Jakasetia, Bekasi<br><br>

                      <a style="font-weight: bold;">Karyawan Terbaik Tahun {{ $total_transaction->year }}</a><br>
                                {{ date('d-m-Y', strtotime($date)) }}<br>
                  </td>
              </tr>
          </table>
      </td>
  </tr>
  <tr>
    <th style="width: 130px">Bulan</th>
    <th>Tahun</th>
    <th>Karyawan</th>
    <th>Nilai</th>
  </tr>
  @foreach($topsis_result as $row)
  <tr>
    <td>{{ $row->month }}</td>
    <td>{{ $row->year }}</td>
    <td>{{ $row->employee_name }}</td>
    <td>{{ $row->max_value }}</td>
  </tr>
  @endforeach

</table>