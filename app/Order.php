<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'uid';
    public $incrementing = false;

    public function orderDetail()
    {
        return $this->hasMany('App\OrderDetail', 'order_uid');
    }
    public function user()
    {
    	return $this->belongsTo('App\User', 'created_by');
    }
    public function table()
    {
        return $this->belongsTo('App\Table', 'table_number');
    }
}
