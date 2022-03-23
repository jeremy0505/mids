<?php

namespace App\Models;

use App\Models\Base\Category as BaseCategory;

class Category extends BaseCategory
{
	protected $fillable = [
		'name',
		'user_id',
		'client_id',
		'system_or_user',
		'system_type',
		'user_type',
		'phys_or_digi',
		'cre_date',
		'cre_user_id',
		'upd_date',
		'upd_user_id'
	];
}
