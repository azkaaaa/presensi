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

                      <a style="font-weight: bold;">Transaksi Bulan {{ date('F', strtotime($total->order_date)) }}</a><br>
                                {{ date('d-m-Y', strtotime($total->year)) }}<br>
                  </td>
              </tr>
          </table>
      </td>
  </tr>
  <tr>
              <th>No. Transaksi</th>
              <th>Total Harga</th>
              <th>User ID</th>
              <!-- <th>Status</th> -->
              <th>Order Date</th>
  </tr>
  @foreach($orders as $row)
  <tr>
    <td>{{ $row->transaction_no }}</td>
    <td>Rp. {{ number_format($row->total_price ,2, ',' , '.') }}</td>
    <td>{{ $row->user_name }}</td>
    <!-- <td>{{ $row->status }}</td> -->
    <td>{{ $row->order_date }}</td>
  </tr>
  @endforeach
  <tr>
    <td><center><b>Jumlah Pembayaran</b></center></td>
    <td colspan="3"><b>Rp. {{ number_format($total->total_all ,2, ',' , '.') }}</b></td>
  </tr>

  <tr>
    <td><center><b>Total Transaksi</b></center></td>
    <td colspan="3"><b>{{ $total->total_trans }}</b></td>
  </tr>
</table>