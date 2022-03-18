<?php

namespace App\Models;

use App\Models\Base\UserPlan as BaseUserPlan;

class UserPlan extends BaseUserPlan
{
	protected $fillable = [
		'user_id',
		'plan_id',
		'client_id',
		'from_name',
		'from_description',
		'from_date_avail_start',
		'from_date_avail_end',
		'from_discounted_months',
		'from_discounted_fee',
		'from_revert_to_fee',
		'cre_date',
		'cre_user_id',
		'upd_date',
		'upd_user_id'
	];
}
