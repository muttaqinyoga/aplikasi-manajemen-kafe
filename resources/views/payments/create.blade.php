@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-info text-center text-white">
                    <h5>Buat Pembayaran</h5>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger pn-0" role="alert">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="table-responsive"></div>
                    <table class="table">
                        <tr>
                            <td>No. Pesanan</td>
                            <td>{{$order->invoice_number}}</td>
                        </tr>
                         <tr>
                            <td>No. Meja</td>
                            <td>{{$order->table->table_number}}</td>
                        </tr>
                        <tr>
                            <td>Waktu Pemesanan</td>
                            <td>{{date('d-m-Y H:i:s', strtotime($order->created_at))}}</td>
                        </tr>
                        <tr>
                            <td>Total Pembayaran</td>
                            <td>Rp. {{number_format($order->total_price,0,',','.')}}</td>
                        </tr>
                        <tr>
                            <td width="25%">Uang yang dibayar</td>
                            <td>
                                <form method="POST" action="{{url('admin/payment/save')}}">
                                @csrf
                                <input type="hidden" name="orderID" id="orderID" value="{{$id}}">
                                <input type="number" name="moneyPaid" id="moneyPaid" placeholder="contoh : 50000" class="form-control {{$errors->has('moneyPaid') ? 'is-invalid' : ''}}" style="width: 20%!important;">
                            </td>
                        </tr>
                        <tr>
                            <td>Kembalian</td>
                            <td id="kembalian"></td>
                        </tr>
                        <tr>
                            <td>
                                <button class="btn btn-danger form-control" id="submit" type="submit" disabled>Simpan</button>
                            </td>
                            </form>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function(){
        $('#moneyPaid').on('keyup', function(){
            const moneyPaid = parseInt($(this).val());
            const total = parseInt(`{{$order->total_price}}`);
            if(moneyPaid - total >= 0){
                $('#kembalian').text(`Rp. ${formatRupiah(moneyPaid - total)}`);
                $('#submit').attr('disabled', false);
            } else{
                $('#kembalian').text('Uang yang dibayar kurang');
                $('#submit').attr('disabled', true);
            }
        });
    });
    function formatRupiah(number, prefix){
        let number_string = number.toString();
        let split           = number_string.split(',');
        let sisa            = split[0].length % 3;
        let rupiah          = split[0].substr(0, sisa);
        let ribuan          = split[0].substr(sisa).match(/\d{3}/gi);
        if(ribuan){
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }
</script>
@endsection