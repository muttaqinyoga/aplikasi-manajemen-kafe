<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Menu;

class MenuController extends Controller
{
    public function menu()
    {
    	return view('admin.menu');
    }
    public function getMenu()
    {
    	$menu = Menu::orderBy('menu_name')->get();
    	$no = 0;
    	$html = '';
    	foreach($menu as $m)
    	{
    		$html .= '<tr>
                    <td>'.++$no.'</td>
                    <td>'.$m->menu_name.'</td>
                    <td>Rp. '.number_format($m->menu_price,0,',','.').'</td>
                    ';
            if($m->status_stock == 'Tersedia')
            {

                 $html .= '<td><span class="badge badge-success">'.$m->status_stock.'</span></td>';
            }
            else
            {
            	$html .= '<td><span class="badge badge-danger">x '.$m->status_stock.'</span></td>';
            }
            $html .=  '<td>
           				  <button type="button" class="btn btn-warning btn-sm" id="btnEditMenu" edit_menu_id="'.$m->uid.'" edit_menu_name="'.$m->menu_name.'" edit_menu_price="'.$m->menu_price.'" data-toggle="modal" data-target="#editMenuModal" edit_menu_status="'.$m->status_stock.'" >
                                Ubah
                            </button>
                            <button type="button" id="btnDeleteMenu" menu_id="'.$m->uid.'" menu_name="'.$m->menu_name.'" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteMenuModal">
                                Hapus
                            </button>
           			 </td>
                    </tr>';
    	}
    	echo $html;
    }
    public function save(Request $request)
    {
    	$validation = \Validator::make($request->all(), [
    		'menu_name' => 'required|min:3|max:50|string',
    		'menu_price' => 'required|integer|min:0|max:100000'
    	])->validate();
    	$menu = new Menu;
    	$menu->menu_name = $request->menu_name;
    	$menu->menu_price = $request->menu_price;
    	$menu->status_stock = 'Tersedia';
    	$menu->save();
    	return response()->json(['success' => '<div class="alert alert-primary alert-dismissible fade show" role="alert">
												<strong>Menu baru berhasil ditambah</strong>
												  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												    <span aria-hidden="true">&times;</span>
												  </button>
												</div>']);
    }
    public function delete(Request $request)
    {
    	if(isset($request->menuID))
    	{
          $menu = Menu::findOrFail($request->menuID);
          $menu->delete();
          return response()->json(['success' => '<div class="alert alert-danger alert-dismissible fade show" role="alert">
												  Menu <strong>'.$menu->menu_name.'</strong> berhasil dihapus dari daftar Menu
												  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												    <span aria-hidden="true">&times;</span>
												  </button>
												</div>']);
        }
    }
    public function update(Request $request)
    {
    	if(isset($request->editMenuID))
    	{
    		$menu = Menu::findOrFail($request->editMenuID);
    		$validation = \Validator::make($request->all(), [
	    		'editMenuName' => 'required|min:3|max:50|string',
	    		'editMenuPrice' => 'required|integer|min:0|max:100000',
	    		'editMenuStatus' => 'required|in:Tersedia,Tidak Tersedia'
	    	])->validate();
	    	$menu->menu_name = $request->editMenuName;
	    	$menu->menu_price = $request->editMenuPrice;
	    	$menu->status_stock = $request->editMenuStatus;
	    	$menu->update();
	    	return response()->json(['success' => '<div class="alert alert-warning alert-dismissible fade show" role="alert">
												<strong>Data menu berhasil diubah</strong>
												  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												    <span aria-hidden="true">&times;</span>
												  </button>
												</div>']);
    	}
    }
}
