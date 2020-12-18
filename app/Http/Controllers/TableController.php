<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Table;
class TableController extends Controller
{
    public function table()
    {
    	return view('admin.table');
    }
    public function getTable()
    {
    	$table = Table::orderBy('table_number')->get();
    	$html = '';
    	foreach($table as $t)
    	{
    		$html .= '<tr>
                    <td>'.$t->table_number.'</td>';
            if($t->status == 'Kosong')
            {

                 $html .= '<td><span class="badge badge-danger">'.$t->status.'</span></td>';
            }
            else
            {
            	$html .= '<td><span class="badge badge-success">'.$t->status.'</span></td>';
            }
            $html .=  '<td>
           				  <button type="button" class="btn btn-success btn-sm" id="btnEditTable" edit_table_id="'.$t->uid.'" edit_table_number="'.$t->table_number.'" edit_table_status="'.$t->status.'" data-toggle="modal" data-target="#editTableModal" >
                                Ubah
                            </button>
                            <button type="button" id="btnDeleteTable" class="btn btn-dark btn-sm" table_id="'.$t->uid.'" table_number="'.$t->table_number.'" data-toggle="modal" data-target="#deleteTableModal">
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
    		'table_number' => 'required|integer|min:0|max:50|unique:tables,table_number'
    	])->validate();

    	$table = new Table;
    	$table->table_number = $request->table_number;
    	$table->status = 'Kosong';
    	$table->save();
    	return response()->json(['success' => '<div class="alert alert-primary alert-dismissible fade show" role="alert">
												<strong>Meja baru berhasil ditambah</strong>
												  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												    <span aria-hidden="true">&times;</span>
												  </button>
												</div>']);
    }
    public function update(Request $request)
    {
    	if(isset($request->editTableID))
    	{
    		$validation = \Validator::make($request->all(), [
	    		'editTableNumber' => 'required|integer|min:0|max:50|unique:tables,table_number,'.$request->editTableID.',uid',
	    		'editTableStatus' => 'required|in:Kosong,Telah dipesan'
	    	])->validate();
	    	$table = Table::findOrFail($request->editTableID);
	    	$table->table_number = $request->editTableNumber;
	    	$table->status = $request->editTableStatus;
	    	$table->update();
    	}
    	return response()->json(['success' => '<div class="alert alert-success alert-dismissible fade show" role="alert">
												<strong>Data Meja berhasil diubah</strong>
												  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												    <span aria-hidden="true">&times;</span>
												  </button>
												</div>']);
    }
    public function delete(Request $request)
    {
    	if(isset($request->tableID))
    	{
          $table = Table::findOrFail($request->tableID);
          $table->delete();
          return response()->json(['success' => '<div class="alert alert-dark alert-dismissible fade show" role="alert">
												  Meja dengan nomor <strong>'.$table->table_number.'</strong> berhasil dihapus dari daftar Meja
												  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
												    <span aria-hidden="true">&times;</span>
												  </button>
												</div>']);
        }
    }
}
