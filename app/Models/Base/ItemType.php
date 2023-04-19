<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Category;
use App\Models\ItemTypeExtraField;
use App\Models\MyItem;
use App\Models\RoomType;
use App\Models\SuggestedItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ItemType
 * 
 * @property int $item_type_id
 * @property int|null $user_id
 * @property int $category_id
 * @property int|null $dflt_room_type_id
 * @property int $client_id
 * @property string $name
 * @property string $code
 * @property string|null $include_in_wizard
 * @property string|null $optional_description
 * @property string|null $show_retailer
 * @property string|null $retailer_label
 * @property string|null $show_mfr
 * @property string|null $mfr_label
 * @property string|null $show_model_name
 * @property string|null $model_name_label
 * @property string|null $show_serial_number
 * @property string|null $serial_number_label
 * @property string|null $show_reg_date
 * @property string|null $reg_date_label
 * @property string|null $show_purch_date
 * @property string|null $purch_date_label
 * @property string|null $show_purchase_type
 * @property string|null $purchase_type_label
 * @property string|null $show_start_date
 * @property string|null $start_date_label
 * @property string|null $show_expiry_date
 * @property string|null $expiry_date_label
 * @property string|null $show_cost_initial
 * @property string|null $cost_initial_label
 * @property string|null $show_cost_recurring
 * @property string|null $cost_recurring_label
 * @property string|null $show_cost_recurring_freq
 * @property string|null $cost_recurring_freq_label
 * @property string|null $show_val_now
 * @property string|null $val_now_label
 * @property string|null $show_val_now_eff_date
 * @property string|null $val_now_eff_date_label
 * @property string|null $show_val_basis
 * @property string|null $val_basis_label
 * @property string|null $show_contact_phone
 * @property string|null $contact_phone_label
 * @property Carbon $cre_date
 * @property int|null $cre_user_id
 * @property Carbon|null $upd_date
 * @property int|null $upd_user_id
 * 
 * @property User|null $user
 * @property RoomType|null $dflt
 * @property Collection|ItemTypeExtraField[] $item_type_extra_fields_where_item_type_id
 * @property Collection|MyItem[] $my_items_where_item_type_id
 * @property Collection|SuggestedItem[] $suggested_items_where_item_type_id
 *
 * @package App\Models\Base
 */
class ItemType extends Model
{
	protected $table = 'item_types';
	protected $primaryKey = 'item_type_id';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'category_id' => 'int',
		'dflt_room_type_id' => 'int',
		'client_id' => 'int',
		'cre_date' => 'date',
		'cre_user_id' => 'int',
		'upd_date' => 'date',
		'upd_user_id' => 'int'
	];

	public function category_id()
	{
		return $this->belongsTo(Category::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function dflt()
	{
		return $this->belongsTo(RoomType::class, 'dflt_room_type_id');
	}

	public function item_type_extra_fields_where_item_type_id()
	{
		return $this->hasMany(ItemTypeExtraField::class);
	}

	public function my_items_where_item_type_id()
	{
		return $this->hasMany(MyItem::class);
	}

	public function suggested_items_where_item_type_id()
	{
		return $this->hasMany(SuggestedItem::class);
	}
}
