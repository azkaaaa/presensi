@extends('frontend.master')
@section('content')
<div class="container">
    <div class="page">

        <div class="page-header">
            <h4 class="panel-title">
                <b>Daftar Pesanan</b>
            </h4>
        </div>

        <div class="col-md-8">
            @if (sizeof(Cart::content()) > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th width="35%">Nama Menu</th>
                        <th style="text-align: right;" width="25%">Harga Satuan</th>
                        <th style="text-align: center;" width="20%">Jumlah</th>
                        <th style="text-align: right;" width="10%">Subtotal</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>
                    @foreach (Cart::content() as $item)
                    <tr>
                        <td>{{ $item->name }}</td>
                        <td style="text-align: right;">{{ number_format($item->price ,2, ',' , '.')  }}</td>
                        <td style="text-align: center;">
                            {{ $item->qty }}
                        </td>
                        <td style="text-align: right;">{{ number_format($item->subtotal ,2, ',' , '.')  }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        <button class="btn-sm btn-primary" onclick="location.href='{{ url('/employee/shop') }}'"><span> Tambah Pesanan</span></button>

            @else

            <h4>Tidak ada produk dalam daftar pesanan</h4>
            <a href="{{ url('/employee/shop') }}" class="btn btn-primary btn-lg">Pilih Menu</a>

            @endif
        </div>

        <div class="col-md-4" style="border: 2px solid #dddddd;">
            <h4>
                <b>Detail Pembayaran</b>
            </h4>

            <table class="table">
                <colgroup>
                    <col class="col-xs-1">
                    <col class="col-xs-7">
                </colgroup>
                <tbody style="color: #616161">
                    <tr>
                        <th colspan="2" scope="row">
                            Total
                        </th>
                        <td style="text-align: right;">
                            Rp {{ Cart::instance('default')->subtotal() }}
                        </td>
                    </tr>
                    <tr>
                        <th colspan="2" scope="row">
                            Jumlah Dibayar
                        </th>
                        <td style="text-align: right;">
                            Rp {{ number_format($cash ,2, '.' , ',')  }}
                        </td>
                    </tr>
                    <tr>
                        <th colspan="2" scope="row">
                            Kembalian
                        </th>
                        <td style="text-align: right;">
                            Rp {{ number_format($result ,2, '.' , ',')  }}
                        </td>
                    </tr>
                </tbody>
            </table>

            <form action="{{ route('user.menu.order') }}" method="POST">
                {!! csrf_field() !!}
                <!-- @foreach (Cart::content() as $item)
                    <input type="hidden" name="id[]" value="{{ $item->id }}">
                    <input type="hidden" name="qty[]" value="{{ $item->qty }}">
                    <input type="hidden" name="subtotal[]" value="{{ $item->subtotal }}">
                @endforeach -->
                <input type="hidden" name="cash" value="{{ $cash }}">
                <input type="hidden" name="return" value="{{ $result }}">
                <input type="hidden" name="total_price" value="{!! Cart::subtotal() !!}">
                <input type="submit" class="btn btn-success" style="width:100%;" value="Buat Pesanan">
            </form>
            <br/>
        </div>
    </div>
</div>


<script type="text/javascript">
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
</script>

<style type="text/css">
.box{
  margin: 5px;
}
</style>
@endsection