<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 18 Nov 2021 11:28:16 +0900.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class WiredDevice
 * 
 * @property int $wd_id
 * @property string $wd_name
 * @property int $telcomID
 *
 * @package App\Models
 */
class WiredDevice extends Eloquent
{
	protected $primaryKey = 'wd_id';

	protected $casts = [
		'telcomID' => 'int'
	];

	protected $fillable = [
		'wd_name',
		'telcomID'
	];
}
