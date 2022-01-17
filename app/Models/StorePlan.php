<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 14 Jan 2022 16:49:08 +0900.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class StorePlan
 * 
 * @property int $id
 * @property bool $state
 * @property int $packageID
 * @property int $storeID
 * @property string $coupon_code
 * @property float $package_price
 * @property float $discount_price
 * @property \Carbon\Carbon $purchase_date
 * @property \Carbon\Carbon $expired_date
 * @property bool $payment_status
 * @property bool $payment_method
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $paused_at
 * @property int $add_amount_free_time
 * @property bool $useAlarm
 * @property int $useMonth
 * @property bool $isFree
 * @property string $transaction_id
 * @property string $transaction_status
 * @property string $member_id
 * @property \Carbon\Carbon $canceled_at
 * @property \Carbon\Carbon $start_date
 * @property int $linked_id
 * 
 * @property \App\Models\Store $store
 * @property \App\Models\PricePackage $price_package
 *
 * @package App\Models
 */
class StorePlan extends Eloquent
{
	protected $casts = [
		'state' => 'bool',
		'packageID' => 'int',
		'storeID' => 'int',
		'package_price' => 'float',
		'discount_price' => 'float',
		'payment_status' => 'bool',
		'payment_method' => 'bool',
		'add_amount_free_time' => 'int',
		'useAlarm' => 'bool',
		'useMonth' => 'int',
		'isFree' => 'bool',
		'linked_id' => 'int'
	];

	protected $dates = [
		'purchase_date',
		'expired_date',
		'paused_at',
		'canceled_at',
		'start_date'
	];

	protected $fillable = [
		'state',
		'packageID',
		'storeID',
		'coupon_code',
		'package_price',
		'discount_price',
		'purchase_date',
		'expired_date',
		'payment_status',
		'payment_method',
		'paused_at',
		'add_amount_free_time',
		'useAlarm',
		'useMonth',
		'isFree',
		'transaction_id',
		'transaction_status',
		'member_id',
		'canceled_at',
		'start_date',
		'linked_id'
	];

	public function store()
	{
		return $this->belongsTo(\App\Models\Store::class, 'storeID');
	}
}
