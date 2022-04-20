<?php

/**
 * Created by Reliese Model.
 * Date: Fri, 14 Jan 2022 16:48:26 +0900.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model as Eloquent;

/**
 * Class Store
 * 
 * @property int $sto_id
 * @property bool $sto_state
 * @property int $sto_business_type
 * @property string $sto_business_no
 * @property string $sto_business_email
 * @property string $sto_business_name
 * @property string $sto_name
 * @property string $sto_phone_number
 * @property string $sto_mobile_number
 * @property string $sto_fax_number
 * @property string $sto_addr_line1
 * @property string $sto_addr_line2
 * @property string $sto_bank_account
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property string $sto_addr_code
 * 
 * @property \App\Models\StoreAccount $store_account
 * @property \Illuminate\Database\Eloquent\Collection $store_plans
 *
 * @package App\Models
 */
class Store extends Eloquent
{
	protected $primaryKey = 'sto_id';

	protected $casts = [
		'sto_state' => 'bool',
		'sto_business_type' => 'int'
	];

	protected $fillable = [
		'sto_state',
		'sto_business_type',
		'sto_business_no',
		'sto_business_email',
		'sto_business_name',
		'sto_name',
		'sto_phone_number',
		'sto_mobile_number',
		'sto_fax_number',
		'sto_addr_line1',
		'sto_addr_line2',
		'sto_bank_account',
		'sto_addr_code'
	];

	public function store_account()
	{
		return $this->hasOne(\App\Models\StoreAccount::class, 'storeID');
	}

	public function store_plans()
	{
		return $this->hasMany(\App\Models\StorePlan::class, 'storeID');
	}

	public function store_plansLast()
	{
		return $this->hasOne(\App\Models\StorePlan::class, 'storeID')
			->where(function ($query) {
				$query->whereNull('store_plans.canceled_at')
					->Where('store_plans.expired_date', '>=', 'now()');
			});
	}
}
