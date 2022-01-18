<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Pagination\LengthAwarePaginator;
use Exception;
use Log;
use DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = "
        SELECT
            `users`.`id` AS `id`,
            `stores`.`sto_id` AS `sid`,
            `stores`.`sto_name` AS `sto_name`,
            `users`.`username` AS `username`,
            `sp`.expired_date AS expired_date,
            `users`.`created_at` AS `created_at`,
            `users`.`mobigo_user_id` AS `mobigo_user_id`,
            `users`.`group_type` AS `group_type`,
            `users`.`group_code` AS `group_code`,
            `users`.`payment_status` AS `payment_status`,
            `users`.`pay_type` AS `pay_type`,
            `users`.`mobigo_live_start_date` AS `mobigo_live_start_date`,
            `users`.`mobigo_live_end_date` AS `mobigo_live_end_date`,
            `stores`.`sto_addr_line1` AS `sto_addr_line1`,
            `stores`.`sto_addr_line2` AS `sto_addr_line2`,
            `users`.`phone` AS `phone`,
            `stores`.`sto_phone_number` AS `sto_phone_number`,
            `stores`.`sto_mobile_number` AS `sto_mobile_number`
        FROM
            `users`
        JOIN `store_accounts` ON `users`.`id` = `store_accounts`.`uID`
        JOIN `stores` ON `store_accounts`.`storeID` = `stores`.`sto_id`
        LEFT JOIN (
            SELECT
                storeID,
                min(expired_date) as expired_date
            FROM
                store_plans AS sp
            WHERE
                canceled_at IS NULL
            AND expired_date >= now()
            GROUP BY
                storeID
        ) AS sp ON `stores`.`sto_id` = sp.`storeID`
        WHERE
            users.username IS NOT NULL
        AND `users`.`state` = 1";
        if ($request['search']) {
            foreach ($request['search'] as $key => $val) {
                $query .= " AND (`stores`.`sto_name` like '%${val}%' OR `users`.`username` like '%${val}%' OR `users`.`mobigo_user_id` like '%${val}%' OR `stores`.`sto_addr_line1` like '%${val}%' OR `stores`.`sto_addr_line2` like '%${val}%' OR `users`.`phone` like '%${val}%' OR `stores`.`sto_phone_number` like '%${val}%' OR `stores`.`sto_mobile_number` like '%${val}%')";
            }
        }
        Log::info("### UserController INDEX");
        Log::info($request->all());
        $User = DB::select(DB::raw($query));

        $User = $this->arrayPaginator($User, $request);
        log::info($User);
        return response($User->jsonSerialize(), Response::HTTP_OK);
    }

    public function arrayPaginator($array, $request)
    {
        $page = Input::get('page', 1);
        $perPage = 2;
        $offset = ($page * $perPage) - $perPage;

        return new LengthAwarePaginator(
            array_slice($array, $offset, $perPage, true),
            count($array),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        Log::info("### UserController edit START");

        // 사용자 유일 조건 ( agentcode+ user_id)
        $User = User::with(array('store_account' => function ($query) {
            $query->with(array('store' => function ($query) {
                $query->with("store_plans");
            }));
        }))->where('id', $id)->first();

        Log::info($User);

        $resultData = $User;
        return response($resultData, Response::HTTP_OK);
    }
}
