<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 18 Nov 2021 11:28:32 +0900.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class CombineCondition
 * 
 * @property int $id
 * @property string $condition_default
 *
 * @package App\Models
 */
class CombineCondition extends Eloquent
{
	public $timestamps = false;

	protected $casts = [];

	protected $fillable = [
		'condition_default'
	];
}
