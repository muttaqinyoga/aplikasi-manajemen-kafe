<?php

namespace App\Http\Controllers;

use App\Payment;
use App\Order;
use App\Table;
use Auth;
use DB;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::user()->role==62)
        {
            $totalPayment = DB::select('select SUM(amount) AS paymentToday from payments where DATE(created_at) = CURDATE()');
            $topFoods = DB::select('select menu_name, SUM(quantity_ordered) AS total from order_details JOIN menus ON menus.uid = order_details.menu_uid GROUP BY menu_name HAVING total > 1  ORDER BY total DESC LIMIT 5');
            return view('home', compact('totalPayment', 'topFoods'));
        }
        return redirect(url('pesanan'));
    }
}
