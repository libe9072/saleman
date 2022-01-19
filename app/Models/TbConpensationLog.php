<?php

/**
 * Created by Reliese Model.
 * Date: Thu, 06 Jan 2022 16:03:42 +0900.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class TbConpensationLog
 * 
 * @property int $seq_no
 * @property string $mobisell_id
 * @property int $set_cp_month
 * @property int $set_cp_day
 * @property \Carbon\Carbon $ori_date
 * @property \Carbon\Carbon $set_date
 * @property string $cp_memo
 * @property int $sm_seq_no
 * @property string $user_agent
 * @property string $ip_address
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @package App\Models
 */
class TbConpensationLog extends Eloquent
{
	protected $table = 'tb_conpensation_log';
	protected $primaryKey = 'seq_no';
	public $timestamps = true;

	protected $casts = [
		'seq_no' => 'int',
		'set_cp_month' => 'int',
		'set_cp_day' => 'int',
		'sm_seq_no' => 'int'
	];

	protected $dates = [
		'ori_date',
		'set_date'
	];

	protected $fillable = [
		'mobisell_id',
		'set_cp_month',
		'set_cp_day',
		'ori_date',
		'set_date',
		'cp_memo',
		'sm_seq_no',
		'user_agent',
		'ip_address'
	];

	public function saleman()
	{
		return $this->belongsTo(\App\Models\TbSalesman::class, 'sm_seq_no', 'seq_no');
	}
}
