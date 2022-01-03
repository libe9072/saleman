<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 18 Nov 2021 11:28:47 +0900.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class CombineConditionWireProd
 * 
 * @property int $cc_id
 * @property int $wd_id
 * @property string $condition_value
 *
 * @package App\Models
 */
class CombineConditionWireProd extends Eloquent
{
	protected $table = 'combine_condition_wire_prod';
	public $timestamps = false;

	protected $casts = [
		'cc_id' => 'int',
		'wd_id' => 'int'
	];

	protected $fillable = [
		'cc_id',
		'wd_id',
		'condition_value'
	];
}
