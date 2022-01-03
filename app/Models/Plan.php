<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 18 Nov 2021 11:27:00 +0900.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Plan
 * 
 * @property int $id
 * @property int $classID
 * @property string $name
 * @property float $cost_display
 * 
 * @property \App\Models\PlanClassification $plan_classification
 *
 * @package App\Models
 */
class Plan extends Eloquent
{
	protected $table = 'plan';

	protected $casts = [
		'classID' => 'int',
		'cost_display' => 'float'
	];

	protected $fillable = [
		'classID',
		'cost_display'
	];

	public function plan_classification()
	{
		return $this->belongsTo(\App\Models\PlanClassification::class, 'classID');
	}
}
