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
                <td colspan="3">
                    <table>
                        <tr>
                            <td><a style="font-weight: bold; font-size: 20px;"><center>Cafe Omboy</a><br>
                                <center>Jalan Boulevard Raya Blok RGA No.1, Jakasetia, Bekasi<br><br>

                                <a style="font-weight: bold;">Gaji Bulan {{ $month }}</a><br>
                                {{ date('d-m-Y', strtotime($date)) }}<br>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
    <tr>
    <th>Nama Karyawan</th>
    <td colspan="2">{{ $salary->employee_name }}</td>
    </tr>
    
    <tr>
    <td colspan="3"></td>
    </tr>

    <tr>
    <th style="width: 30px">#</th>
    <td style="width: 30px">Jumlah</td>
    <td>Total</td>
    </tr>

    <tr>
    <th style="width: 30px">Total Kehadiran</th>
    <td>{{ $salary->total_presences }} Hari</td>
    <td style="width: 30px">Rp {{ number_format($salary->salary, 2, ',', '.') }}</td>
    </tr>

    <tr>
    <th>Total Transport</th>
    <td>{{ $salary->total_presences }} Hari</td>
    <td>Rp {{ number_format($salary->total_transport, 2, ',', '.') }}</td>
    </tr>

    <tr>
    <th>Total Lembur</th>
    <td>{{ $salary->all_overtime }} Jam</td>
    <td>Rp {{ number_format($salary->total_overtime, 2, ',', '.') }}</td>
    </tr>

    <tr>
    <td colspan="2"><b>Total Gaji</b></td>
    <td><b>Rp {{ number_format($salary->total_salary, 2, ',', '.') }}</b></td>
    </tr>
</table>