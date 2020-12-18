<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $primaryKey = 'uid';
	public $incrementing = false;

	public function order()
	{
		return $this->hasMany('App\Order', 'uid');
	}
}
