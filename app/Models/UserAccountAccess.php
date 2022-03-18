<?php

namespace App\Models;

use App\Models\Base\UserAccountAccess as BaseUserAccountAccess;

class UserAccountAccess extends BaseUserAccountAccess
{
	protected $fillable = [
		'user_id',
		'account_id',
		'client_id',
		'date_granted',
		'access_mode',
		'cre_date',
		'cre_user_id',
		'upd_date',
		'upd_user_id'
	];
}
