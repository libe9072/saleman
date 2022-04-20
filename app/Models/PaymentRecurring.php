<?php

/**
 * Created by Reliese Model.
 * Date: Wed, 20 Apr 2022 10:32:36 +0900.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class PaymentRecurring
 * 
 * @property int $id
 * @property int $user_id
 * @property string $member_id
 * @property string $payment_kind
 * @property string $price
 * @property string $coupon
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class PaymentRecurring extends Eloquent
{
	protected $table = 'payment_recurring';

	protected $primaryKey = 'id';
	public $timestamps = true;

	protected $casts = [
		'user_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'member_id',
		'payment_kind',
		'price',
		'coupon'
	];
}
