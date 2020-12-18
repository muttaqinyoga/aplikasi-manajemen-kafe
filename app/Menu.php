<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $primaryKey = 'uid';
    public $incrementing = false;

    public function order()
    {
    	return $this->hasMany('App\OrderDetail', 'menu_uid');
    }
}
