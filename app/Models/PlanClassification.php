<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 18 Nov 2021 11:27:43 +0900.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class PlanClassification
 * 
 * @property int $id
 * @property int $telcomID
 * 
 * @property \Illuminate\Database\Eloquent\Collection $plans
 *
 * @package App\Models
 */
class PlanClassification extends Eloquent
{
	protected $casts = [
		'telcomID' => 'int'
	];

	protected $fillable = [
		'telcomID'
	];

	public function plans()
	{
		return $this->hasMany(\App\Models\Plan::class, 'classID');
	}
}
