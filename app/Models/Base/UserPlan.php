<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Plan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserPlan
 * 
 * @property int $user_plan_id
 * @property int $user_id
 * @property int $plan_id
 * @property int $client_id
 * @property string|null $from_name
 * @property string|null $from_description
 * @property Carbon|null $from_date_avail_start
 * @property Carbon|null $from_date_avail_end
 * @property int|null $from_discounted_months
 * @property float|null $from_discounted_fee
 * @property float|null $from_revert_to_fee
 * @property Carbon $cre_date
 * @property int|null $cre_user_id
 * @property Carbon|null $upd_date
 * @property int|null $upd_user_id
 * 
 * @property User $user
 *
 * @package App\Models\Base
 */
class UserPlan extends Model
{
	protected $table = 'user_plans';
	protected $primaryKey = 'user_plan_id';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'plan_id' => 'int',
		'client_id' => 'int',
		'from_discounted_months' => 'int',
		'from_discounted_fee' => 'float',
		'from_revert_to_fee' => 'float',
		'cre_user_id' => 'int',
		'upd_user_id' => 'int',
		'from_date_avail_start' => 'datetime',
		'from_date_avail_end' => 'datetime',
		'cre_date'  => 'datetime',
		'upd_date' => 'datetime'
	];



	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function plan_id()
	{
		return $this->belongsTo(Plan::class);
	}
}
