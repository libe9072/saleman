<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 14 Jan 2022 16:47:06 +0900.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class User
 * 
 * @property int $id
 * @property string $username
 * @property string $email
 * @property string $name
 * @property string $phone
 * @property \Carbon\Carbon $created_at
 * @property bool $state
 * @property string $group_type
 * @property string $group_code
 * @property string $payment_status
 * @property string $pay_type
 * @property string $mobigo_live_start_date
 * @property string $mobigo_live_end_date
 * @property string $mobigo_user_id
 * 
 * @property \App\Models\StoreAccount $store_account
 *
 * @package App\Models
 */
class User extends Eloquent
{
	protected $primaryKey = 'id';
	protected $casts = [
		'state' => 'bool'
	];

	protected $fillable = [
		'username',
		'email',
		'name',
		'phone',
		'state',
		'group_type',
		'group_code',
		'payment_status',
		'pay_type',
		'mobigo_live_start_date',
		'mobigo_live_end_date',
		'mobigo_user_id'
	];

	public function store_account()
	{
		return $this->belongsTo(\App\Models\StoreAccount::class, 'id', 'uID');
	}

	public function payment_recurring()
	{
		return $this->belongsTo(\App\Models\PaymentRecurring::class, 'id', 'user_id');
	}
}
