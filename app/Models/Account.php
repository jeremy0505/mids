<?php

namespace App\Models;

use App\Models\Base\Account as BaseAccount;

class Account extends BaseAccount
{
	protected $fillable = [
		'account_owner_user_id',
		'client_id',
		'account_code',
		'cre_date',
		'cre_user_id',
		'upd_date',
		'upd_user_id'
	];
}
