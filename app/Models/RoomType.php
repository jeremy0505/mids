<?php

namespace App\Models;

use App\Models\Base\RoomType as BaseRoomType;

class RoomType extends BaseRoomType
{
	protected $fillable = [
		'client_id',
		'code',
		'name',
		'cre_date',
		'cre_user_id',
		'upd_date',
		'upd_user_id',
		'seq'
	];
}
