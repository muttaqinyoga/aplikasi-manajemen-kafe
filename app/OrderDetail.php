<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
	protected $primaryKey = 'uid';
    protected $table = 'order_details';
	public $incrementing = false;

	public function order()
	{
		return $this->belongsTo('App\Menu', 'order_uid');
	}
    public function menus()
    {
    	return $this->belongsTo('App\Menu', 'menu_uid');
    }
    public function tables()
    {
    	return $this->belongsTo('App\Table', 'table_number');
    }
}
