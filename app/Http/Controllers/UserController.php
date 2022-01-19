<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\StorePlanChangeLog;
use App\Models\StorePlan;
use App\Models\TbConpensationLog;
use App\Models\TbSalesmanCpMonthLog;
use App\Models\TbSalesman;
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
    public function edit(Request $request, $id)
    {
        Log::info("### UserController edit START");

        Log::info($request->all());
        // 사용자 유일 조건 ( agentcode+ user_id)
        $User = User::with(array('store_account' => function ($query) {
            $query->with(array('store' => function ($query) {
                $query->with("store_plans");
            }));
        }))->where('id', $id)->first();
        $tbConpensationLog = TbConpensationLog::with('saleman')->where('mobisell_id', $User->username)->orderby('seq_no', 'DESC');
        if ($request['page'] == '1') {
            $tbConpensationLog = $tbConpensationLog->limit(2);
        }
        $tbConpensationLog = $tbConpensationLog->get();

        Log::info($tbConpensationLog);

        $resultData['user'] = $User;
        $resultData['log'] = $tbConpensationLog;
        return response($resultData, Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        Log::info("UserController update START");
        Log::info($id);
        Log::info($request->all());
        $params = $request->input("params");
        Log::info($params);
        DB::beginTransaction();
        try {

            /*
            insert into `store_plan_change_logs` (`stp_id`, `new_expired_date`, `old_expired_date`, `new_purchase_date`, `old_purchase_date`, `updated_at`, `created_at`) values (?, ?, ?, ?, ?, ?, ?) [11, 2022-12-31 23:59:59, 2022-12-17 23:59:59, 2021-01-05 14:53:16, 2021-01-05 14:53:16, 2022-01-14 14:47:34, 2022-01-14 14:47:34]

update `store_plans` set `expired_date` = ?, `add_amount_free_time` = ?, `store_plans`.`updated_at` = ? where `id` = ? [2022-12-31 23:59:59, 0, 2022-01-14 14:47:34, 11]
            */


            //보상 로그 등록
            $tbConpensationLog = new TbConpensationLog;
            $tbConpensationLog->mobisell_id = $params['mobisell_id'];
            $tbConpensationLog->set_cp_month = $params['set_cp_month'];
            $tbConpensationLog->set_cp_day = $params['set_cp_day'];
            $tbConpensationLog->ori_date = $params['ori_date'];
            $tbConpensationLog->set_date = $params['set_date'];
            $tbConpensationLog->cp_memo = $params['cp_memo'];
            $tbConpensationLog->sm_seq_no = session('SSEQNO');
            $tbConpensationLog->user_agent = $_SERVER["HTTP_USER_AGENT"];
            $tbConpensationLog->ip_address = $_SERVER["REMOTE_ADDR"];
            $tbConpensationLog->save();

            //보상 작업
            $storePlanChangeLog = new StorePlanChangeLog;
            $storePlanChangeLog->stp_id = $params['stp_id'];
            $storePlanChangeLog->new_expired_date = $params['new_expired_date'];
            $storePlanChangeLog->old_expired_date = $params['old_expired_date'];
            $storePlanChangeLog->new_purchase_date = $params['new_purchase_date'];
            $storePlanChangeLog->old_purchase_date = $params['old_purchase_date'];
            $storePlanChangeLog->save();

            $storePlan = StorePlan::find($params['stp_id']);
            $storePlan->expired_date = $params['new_expired_date'];
            $storePlan->add_amount_free_time = $params['add_amount_free_time'];
            $storePlan->save();

            //담당자 보상개월수 변경 로그 등록
            $tbSalesmanCpMonthLog = new TbSalesmanCpMonthLog;
            if (session('SADMIN') != 'Y') {
                $tbSalesmanCpMonthLog->old_cp_month_cap = session('SUCP');
                $tbSalesmanCpMonthLog->set_cp_month_cap = session('SUCP') - $params['set_cp_month'];
                $tbSaleman = TbSalesman::find(session('SSEQNO'));
                $tbSaleman->usable_cp_month_cap = session('SUCP') - $params['set_cp_month'];
                $tbSaleman->save();

                session(['SUCP' => $tbSalesmanCpMonthLog->set_cp_month_cap]);
            } else {
                $tbSalesmanCpMonthLog->admin_check = session('SADMIN');
            }
            $tbSalesmanCpMonthLog->sm_seq_no   = session('SSEQNO');
            $tbSalesmanCpMonthLog->cl_seq_no   = $tbConpensationLog->seq_no;
            $tbSalesmanCpMonthLog->reg_sm_seq_no   = session('SSEQNO');
            $tbSalesmanCpMonthLog->save();
        } catch (Exception $e) {
            Log::error($e);
            DB::rollback();
            return  response(['code' => 0, 'message' => $e->getMessage()], Response::HTTP_EXPECTATION_FAILED);
        }

        DB::commit();
        Log::info("### UserController update END");
        return response(['code' => 1, 'message' => null, 'data' => Session()->all()], Response::HTTP_OK);
    }
}
