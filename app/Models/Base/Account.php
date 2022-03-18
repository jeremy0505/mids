<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Account
 * 
 * @property int $account_id
 * @property int $account_owner_user_id
 * @property int $client_id
 * @property string $account_code
 * @property Carbon $cre_date
 * @property int|null $cre_user_id
 * @property Carbon|null $upd_date
 * @property int|null $upd_user_id
 * 
 * @property User $account_owner_user
 * @property Collection|User[] $users
 *
 * @package App\Models\Base
 */
class Account extends Model
{
	protected $table = 'accounts';
	protected $primaryKey = 'account_id';
	public $timestamps = false;

	protected $casts = [
		'account_owner_user_id' => 'int',
		'client_id' => 'int',
		'cre_user_id' => 'int',
		'upd_user_id' => 'int'
	];

	protected $dates = [
		'cre_date',
		'upd_date'
	];

	public function account_owner_user()
	{
		return $this->belongsTo(User::class, 'account_owner_user_id');
	}

	public function users()
	{
		return $this->belongsToMany(User::class, 'user_account_access')
					->withPivot('user_account_access_id', 'client_id', 'date_granted', 'access_mode', 'cre_date', 'cre_user_id', 'upd_date', 'upd_user_id');
	}
}
