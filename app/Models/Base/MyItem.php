<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\ItemType;
use App\Models\MyItemDoc;
use App\Models\MyItemExtraField;
use App\Models\MyProperty;
use App\Models\MyPropertyRoom;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MyItem
 * 
 * @property int $my_item_id
 * @property int $item_type_id
 * @property int $user_id
 * @property int $my_property_id
 * @property int $client_id
 * @property int $version
 * @property Carbon $date_effective_from
 * @property Carbon|null $date_effective_to
 * @property int|null $insured_by_my_item_id
 * @property string|null $name
 * @property int|null $qty
 * @property string|null $model_name
 * @property string|null $mfr
 * @property string|null $serial_number
 * @property Carbon|null $purch_date
 * @property Carbon|null $start_date
 * @property Carbon|null $expiry_date
 * @property int|null $price_paid
 * @property int|null $val_now
 * @property Carbon|null $val_now_eff_date
 * @property string|null $val_basis
 * @property int|null $val_ins_purposes
 * @property Carbon|null $val_ins_purposes_date
 * @property string|null $contact_phone
 * @property string|null $comments
 * @property string $status
 * @property int|null $property_room_id
 * @property int|null $num_days_pre_exp_notifs
 * @property Carbon $cre_date
 * @property int|null $cre_user_id
 * @property Carbon|null $upd_date
 * @property int|null $upd_user_id
 * 
 * @property User $user
 * @property Collection|MyItemDoc[] $my_item_docs_where_my_item_id
 * @property Collection|MyItemExtraField[] $my_item_extra_fields_where_my_item_id
 *
 * @package App\Models\Base
 */
class MyItem extends Model
{
	protected $table = 'my_items';
	protected $primaryKey = 'my_item_id';
	public $timestamps = false;

	protected $casts = [
		'item_type_id' => 'int',
		'user_id' => 'int',
		'my_property_id' => 'int',
		'client_id' => 'int',
		'version' => 'int',
		'insured_by_my_item_id' => 'int',
		'qty' => 'int',
		'price_paid' => 'int',
		'val_now' => 'int',
		'val_ins_purposes' => 'int',
		'property_room_id' => 'int',
		'num_days_pre_exp_notifs' => 'int',
		'cre_user_id' => 'int',
		'upd_user_id' => 'int',
		'date_effective_from' => 'datetime',
		'date_effective_to' => 'datetime',
		'purch_date' => 'datetime',
		'start_date' => 'datetime',
		'expiry_date' => 'datetime',
		'val_now_eff_date' => 'datetime',
		'val_ins_purposes_date' => 'datetime',
		'cre_date' => 'datetime',
		'upd_date' => 'datetime'
	];



	public function item_type_id()
	{
		return $this->belongsTo(ItemType::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function my_property_id()
	{
		return $this->belongsTo(MyProperty::class);
	}

	public function property_room_id()
	{
		return $this->belongsTo(MyPropertyRoom::class, 'property_room_id');
	}

	public function my_item_docs_where_my_item_id()
	{
		return $this->hasMany(MyItemDoc::class);
	}

	public function my_item_extra_fields_where_my_item_id()
	{
		return $this->hasMany(MyItemExtraField::class);
	}
}
