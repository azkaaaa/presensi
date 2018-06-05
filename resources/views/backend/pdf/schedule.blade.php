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

                                <a style="font-weight: bold;">Jadwal Bulan {{ $spec_schedule->month_name }} {{ $spec_schedule->year }}</a><br>
                                {{ date('d-m-Y', strtotime($date)) }}<br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
  <tr>
    <th><center>Karyawan</center></th>
    <th><center>Libur Minggu 1</center></th>
    <th><center>Libur Minggu 2</center></th>
    <th><center>Libur Minggu 3</center></th>
    <th><center>Libur Minggu 4</center></th>
    <th><center>Shift</center></th>
  </tr>
  @foreach($schedule as $row)
  <tr>
    <td>{{ $row->employee_name }}</td>
    <td>{{ $row->first_week_name }}</td>
    <td>{{ $row->second_week_name }}</td>
    <td>{{ $row->third_week_name }}</td>
    <td>{{ $row->fourth_week_name }}</td>
    <td>{{ $row->shift_name }}</td>
  </tr>
  @endforeach
</table>