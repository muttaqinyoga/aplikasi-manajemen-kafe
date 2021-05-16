<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\OrderDetail;
use App\Menu;
use App\Table;
use DB;
use Auth;
use Illuminate\Support\Facades\Crypt;
use App\Payment;
class OrderController extends Controller
{
   public function orders()
   {
   	 $menu = Menu::where('status_stock', '=', 'Tersedia')->orderBy('menu_name')->get();
   	 return view('orders.orders', compact('menu'));
   }
   public function getData()
   {
      $orders;
      if(Auth::user()->role == 62)
      {
         $orders = DB::table('orders')
                  ->join('users', 'users.uid', '=', 'orders.created_by')
                  ->join('tables', 'tables.uid', '=', 'orders.table_number')
                  ->select('users.name AS createdBy', 'orders.created_by AS userID', 'orders.table_number AS tableID', 'tables.table_number AS tableNumber', 'orders.uid AS orderID', 'orders.total_price AS totalPrice', 'orders.invoice_number AS invoiceNumber', 'orders.status AS orderStatus', 'orders.created_at AS orderDate')
                  ->orderBy('orders.uid', 'desc')
                  ->get();
      }
      else
      {
         $orders = DB::table('orders')
                  ->join('users', 'users.uid', '=', 'orders.created_by')
                  ->join('tables', 'tables.uid', '=', 'orders.table_number')
                  ->select('users.name AS createdBy', 'orders.created_by AS userID', 'orders.table_number AS tableID', 'tables.table_number AS tableNumber', 'orders.uid AS orderID', 'orders.total_price AS totalPrice', 'orders.invoice_number AS invoiceNumber', 'orders.status AS orderStatus', 'orders.created_at AS orderDate')
                  ->where('orders.created_by', '=', Auth::user()->uid)
                  ->orderBy('orders.uid', 'desc')
                  ->get();
      }
   	
   	$html = '';
	   	foreach($orders as $o)
	    	{
	    		$html .= '<tr>
	                    <td>'.$o->invoiceNumber.'</td>
	                    <td>'.$o->tableNumber.'</td>
	                    <td>Rp. '.number_format($o->totalPrice,0,',','.').'</td>
	                    ';
	            if($o->orderStatus == 'Belum dibayar')
	            {

	                 $html .= '<td><span class="badge text-white" style="background-color: #f4511e!important;">'.$o->orderStatus.'</span></td>';
	            }
	            else if($o->orderStatus == 'Telah dibayar')
	            {
	            	$html .= '<td><span class="badge" style="background-color: #76ff03!important;">'.$o->orderStatus.'</span></td>';
	            }
               else
               {
                  $html .= '<td><span class="badge text-white" style="background-color: #d81b60!important;">'.$o->orderStatus.'</span></td>';
               }
	            if(Auth::user()->role == 62)
	            {
	            	$html .= '<td>'.$o->createdBy.'</td>';
	            }
               $html .=  '<td>'.date('d-m-Y H:i:s', strtotime($o->orderDate)).'</td>';
               if($o->orderStatus == 'Telah dibayar')
               {
                  $html .= '<td align="center">
                             <a class="btn btn-warning btn-sm" href="order/'.$o->orderID.'/details">
                                   Detail
                               </a>
                           </td>';
               }
               else if($o->orderStatus == 'Belum dibayar')
               {
                  $html .= '<td>
                             <a class="btn btn-warning btn-sm" href="order/'.$o->orderID.'/details">
                                   Detail
                               </a>
                               <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#cancelOrderModal" invoiceNumber="'.$o->invoiceNumber.'" orderID="'.$o->orderID.'" tableNumber="'.$o->tableNumber.'" id="cancelOrder" >
                                   Batalkan Pesanan
                               </button>
                           </td>';
               }
               else
               {
                  $html .= '<td align="center">
                             <a class="btn btn-warning btn-sm" href="order/'.$o->orderID.'/details">
                                   Detail
                               </a>
                           </td>';
               }
	            
                          
	                 $html.='</tr>';
	    	}
	    	echo $html;
   }
   public function getTables()
   {
   		$tables = Table::where('status', '=', 'Kosong')->orderBy('table_number')->get();
   		$html = '<option selected value="">-- Pilih Nomor Meja --</option>';
   		foreach($tables as $t)
   		{
   			$html .= '<option value="'.$t->uid.'">'.$t->table_number.'</option>';
   		}
   		echo $html;
   }
   public function save(Request $request)
   {
   		$validation = \Validator::make($request->all(), [
		    		'menu_id' => 'required|exists:menus,uid',
		    		'quantity_ordered' => 'required|integer|min:0|max:100',
		    		'table_number' => 'required|exists:tables,uid',
		    		'_nOrder' => 'required|integer|min:1|max:100'
		 ],[
		 	'menu_id.required' => 'Menu Pesanan tidak boleh kosong',
		 	'menu_id.exists' => 'Menu yang dipilih tidak valid',
		 	'quantity_ordered.required' => 'Jumlah pesanan tidak boleh kosong',
		 	'quantity_ordered.integer' => 'Jumlah pesanan tidak valid',
		 	'quantity_ordered.min' => 'Jumlah pesanan tidak valid',
		 	'quantity_ordered.max' => 'Jumlah pesanan tidak valid',
		 	'table_number.required' => 'Nomor Meja tidak boleh kosong',
		 	'table_number.exists' => 'Nomor Meja tidak valid',
		 	'_nOrder.required' => 'Failed to submit',
		 	'_nOrder.min' => 'Failed to submit',
		 	'_nOrder.max' => 'Failed to submit'
		 ])->validate();
   		$table = Table::find($request->table_number);
   		$timeOrdered = date('YmdHis');
   		if($request->_nOrder > 1)
   		{
   			$totalPrice = 0;
   			$orderdetails = [];
   			for($i = 2; $i<=$request->_nOrder; $i++)
   			{
   				if(isset($request['menu_id'.$i]) && isset($request['quantity_ordered'.$i]) )
   				{
   					$validation = \Validator::make($request->all(), [
				    		'menu_id'.$i => 'required|exists:menus,uid',
				    		'quantity_ordered'.$i => 'required|integer|min:1|max:100'
					 ],[
					 	'menu_id'.$i.'.required' => 'Menu Pesanan tidak boleh kosong',
					 	'menu_id'.$i.'.exists' => 'Menu yang dipilih tidak valid',
					 	'quantity_ordered'.$i.'.required' => 'Jumlah pesanan tidak boleh kosong',
					 	'quantity_ordered'.$i.'.integer' => 'Jumlah pesanan tidak valid',
					 	'quantity_ordered'.$i.'.min' => 'Jumlah pesanan tidak valid',
					 	'quantity_ordered'.$i.'.max' => 'Jumlah pesanan tidak valid'
					 ])->validate();
   					$menuOrdered = Menu::where('uid', '=', $request['menu_id'.$i])->firstOrFail();
   					$menuPriceOrdered = $menuOrdered->menu_price;
   					$menuQuantityOrdered = $request['quantity_ordered'.$i];
   					$totalPrice += (int) $menuPriceOrdered * (int) $menuQuantityOrdered;
   					$orderdetails['menu_id'.$i] = $request['menu_id'.$i];
   					$orderdetails['quantity_ordered'.$i] = $request['quantity_ordered'.$i];
   				}

   			}
   		$menuOrdered = Menu::where('uid', '=', $request['menu_id'])->firstOrFail();
			$menuPriceOrdered = $menuOrdered->menu_price;
			$menuQuantityOrdered = $request['quantity_ordered'];
			$totalPrice += (int) $menuPriceOrdered * (int) $menuQuantityOrdered;
			$order = new Order;
			$order->created_by = Auth::user()->uid;
			$order->table_number = $table->uid;
			$order->total_price = $totalPrice;
			$order->invoice_number = $timeOrdered;
			$order->status = 'Belum dibayar';
			$order->save();
			$orderID = Order::where('created_by', '=', Auth::user()->uid, 'and')->where('total_price', '=', $totalPrice, 'and')->where('invoice_number', '=', $timeOrdered, 'and')->where('status', '=', 'Belum dibayar')->first()->uid;
			$orderdetail = new OrderDetail;
			$orderdetail->order_uid = $orderID;
			$orderdetail->menu_uid = $menuOrdered->uid;
			$orderdetail->quantity_ordered = $menuQuantityOrdered;
			$orderdetail->save();
   			for($i = 2; $i<=$request->_nOrder; $i++)
   			{
   				if(array_key_exists('menu_id'.$i, $orderdetails) && array_key_exists('quantity_ordered'.$i, $orderdetails))
   				{
   					$orderdetail = new OrderDetail;
   					$orderdetail->order_uid = $orderID;
   					$orderdetail->menu_uid = $orderdetails['menu_id'.$i];
   					$orderdetail->quantity_ordered = $orderdetails['quantity_ordered'.$i];
   					$orderdetail->save();
   				}
   			}
   		}
   		else
   		{
   			$menuOrdered = Menu::where('uid', '=', $request['menu_id'])->firstOrFail();
   			$totalPrice = (int) $menuOrdered->menu_price * (int) $request->quantity_ordered;
   			$order = new Order;
   			$order->created_by = Auth::user()->uid;
   			$order->table_number = $table->uid;
   			$order->total_price = $totalPrice;
   			$order->invoice_number = $timeOrdered;
   			$order->status = 'Belum dibayar';
   			$order->save();
   			$orderID = Order::where('created_by', '=', Auth::user()->uid, 'and')->where('total_price', '=', $totalPrice, 'and')->where('invoice_number', '=', $timeOrdered, 'and')->where('status', '=', 'Belum dibayar')->first()->uid;
   			$orderdetail = new OrderDetail;
   			$orderdetail->order_uid = $orderID;
			$orderdetail->menu_uid = $menuOrdered->uid;
			$orderdetail->quantity_ordered = $request->quantity_ordered;
			$orderdetail->save();
   		}
		$table->status = 'Telah dipesan';
		$table->update();

   		return response()->json(['success' => '<div class="alert alert-info alert-dismissible fade show" role="alert">
												Pesanan dengan nomor meja : <strong>'.$table->table_number.'</strong> berhasil dibuat
												  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												    <span aria-hidden="true">&times;</span>
												  </button>
												</div>']);
   }
   public function delete(Request $request)
   {
      if(Auth::user()->role==62)
      {
         $order = Order::where('uid', '=', $request->orderID, 'and')->where('status', '=', 'Belum dibayar')->firstOrFail();
      }
      else
      {
         $order = Order::where('uid', '=', $request->orderID, 'and')->where('status', '=', 'Belum dibayar', 'and')->where('created_by', '=', Auth::user()->uid)->firstOrFail();
      }
      $order->delete();
      $table = Table::findOrFail($order->table_number);
      $table->status = 'Kosong';
      $table->update();

      return response()->json(['success' => '<div class="alert alert-info alert-dismissible fade show" role="alert">
                                    Pesanan dengan nomor : <strong>'.$order->invoice_number.'</strong> berhasil dibatalkan
                                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>']);
   }
   public function details($id)
   {
      $orders = DB::table('orders')
                  ->join('users', 'users.uid', '=', 'orders.created_by')
                  ->join('tables', 'tables.uid', '=', 'orders.table_number')
                  ->join('order_details', 'order_details.order_uid', '=', 'orders.uid')
                  ->join('menus', 'menus.uid', '=', 'order_details.menu_uid')
                  ->select('users.name AS createdBy', 'orders.created_by AS userID', 'orders.table_number AS tableID', 'tables.table_number AS tableNumber', 'orders.uid AS orderID', 'orders.total_price AS totalPrice', 'orders.invoice_number AS invoiceNumber', 'orders.status AS orderStatus', 'orders.created_at AS orderDate', 'order_details.uid as orderDetailsID', 'order_details.menu_uid AS menuID', 'order_details.quantity_ordered AS quantityOrdered', 'menus.menu_name AS menuName', 'menus.menu_price AS menuPrice')
                  ->where('orders.uid', '=', $id)
                  ->get();
      if(count($orders) == 0)
      {
         abort('404');
      }
      $crypted_order_uid = Crypt::encryptString($id);
      $tables = Table::where('status', '=', 'Kosong')->orderBy('table_number')->get();
      $menu = Menu::where('status_stock', '=', 'Tersedia')->orderBy('menu_name')->get();
      $no = 0;
      $paymentID = null;
      $payment = Payment::where('order_uid', '=', $id)->first();
      if($payment != NULL)
      {
         $paymentID = $payment->uid;
      }
      return view('orders.details', compact('orders', 'no', 'tables',  'id', 'menu', 'crypted_order_uid', 'paymentID'));
   }
   public function updateTable(Request $request)
   {
      $validation = \Validator::make($request->all(), [
               'edit_table_number' => 'required|exists:tables,uid'
       ],[
         'edit_table_number.required' => 'Nomor Meja tidak boleh kosong',
         'edit_table_number.exists' => 'Nomor Meja tidak valid'
       ])->validate();
      $id = $request->id;
      $order = Order::findOrFail($id);
      $tableChoosen = Table::findOrFail($request->edit_table_number);
      $table = Table::findOrFail($order->table_number);
      if($tableChoosen->status == 'Telah dipesan')
      {
         return redirect()->route(url('order/'.$id.'/details'));
      }
      $tableChoosen->status = 'Telah dipesan';
      $tableChoosen->update();
      $table->status = 'Kosong';
      $table->update();
      $order->table_number = $request->edit_table_number;
      $order->update();
      return redirect(url('order/'.$id.'/details'))->with('message', 'Nomor Meja pada pesanan berhasil diubah');
   }

   public function addNewOrder(Request $request, $id)
   {
      $validation = \Validator::make($request->all(), [
               'add_new_menu' => 'required|exists:menus,uid',
               'quantity_new_menu' => 'required|integer|min:1|max:100'
       ],[
         'add_new_menu.required' => 'Menu tidak boleh kosong',
         'add_new_menu.exists' => 'Menu tidak valid',
         'quantity_new_menu.required' => 'Jumlah menu tidak boleh kosong',
         'quantity_new_menu.integer' => 'Jumlah menu tidak valid',
         'quantity_new_menu.min' => 'Jumlah menu tidak valid',
         'quantity_new_menu.max' => 'Jumlah menu tidak valid'
       ])->validate();
      if(Auth::user()->role == 62)
      {
         $order = Order::where('uid', '=', $id, 'and')->where('status', '=', 'Belum dibayar')->firstOrFail();
      }
      else
      {
         $order = Order::where('uid', '=', $id, 'and')->where('status', '=', 'Belum dibayar', 'and')->where('created_by', '=', Auth::user()->uid)->firstOrFail();
      }
      $newMenu = Menu::findOrFail($request->add_new_menu);
      $newTotalPrice = (int) $newMenu->menu_price * (int) $request->quantity_new_menu;
      $currTotalPrice = $order->total_price;
      $order->total_price = (int) $currTotalPrice + (int) $newTotalPrice;
      $order->update();
      $orderdetail = new OrderDetail;
      $orderdetail->order_uid = $id;
      $orderdetail->menu_uid = $newMenu->uid;
      $orderdetail->quantity_ordered = $request->quantity_new_menu;
      $orderdetail->save();
      return redirect(url('order/'.$id.'/details'))->with('message', 'Pesanan baru berhasil ditambahkan');
   }
   public function updateMenuOrder(Request $request, $id, $oid)
   {
      $validation = \Validator::make($request->all(), [
               'edit_menu_ordered_id' => 'required|exists:menus,uid',
               'edit_quantity_menu_ordered' => 'required|integer|min:1|max:100'
       ])->validate();
      if(Auth::user()->role == 62)
      {
         $order = Order::where('uid', '=', $id, 'and')->where('status', '=', 'Belum dibayar')->firstOrFail();
      }
      else
      {
         $order = Order::where('uid', '=', $id, 'and')->where('status', '=', 'Belum dibayar', 'and')->where('created_by', '=', Auth::user()->uid)->firstOrFail();
      }
      $newTotalPrice = 0;
      $orderdetail = OrderDetail::findOrFail($oid);
      $orderdetail->menu_uid = $request->edit_menu_ordered_id;
      $orderdetail->quantity_ordered = $request->edit_quantity_menu_ordered;
      $orderdetail->update();
      $currAllOrderDetails = DB::table('order_details')
                              ->join('menus', 'menus.uid', '=', 'order_details.menu_uid')
                              ->select('menus.menu_price AS menuPrice', 'order_details.quantity_ordered AS quantityOrdered')
                              ->where('order_details.order_uid', '=', $id)
                              ->get();
      foreach($currAllOrderDetails as $od)
      {
         $newTotalPrice += (int) $od->menuPrice * (int) $od->quantityOrdered;
      }
      $order->total_price = $newTotalPrice;
      $order->update();
      return redirect(url('order/'.$id.'/details'))->with('message', 'Menu pesanan perhasil diupdate');
   }
   public function deleteMenuOrder($id, $oid)
   {
      if(Auth::user()->role == 62)
      {
         $order = Order::where('uid', '=', $id, 'and')->where('status', '=', 'Belum dibayar')->firstOrFail();
      }
      else
      {
         $order = Order::where('uid', '=', $id, 'and')->where('status', '=', 'Belum dibayar', 'and')->where('created_by', '=', Auth::user()->uid)->firstOrFail();
      }
      $orderdetail = OrderDetail::findOrFail($oid);
      $orderdetail->delete();
      $newTotalPrice = 0;
      $currAllOrderDetails = DB::table('order_details')
                              ->join('menus', 'menus.uid', '=', 'order_details.menu_uid')
                              ->select('menus.menu_price AS menuPrice', 'order_details.quantity_ordered AS quantityOrdered')
                              ->where('order_details.order_uid', '=', $id)
                              ->get();
      foreach($currAllOrderDetails as $od)
      {
         $newTotalPrice += (int) $od->menuPrice * (int) $od->quantityOrdered;
      }
      // if all menu ordered has been deleted
      if($newTotalPrice == 0)
      {
         $order->delete();
         $table = Table::findOrFail($order->table_number);
         $table->status = 'Kosong';
         $table->update();
         return redirect(url('/pesanan'))->with('message', 'Pesanan berhasil dihapus');
      }
      else
      {
         $order->total_price = $newTotalPrice;
         $order->update();
         return redirect(url('order/'.$id.'/details'))->with('message', 'Pesanan berhasil dihapus');
      }
   }
}
