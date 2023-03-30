<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models\Base;

use App\Models\Account;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserAccountAccess
 * 
 * @property int $user_account_access_id
 * @property int $user_id
 * @property int $account_id
 * @property int $client_id
 * @property Carbon $date_granted
 * @property string $access_mode
 * @property Carbon $cre_date
 * @property int|null $cre_user_id
 * @property Carbon|null $upd_date
 * @property int|null $upd_user_id
 * 
 * @property User $user
 *
 * @package App\Models\Base
 */
class UserAccountAccess extends Model
{
	protected $table = 'user_account_access';
	protected $primaryKey = 'user_account_access_id';
	public $timestamps = false;

	protected $casts = [
		'user_id' => 'int',
		'account_id' => 'int',
		'client_id' => 'int',
		'cre_user_id' => 'int',
		'upd_user_id' => 'int',
		'date_granted' => 'datetime',
		'cre_date' => 'datetime',
		'upd_date' => 'datetime'
	];



	public function account_id()
	{
		return $this->belongsTo(Account::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
