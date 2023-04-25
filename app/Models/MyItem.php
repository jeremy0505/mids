<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use App\Models\Base\MyItem as BaseMyItem;
use Illuminate\Support\Facades\DB;


class MyItem extends BaseMyItem
{
	protected $fillable = [
		'item_type_id',
		'user_id',
		'my_property_id',
		'client_id',
		'version',
		'date_effective_from',
		'date_effective_to',
		'insured_by_my_item_id',
		'name',
		'qty',
		'model_name',
		'mfr',
		'serial_number',
		'purch_date',
		'start_date',
		'expiry_date',
		'price_paid',
		'val_now',
		'val_now_eff_date',
		'val_basis',
		'val_ins_purposes',
		'val_ins_purposes_date',
		'contact_phone',
		'comments',
		'status',
		'property_room_id',
		'num_days_pre_exp_notifs',
		'cre_date',
		'cre_user_id',
		'upd_date',
		'upd_user_id'
	];

}
