<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\MyItem;
use App\Models\MyNominee;
use App\Models\MyPropertyRoom;
use App\Models\NomineeObjGrant;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MyProperty
 * 
 * @property int $my_property_id
 * @property int $user_id
 * @property int $client_id
 * @property string $friendly_name
 * @property string|null $address1
 * @property string|null $address2
 * @property string|null $city
 * @property string|null $county
 * @property string $country
 * @property string|null $postal_code
 * @property string|null $property_status
 * @property string|null $photo
 * @property string|null $currency
 * @property Carbon $cre_date
 * @property int|null $cre_user_id
 * @property Carbon|null $upd_date
 * @property int|null $upd_user_id
 * 
 * @property User $user
 * @property Collection|MyItem[] $my_items_where_my_property_id
 * @property Collection|MyNominee[] $my_nominees_where_user_id_nominee
 * @property Collection|MyPropertyRoom[] $my_property_rooms_where_my_property_id
 * @property Collection|NomineeObjGrant[] $nominee_obj_grants_where_user_id_nominee
 *
 * @package App\Models\Base
 */
class MyProperty extends Model
{
	protected $table = 'my_properties';
	protected $primaryKey = 'my_property_id';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'client_id' => 'int',
		'cre_user_id' => 'int',
		'upd_user_id' => 'int'
	];

	protected $dates = [
		'cre_date',
		'upd_date'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function my_items_where_my_property_id()
	{
		return $this->hasMany(MyItem::class);
	}

	public function my_nominees_where_user_id_nominee()
	{
		return $this->hasMany(MyNominee::class, 'user_id_nominee', 'user_id');
	}

	public function my_property_rooms_where_my_property_id()
	{
		return $this->hasMany(MyPropertyRoom::class);
	}

	public function nominee_obj_grants_where_user_id_nominee()
	{
		return $this->hasMany(NomineeObjGrant::class, 'user_id_nominee', 'user_id');
	}
}
