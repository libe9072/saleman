<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 06 Jan 2022 16:03:56 +0900.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class TbSalesmanCpMonthLog
 * 
 * @property int $seq_no
 * @property int $old_cp_month_cap
 * @property int $set_cp_month_cap
 * @property string $admin_check
 * @property int $sm_seq_no
 * @property int $cl_seq_no
 * @property int $reg_sm_seq_no
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class TbSalesmanCpMonthLog extends Eloquent
{
	protected $table = 'tb_salesman_cp_month_log';
	protected $primaryKey = 'seq_no';
	public $timestamps = true;

	protected $casts = [
		'seq_no' => 'int',
		'old_cp_month_cap' => 'int',
		'set_cp_month_cap' => 'int',
		'sm_seq_no' => 'int',
		'cl_seq_no' => 'int',
		'reg_sm_seq_no' => 'int'
	];

	protected $fillable = [
		'old_cp_month_cap',
		'set_cp_month_cap',
		'admin_check',
		'sm_seq_no',
		'cl_seq_no',
		'reg_sm_seq_no'
	];
}
