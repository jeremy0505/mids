<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\ItemType;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 * 
 * @property int $category_id
 * @property string $name
 * @property int|null $user_id
 * @property int $client_id
 * @property string $system_or_user
 * @property string|null $system_type
 * @property string|null $user_type
 * @property string $phys_or_digi
 * @property Carbon $cre_date
 * @property int|null $cre_user_id
 * @property Carbon|null $upd_date
 * @property int|null $upd_user_id
 * 
 * @property Collection|ItemType[] $item_types_where_category_id
 *
 * @package App\Models\Base
 */
class Category extends Model
{
	protected $table = 'categories';
	protected $primaryKey = 'category_id';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'client_id' => 'int',
		'cre_user_id' => 'int',
		'upd_user_id' => 'int',
		'cre_date' => 'datetime',
		'upd_date' => 'datetime'
	];


	public function item_types_where_category_id()
	{
		return $this->hasMany(ItemType::class);
	}
}
