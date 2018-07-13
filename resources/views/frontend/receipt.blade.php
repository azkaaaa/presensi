@extends('frontend.master')

@section('content')
<style>
    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        font-size: 12px;
        width: 20%;
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
    <tr><th><br><br></th></tr>
    <tr>
        <th colspan="3" ><center>
            <a href="{{ url('/employee/shop') }}" class="btn btn-primary btn-lg">Daftar Menu</a>
        </th>
        <th colspan="3" ><center>
            <a href="{{route('admin.printreceipt.save', $order_id)}}" class="btn btn-primary btn-lg">Print Struk</a>
        </th>
    </tr>
</table>

@endsection