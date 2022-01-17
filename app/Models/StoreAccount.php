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
 * @property int $uID
 * @property int $storeID
 * @property int $store_role
 * @property int $device_type
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * 
 *
 * @package App\Models
 */
class Store extends Eloquent
{

    protected $casts = [
        'uID' => 'int',
        'storeID' => 'int',
        'store_role' => 'int',
        'device_type' => 'int'
    ];

    protected $fillable = [];

    public function store()
    {
        return $this->hasOne(\App\Models\Store::class, 'sto_id');
    }
}
