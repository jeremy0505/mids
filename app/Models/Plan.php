<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

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
 * @property Client $client
 * @property Collection|User[] $users
 *
 * @package App\Models
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
		'date_avail_start',
		'date_avail_end',
		'cre_date',
		'upd_date'
	];

	protected $fillable = [
		'client_id',
		'name',
		'description',
		'date_avail_start',
		'date_avail_end',
		'discounted_months',
		'discounted_fee',
		'revert_to_fee',
		'plan_code',
		'cre_date',
		'cre_user_id',
		'upd_date',
		'upd_user_id'
	];

	public function client()
	{
		return $this->belongsTo(Client::class);
	}

	public function users()
	{
		return $this->belongsToMany(User::class, 'mids_user_plans')
					->withPivot('user_plan_id', 'client_id', 'from_name', 'from_description', 'from_date_avail_start', 'from_date_avail_end', 'from_discounted_months', 'from_discounted_fee', 'from_revert_to_fee', 'cre_date', 'cre_user_id', 'upd_date', 'upd_user_id');
	}
}
