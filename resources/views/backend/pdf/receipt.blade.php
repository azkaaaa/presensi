

<style>
    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        font-size: 12px;
        margin-left: 10%;
    }

    td, th {
        text-align: left;
    }

    /*tr:nth-child(even) {
    background-color: #dddddd;
    }*/
</style>

<table>
    <tr>
        <td colspan="3">
            <a style="font-weight: bold; font-size: 20px;"><center>Cafe Omboy</a>
            <br>
            <center>Jalan Boulevard Raya Blok RGA No.1<br>Jakasetia, Bekasi
        </td>
    </tr>
    <tr>
        <td colspan="3" style="text-align: center;">
            ================================
            <br>
        </td>
    </tr>
    <tr>
        <td>No. Trans</td>
        <td>: {{$orders->transaction_no}}</td>
        <td style="text-align: right;">{{$orders->order_date}}</td>
    </tr>
    <tr>
        <td>Kasir</td>
        <td colspan="2">: {{$orders->user_id}}</td>
    </tr>
    <tr>
        <td></td>
        <td colspan="2"></td>
    </tr>
    <tr>
        <td colspan="3" style="text-align: center;">
            <br>
        </td>
    </tr>

    <tr>
        <th><center></th>
        <th style="text-align: right;">Harga</th>
        <th style="text-align: right;">Subtotal</th>
    </tr>
    @foreach($order_detail as $item) 
<!--     <tr>
        <th colspan="3">{{ $item->menu_name }}</th>
    </tr> -->
    <tr>
        <td style="text-align: left;">[{{ $item->qty }}x] {{ $item->menu_name }}</td>
        <td style="text-align: right;">{{ number_format($item->subtotal ,2, '.' , ',')  }}</td>
        <td style="text-align: right;">{{ number_format($item->subtotal ,2, '.' , ',')  }}</td>
    </tr>
    @endforeach
    
    <tr>
        <td colspan="3" style="text-align: center;">
            <br>
        </td>
    </tr>
    <tr>
        <th colspan="2" style="text-align: right;">Total : Rp.</th>
        <th style="text-align: right;">{{ number_format($orders->total_price ,2, '.' , ',')  }}</th>
    </tr>
    <tr>
        <th colspan="2" style="text-align: right;">Jumlah Dibayar : Rp.</th>
        <th style="text-align: right;">{{ number_format($orders->cash ,2, '.' , ',')  }}</th>
    </tr>
    <tr>
        <th colspan="2" style="text-align: right;">Kembalian : Rp.</th>
        <th style="text-align: right;">{{ number_format($orders->return ,2, '.' , ',')  }}</th>
    </tr>
    <tr>
        <td colspan="3" style="text-align: center;">
            ---------------------------------------------------------
            <br>
        </td>
    </tr>
 
    <tr>
        <td colspan="3">
            <br>
            <center>Terima Kasih
        </td>
    </tr>
</table>

