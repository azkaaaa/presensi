@extends ('backend.layouts.master') @section ('content')

<div class="container">
    @if (session()->has('success_message'))
    <div class="alert alert-success">
        {{ session()->get('success_message') }}
    </div>
    @endif

    @if (session()->has('error_message'))
    <div class="alert alert-danger">
        {{ session()->get('error_message') }}
    </div>
    @endif

    <div class="row">
        <div class="col-md-4" style="margin-left:-10px">
            <div class="box box-info">

                <div class="panel-heading">
                    <h4 class="panel-title">
                        <b>Detail Transaksi</b>
                    </h4>
                </div>

                <div class="box-body">
                    <table class="table">
                        <tr>
                            <td>No. Transaksi</td>
                            <td>: {{ $orders->transaction_no }}</td>
                        </tr>
                        <tr>
                            <td>Tanggal </td>
                            <td>: {{ $orders->order_date }}</td>
                        </tr>
                        <tr>
                            <td>User ID</td>
                            <td>: {{ $orders->user_id }}</td>
                        </tr>
                        <tr>
                            <td>Total Pembayaran</td>
                            <td>: Rp{{ number_format($orders->total_price, 2, ',' , '.')  }}</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>: {{ $orders->status }}</td>
                        </tr>
                    </table>
                </div>


        <div class="box-footer">
          <button class="btn-default btn" type="reset" onclick="window.location='{{ url('/admin/transaction')}}'">
            Kembali
          </button>
      </div>
            </div>
        </div>


        <div class="col-md-7" style="margin-left:-10px">
            <div class="box box-info">

                <div class="panel-heading">
                    <h4 class="panel-title">
                        <b>Daftar Pesanan</b>
                    </h4>
                </div>

                <div class="box-body">
                    <table class="table table-bordered table-striped" id="employees-data">
                        <thead>
                            <tr>
                                <th>Menu</th>
                                <th>Harga Satuan</th>
                                <th>Jml</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>

                        @foreach($order_detail as $data)
                        <tr>
                            <td>{{ $data->menu_name }}</td>
                            <td>Rp{{ number_format($data->menu_price, 2, ',' , '.') }}</td>
                            <td>{{ $data->qty }}</td>
                            <td>Rp{{ number_format($data->subtotal, 2, ',' , '.') }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
