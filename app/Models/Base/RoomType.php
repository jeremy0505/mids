<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\ItemType;
use App\Models\MyPropertyRoom;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RoomType
 * 
 * @property int $room_type_id
 * @property int $client_id
 * @property string $code
 * @property string|null $name
 * @property Carbon $cre_date
 * @property int|null $cre_user_id
 * @property Carbon|null $upd_date
 * @property int|null $upd_user_id
 * @property int|null $seq
 * 
 * @property Collection|ItemType[] $item_types_where_dflt
 * @property Collection|MyPropertyRoom[] $my_property_rooms_where_room_type_id
 *
 * @package App\Models\Base
 */
class RoomType extends Model
{
	protected $table = 'room_types';
	protected $primaryKey = 'room_type_id';
	public $timestamps = false;

	protected $casts = [
		'client_id' => 'int',
		'cre_user_id' => 'int',
		'upd_user_id' => 'int',
		'seq' => 'int',
		'cre_date' => 'datetime',
		'upd_date' => 'datetime'
	];


	public function item_types_where_dflt()
	{
		return $this->hasMany(ItemType::class, 'dflt_room_type_id');
	}

	public function my_property_rooms_where_room_type_id()
	{
		return $this->hasMany(MyPropertyRoom::class);
	}
}
