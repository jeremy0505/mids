<?php

namespace App\Models;

use App\Models\Base\MyProperty as BaseMyProperty;

class MyProperty extends BaseMyProperty
{
	protected $fillable = [
		'user_id',
		'client_id',
		'friendly_name',
		'address1',
		'address2',
		'city',
		'county',
		'country',
		'postal_code',
		'property_status',
		'photo',
		'currency',
		'cre_date',
		'cre_user_id',
		'upd_date',
		'upd_user_id'
	];
}
