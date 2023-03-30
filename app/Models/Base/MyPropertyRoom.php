<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\MyItem;
use App\Models\MyProperty;
use App\Models\RoomType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MyPropertyRoom
 * 
 * @property int $property_room_id
 * @property int|null $my_property_id
 * @property int $room_type_id
 * @property int $client_id
 * @property string|null $room_name
 * @property string|null $comments
 * @property Carbon $cre_date
 * @property int|null $cre_user_id
 * @property Carbon|null $upd_date
 * @property int|null $upd_user_id
 * 
 * @property Collection|MyItem[] $my_items_where_my
 * @property Collection|MyItem[] $my_items_where_property_room_id
 *
 * @package App\Models\Base
 */
class MyPropertyRoom extends Model
{
	protected $table = 'my_property_rooms';
	protected $primaryKey = 'property_room_id';
	public $timestamps = false;

	protected $casts = [
		'my_property_id' => 'int',
		'room_type_id' => 'int',
		'client_id' => 'int',
		'cre_user_id' => 'int',
		'upd_user_id' => 'int',
		'cre_date' => 'datetime',
		'upd_date' => 'datetime'
	];



	public function my_property_id()
	{
		return $this->belongsTo(MyProperty::class);
	}

	public function room_type_id()
	{
		return $this->belongsTo(RoomType::class);
	}

	public function my_items_where_my()
	{
		return $this->hasMany(MyItem::class);
	}

	public function my_items_where_property_room_id()
	{
		return $this->hasMany(MyItem::class, 'property_room_id');
	}
}
