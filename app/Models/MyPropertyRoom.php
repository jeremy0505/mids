<?php

namespace App\Models;

use App\Models\Base\MyPropertyRoom as BaseMyPropertyRoom;

class MyPropertyRoom extends BaseMyPropertyRoom
{
	protected $fillable = [
		'my_property_id',
		'room_type_id',
		'client_id',
		'room_name',
		'comments',
		'cre_date',
		'cre_user_id',
		'upd_date',
		'upd_user_id'
	];
}
