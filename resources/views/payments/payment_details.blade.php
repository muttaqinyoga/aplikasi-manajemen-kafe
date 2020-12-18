<!DOCTYPE html>
<html>
<head>
	<title>Invoice-{{$orders->first()->uid}}</title>
</head>
<body>
	<table width="100%" border="1" cellpadding="5" cellspacing="0" align="center">
	   <tr>
	    <td colspan="2" align="center" style="font-size:18px"><b>Invoice</b></td>
	   </tr>
	   <tr>
	    <td colspan="2">
	    <table width="100%" cellpadding="5">
	     <tr>
	     	<td width="15%">No. Pesanan</td>
	     	<td width="1%">:</td>
	     	<td>{{$orders->first()->invoiceNumber}}</td>
	     </tr>
	     <tr>
	     	<td>Waktu Pemesanan</td>
	     	<td>:</td>
	     	<td>{{date('d-m-Y H:i:s', strtotime($orders->first()->orderDate))}}</td>
	     </tr>
	     <tr>
	     	<td>No. Meja</td>
	     	<td>:</td>
	     	<td>{{$orders->first()->tableNumber}}</td>
	     </tr>
	    </table>
	    <br />
	    <table width="100%" border="1" cellpadding="5" cellspacing="0">
	     <tr>
	      <th>No.</th>
	      <th>Menu</th>
	      <th>Porsi</th>
	      <th>Total Harga</th>
	     </tr>
	     @foreach($orders as $o)
	     <tr>
	     	<td>{{++$no}}</td>
	     	<td>{{$o->menuName}} ( Rp. {{number_format($o->menuPrice, 0, ',','.')}} )</td>
	     	<td>{{$o->quantityOrdered}}</td>
	     	<td>Rp. {{ number_format((int) $o->menuPrice * (int) $o->quantityOrdered, 0, ',','.') }}</td>
	     </tr>
	     @endforeach
	     <tr>
	     	<th colspan="2">Total Pembayaran</th>
	     	<td colspan="2">Rp. {{number_format($orders->first()->amount, 0, ',','.')}}</td>
	     </tr>
	     <tr>
	     	<th colspan="2">Jumlah dibayar</th>
	     	<td colspan="2">Rp. {{number_format($orders->first()->moneyPaid, 0, ',','.')}}</td>
	     </tr>
	     <tr>
	     	<th colspan="2">Jumlah kembalian</th>
	     	<td colspan="2">Rp. {{number_format($orders->first()->moneyTurn, 0, ',','.')}}</td>
	     </tr>
	     <tr>
	     	<th colspan="2">Waktu Pembayaran</th>
	     	<td colspan="2">{{date('d-m-Y H:i:s', strtotime($orders->first()->created_at))}}</td>
	     </tr>
	    </table>
	      <br />
	      @if($orders->first()->userName=='Owner')
	      @else
	      <p>Waiter : {{$orders->first()->userName}}</p>
	      @endif
	     </td>
	    </tr>
	   </table>
	   <script type="text/javascript">
	   	window.onload = function(){
	   		window.print();
	   	}
	   </script>
</body>
</html>