<?php

namespace App\Models;

use App\Models\Base\ItemType as BaseItemType;

class ItemType extends BaseItemType
{
	protected $fillable = [
		'user_id',
		'category_id',
		'dflt_room_type_id',
		'client_id',
		'name',
		'code',
		'include_in_wizard',
		'optional_description',
		'show_retailer',
		'retailer_label',
		'show_mfr',
		'mfr_label',
		'show_model_name',
		'model_name_label',
		'show_serial',
		'serial_label',
		'show_purch_date',
		'purch_date_label',
		'show_start_date',
		'start_date_label',
		'show_expiry_date',
		'expiry_date_label',
		'show_price_paid',
		'price_paid_label',
		'show_val_now',
		'val_now_label',
		'show_val_now_eff_date',
		'val_now_eff_date_label',
		'show_val_basis',
		'val_basis_label',
		'show_val_ins_purposes',
		'val_ins_purposes_label',
		'show_val_ins_purposes_date',
		'val_ins_purposes_date_label',
		'show_contact_phone',
		'contact_phone_label',
		'cre_date',
		'cre_user_id',
		'upd_date',
		'upd_user_id'
	];
}
