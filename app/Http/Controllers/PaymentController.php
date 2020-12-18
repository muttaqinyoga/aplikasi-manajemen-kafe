<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Payment;
use App\Order;
use App\Table;
use Auth;
use Illuminate\Support\Facades\Crypt;
use DB;
class PaymentController extends Controller
{
	public function payments()
	{
		return view('payments.payments');
	}
	public function getData()
	{
		$html = '';
		if(Auth::user()->role==62)
		{
			$payments = DB::table('payments')
				->join('orders', 'orders.uid', '=', 'payments.order_uid')
				->select('payments.*', 'orders.invoice_number AS orderNumber')
				->orderBy('payments.created_at', 'desc')
				->get();
			foreach($payments as $p)
			{
				$html .= '<tr>
							<td>'.$p->orderNumber.'</td>
							<td>Rp. '.number_format($p->amount, 0, ',','.').'</td>
							<td>Rp. '.number_format($p->moneyPaid, 0, ',','.').'</td>
							<td>Rp. '.number_format($p->moneyTurn, 0, ',','.').'</td>
							<td>'.date('d-m-Y H:i:s', strtotime($p->created_at)).'</td>
							<td><a class="btn btn-danger btn-sm" target=__blank href="'.url('invoice/'.$p->uid).'">Cetak Struk Pembayaran</a></td>
						 </tr>
						';
			}
		}
		else
		{
			$payments = DB::table('payments')
				->join('orders', 'orders.uid', '=', 'payments.order_uid')
				->join('users', 'users.uid', '=', 'orders.created_by')
				->select('payments.*', 'orders.invoice_number AS orderNumber')
				->where('orders.created_by', '=', Auth::user()->uid)
				>orderBy('payments.created_at', 'desc')
				->get();
			foreach($payments as $p)
			{
				$html .= '<tr>
							<td>'.$p->orderNumber.'</td>
							<td>Rp. '.number_format($p->amount, 0, ',','.').'</td>
							<td>Rp. '.number_format($p->moneyPaid, 0, ',','.').'</td>
							<td>Rp. '.number_format($p->moneyTurn, 0, ',','.').'</td>
							<td>'.date('d-m-Y H:i:s', strtotime($p->created_at)).'</td>
							<td><a class="btn btn-danger btn-sm" target="__blank" href="'.url('invoice/'.$p->uid).'">Cetak Struk Pembayaran</a></td>
						 </tr>
						';
			}
		}
		echo $html;
	}
    public function details($id)
    {
    	$orders = DB::table('payments')
    			  ->join('orders', 'orders.uid', '=', 'payments.order_uid')
    			  ->join('order_details', 'order_details.order_uid', '=', 'orders.uid')
    			  ->join('tables', 'tables.uid', '=', 'orders.table_number')
    			  ->join('menus', 'menus.uid', '=', 'order_details.menu_uid')
    			  ->join('users', 'users.uid', '=', 'orders.created_by')
    			  ->select('orders.invoice_number AS invoiceNumber','tables.table_number AS tableNumber', 'orders.created_at AS orderDate', 'menus.menu_name AS menuName', 'menus.menu_price AS menuPrice', 'order_details.quantity_ordered AS quantityOrdered', 'users.name AS userName', 'payments.*')
    			  ->where('payments.uid', '=', $id, 'and')
    			  ->where('orders.status', '=', 'Telah dibayar')
    			  ->get();

      if(count($orders) == 0)
      {
         abort('404');
      }
      $no = 0;
    	return view('payments.payment_details', compact('orders', 'no'));
    }
    public function save($id)
    {
    	$decrypted_order_uid = Crypt::decryptString($id);
      	$order = Order::with('table')->where('uid', '=', $decrypted_order_uid, 'and')->where('status', '=', 'Belum dibayar')->firstOrFail();
    	return view('payments.create', compact('order', 'id'));
    }
    public function store(Request $request)
    {
      $decrypted_order_uid = Crypt::decryptString($request->orderID);
      $order = Order::findOrFail($decrypted_order_uid);
    	$validation = \Validator::make($request->all(), [
               'moneyPaid' => 'required|integer|min:'.$order->total_price
       ],[
         'moneyPaid.required' => 'Uang yang dibayar tidak boleh kosong',
         'moneyPaid.integer' => 'Uang yang dibayar tidak valid',
         'moneyPaid.min' => 'Uang yang dibayar tidak valid'
       ])->validate();
      if($order->status == 'Telah dibayar' || $order->status == 'Dibatalkan' )
      {
      		return abort('500');
      }
      	$table = Table::findOrFail($order->table_number);
      	$order->status = 'Telah dibayar';
      	$order->update();
      	$table->status = 'Kosong';
      	$table->update();
      	$payment = New Payment;
      	$payment->order_uid = $order->uid;
      	$payment->amount = (int) $order->total_price;
      	$payment->moneyPaid = (int) $request->moneyPaid;
      	$payment->moneyTurn = (int) $request->moneyPaid - (int) $order->total_price;
      	$payment->save();

      	return redirect(url('/admin/pembayaran'))->with('message', 'Pembayaran dengan no. pesanan : <strong>'.$order->invoice_number.'</strong> berhasil dilakukan');
    }
}
