<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 14 Jan 2022 16:56:49 +0900.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class StorePlanChangeLog
 * 
 * @property int $id
 * @property int $stp_id
 * @property \Carbon\Carbon $new_expired_date
 * @property \Carbon\Carbon $old_expired_date
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Carbon\Carbon $new_purchase_date
 * @property \Carbon\Carbon $old_purchase_date
 *
 * @package App\Models
 */
class StorePlanChangeLog extends Eloquent
{
	protected $table = 'store_plan_change_logs';
	protected $primaryKey = 'id';
	public $timestamps = true;
	protected $casts = [
		'stp_id' => 'int'
	];

	protected $dates = [
		'new_expired_date',
		'old_expired_date',
		'new_purchase_date',
		'old_purchase_date'
	];

	protected $fillable = [
		'stp_id',
		'new_expired_date',
		'old_expired_date',
		'new_purchase_date',
		'old_purchase_date'
	];
}
