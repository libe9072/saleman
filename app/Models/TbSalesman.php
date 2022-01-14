<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 06 Jan 2022 16:03:13 +0900.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TbSalesman
 * 
 * @property int $seq_no
 * @property string $sm_phone
 * @property string $sm_name
 * @property string $sm_pw
 * @property string $sm_company
 * @property string $sm_memo
 * @property string $is_admin
 * @property int $usable_cp_month_cap
 * @property string $sm_status
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $deleted_at
 *
 * @package App\Models
 */
class TbSalesman extends Eloquent
{
	protected $table = 'tb_salesman';
	protected $primaryKey = 'seq_no';
	public $timestamps = true;
	use SoftDeletes;

	protected $casts = [
		'usable_cp_month_cap' => 'int'
	];

	protected $fillable = [
		'sm_phone',
		'sm_name',
		'sm_company',
		'sm_memo',
		'is_admin',
		'usable_cp_month_cap',
		'sm_status',
		'sm_pw'
	];
}
