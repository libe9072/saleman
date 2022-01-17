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
 * @property \Carbon\Carbon $email_verified_at
 * @property string $password
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $avatar
 * @property bool $state
 * @property string $cancel_request
 * @property \Carbon\Carbon $last_login_at
 * @property \Carbon\Carbon $last_online_at
 * @property string $password_menu
 * @property bool $type_forgot_pw
 * @property string $option_print
 * @property string $group_type
 * @property string $group_code
 * @property string $payment_status
 * @property string $pay_type
 * @property string $mobigo_live_start_date
 * @property string $mobigo_live_end_date
 * @property string $mobigo_user_id
 * @property bool $is_noti_mobigo
 * 
 * @property \Illuminate\Database\Eloquent\Collection $app_prints
 * @property \Illuminate\Database\Eloquent\Collection $document_likes
 * @property \Illuminate\Database\Eloquent\Collection $login_devices
 * @property \Illuminate\Database\Eloquent\Collection $model_has_permissions
 * @property \Illuminate\Database\Eloquent\Collection $notice_likes
 * @property \App\Models\NotificationUser $notification_user
 * @property \Illuminate\Database\Eloquent\Collection $oauth_access_tokens
 * @property \Illuminate\Database\Eloquent\Collection $oauth_clients
 * @property \App\Models\StoreAccount $store_account
 * @property \App\Models\TokenDevice $token_device
 * @property \Illuminate\Database\Eloquent\Collection $coupons
 * @property \Illuminate\Database\Eloquent\Collection $documents
 * @property \Illuminate\Database\Eloquent\Collection $notices
 *
 * @package App\Models
 */
class User extends Eloquent
{
	protected $casts = [
		'state' => 'bool',
		'type_forgot_pw' => 'bool',
		'is_noti_mobigo' => 'bool'
	];

	protected $dates = [
		'email_verified_at',
		'last_login_at',
		'last_online_at'
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'username',
		'email',
		'name',
		'phone',
		'email_verified_at',
		'password',
		'remember_token',
		'avatar',
		'state',
		'cancel_request',
		'last_login_at',
		'last_online_at',
		'password_menu',
		'type_forgot_pw',
		'option_print',
		'group_type',
		'group_code',
		'payment_status',
		'pay_type',
		'mobigo_live_start_date',
		'mobigo_live_end_date',
		'mobigo_user_id',
		'is_noti_mobigo'
	];

	public function store_account()
	{
		return $this->hasOne(\App\Models\StoreAccount::class, 'uID');
	}
}
