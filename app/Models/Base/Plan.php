<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Client;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Plan
 * 
 * @property int $plan_id
 * @property int $client_id
 * @property string|null $name
 * @property string|null $description
 * @property Carbon|null $date_avail_start
 * @property Carbon|null $date_avail_end
 * @property int|null $discounted_months
 * @property float|null $discounted_fee
 * @property float|null $revert_to_fee
 * @property string $plan_code
 * @property Carbon $cre_date
 * @property int|null $cre_user_id
 * @property Carbon|null $upd_date
 * @property int|null $upd_user_id
 * 
 * @property Collection|User[] $users
 *
 * @package App\Models\Base
 */
class Plan extends Model
{
	protected $table = 'plans';
	protected $primaryKey = 'plan_id';
	public $timestamps = false;

	protected $casts = [
		'client_id' => 'int',
		'discounted_months' => 'int',
		'discounted_fee' => 'float',
		'revert_to_fee' => 'float',
		'cre_user_id' => 'int',
		'upd_user_id' => 'int',
		'date_avail_start' => 'datetime',
		'date_avail_end' => 'datetime',
		'cre_date' => 'datetime',
		'upd_date' => 'datetime'
	];


	public function client_id()
	{
		return $this->belongsTo(Client::class);
	}

	public function users()
	{
		return $this->belongsToMany(User::class, 'mids_user_plans')
					->withPivot('user_plan_id', 'client_id', 'from_name', 'from_description', 'from_date_avail_start', 'from_date_avail_end', 'from_discounted_months', 'from_discounted_fee', 'from_revert_to_fee', 'cre_date', 'cre_user_id', 'upd_date', 'upd_user_id');
	}
}
