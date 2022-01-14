<?php

namespace App\Http\Controllers;

use App\Models\TbSalesman;
use App\Models\TbSalesmanCpMonthLog;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Exception;
use Log;
use DB;

class TbSalesmanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Log::info("### TbSalesmanController INDEX");
        Log::info($request->all());
        $tbSalesman = TbSalesman::orderBy('seq_no', 'DESC');
        $tbSalesman = $tbSalesman->paginate(2, ['*'], 'page', $request['page']);
        return response($tbSalesman->jsonSerialize(), Response::HTTP_OK);
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Log::info("### TbSalesmanController store");
        Log::info($request->all());
        $params = $request->input(['param']);

        DB::beginTransaction();
        try {
            $tbSalesman = new TbSalesman;
            $tbSalesman->fill($params);
            $tbSalesman->sm_pw = DB::raw("PASSWORD('dkzm2021')");
            $tbSalesman->usable_cp_month_cap = 0;
            $tbSalesman->sm_status = "Y";
            $tbSalesman->save();

            //담당자 보상개월수 변경 로그 등록
            $tbSalesmanCpMonthLog = new TbSalesmanCpMonthLog;
            $tbSalesmanCpMonthLog->old_cp_month_cap = 0;
            $tbSalesmanCpMonthLog->set_cp_month_cap = 0;
            $tbSalesmanCpMonthLog->admin_check  = $request['is_admin'];
            $tbSalesmanCpMonthLog->sm_seq_no   = $tbSalesman->seq_no;
            $tbSalesmanCpMonthLog->reg_sm_seq_no   = session('SSEQNO');
            $tbSalesmanCpMonthLog->save();

            Log::info($tbSalesman);
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollback();
            return  response(0, Response::HTTP_EXPECTATION_FAILED);
        }

        DB::commit();
        return response($tbSalesman, Response::HTTP_OK);
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
        Log::info("### TbSalesmanController edit START");

        // 사용자 유일 조건 ( agentcode+ user_id)
        $tbSalesman = TbSalesman::find($id);

        Log::info($tbSalesman);

        $resultData['tbSalesman'] = $tbSalesman;
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
        Log::info("TbSalesmanCoontroller update START");
        Log::info($id);
        Log::info($request->all());
        $params = $request->input(['params']);
        if (isset($params['type']) === false) {
            DB::beginTransaction();
            try {
                $tbSalesman = TbSalesman::find($id);
                $tbSalesman->fill($params);
                $dirtyData = $tbSalesman->getDirty();
                if (isset($dirtyData['is_admin']) === true || isset($dirtyData['usable_cp_month_cap']) === true) {
                    //담당자 보상개월수 변경 로그 등록
                    $tbSalesmanCpMonthLog = new TbSalesmanCpMonthLog;
                    $tbSalesmanCpMonthLog->old_cp_month_cap = $request['usable_cp_month_cap'];
                    $tbSalesmanCpMonthLog->set_cp_month_cap = $params['usable_cp_month_cap'];
                    $tbSalesmanCpMonthLog->admin_check  = $params['is_admin'];
                    $tbSalesmanCpMonthLog->sm_seq_no   = $id;
                    $tbSalesmanCpMonthLog->reg_sm_seq_no   = session('SSEQNO');
                    $tbSalesmanCpMonthLog->save();
                }
                $tbSalesman->save();
            } catch (\Exception $e) {
                Log::error($e);
                DB::rollback();

                return  response(0, Response::HTTP_EXPECTATION_FAILED);
            }

            DB::commit();
            Log::info("TbSalesmanController update END");
            return response($tbSalesman, Response::HTTP_OK);
        } else {
            Log::info("### TbSalesmanController update another function");
            $result = self::{$id}($request);
            $resultCode = $result->getOriginalContent();
            return $resultCode;
        }
    }

    /**
     * reset password.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resetPassword(Request $request)
    {
        Log::info("### TbSalesmanController resetPassword ###");
        Log::info($request->all());
        $seq_no = $request->input("seq_no");

        DB::beginTransaction();
        try {
            $tbSalesman = TbSalesman::find($seq_no);
            $tbSalesman->sm_pw = DB::raw("PASSWORD('dkzm2021')");
            $tbSalesman->save();
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollback();
            return  response(0, Response::HTTP_EXPECTATION_FAILED);
        }

        DB::commit();
        return response(1, Response::HTTP_OK);
    }

    /**
     * change password.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Request $request)
    {
        Log::info("### TbSalesmanController resetPassword ###");
        Log::info($request->all());
        $seq_no = session()->get('SSEQNO');
        $new_pw = $request->input("new_pw");
        Log::info(Session()->all());

        DB::beginTransaction();
        try {
            $tbSalesman = TbSalesman::find($seq_no);
            $tbSalesman->sm_pw = DB::raw("PASSWORD('" . $new_pw . "')");
            $tbSalesman->save();
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollback();
            return  response(0, Response::HTTP_EXPECTATION_FAILED);
        }

        DB::commit();
        return response(1, Response::HTTP_OK);
    }
    /**
     * check current password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function checkCurrentPassword(Request $request)
    {
        Log::info("### TbSalesmanController checkCurrentPassword START");
        Log::info($request->all());
        $seq_no = session()->get('SSEQNO');
        $sm_pw = $request->input("sm_pw");
        $tbSalesman = TbSalesman::where('seq_no', $seq_no)->where("sm_pw", DB::raw("password('" . $sm_pw . "')"))->first();

        Log::info($tbSalesman);

        if (empty($tbSalesman) === true) {
            return response(['code' => 0, 'message' => '현재 비밀번호가 일치하지 않습니다.'], Response::HTTP_OK);
        }
        return response(['code' => 1, 'message' => null], Response::HTTP_OK);
    }

    /**
     * login.
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function loginSaleman(Request $request)
    {
        Log::info("### TbSalesmanController loginSaleman ###");
        Log::info($request->all());
        $sm_name = $request->input("sm_name");
        $sm_phone = $request->input("sm_phone");
        $sm_pw = $request->input("sm_pw");

        $tbSalesman = TbSalesman::where('sm_name', $sm_name)->where('sm_phone', $sm_phone)->first();
        $password = TbSalesman::selectRaw("PASSWORD('" . $sm_pw . "') as pw")->where('seq_no', '>', 0)->first();
        Log::info($password);

        if (isset($tbSalesman->seq_no)) {
            if ($tbSalesman->sm_status != 'Y') {
                return  response(['code' => 0, 'message' => "사용 정지된 계정입니다. 관리자에게 문의하세요."], Response::HTTP_EXPECTATION_FAILED);
            } else if ($tbSalesman->sm_pw != $password->pw) {
                Log::info($tbSalesman->sm_pw . "//" . DB::raw("PASSWORD('" . $sm_pw . "')"));
                return  response(['code' => 0, 'message' => "비밀번호가 일치하지 않습니다."], Response::HTTP_EXPECTATION_FAILED);
            } else {
                session(['SSEQNO' => $tbSalesman->seq_no]); // 고유번호
                session(['SNAME' => $tbSalesman->sm_name]); // 이름
                session(['SUCP' => $tbSalesman->usable_cp_month_cap]); // 잔여기간
                session(['SADMIN' => $tbSalesman->is_admin]); // 어드민접속여부
                return  response(['code' => 0], Response::HTTP_EXPECTATION_FAILED);
            }
        } else {
            return  response(['code' => 0, 'message' => "존재하지 않는 계정입니다. 다시 시도해 주세요."], Response::HTTP_EXPECTATION_FAILED);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showMid($id)
    {
        Log::info("### TbSalesmanController showMid START" . session()->get('SSEQNO'));
        $mixVersion = mix('js/app.js');
        if (empty(session()->get('SSEQNO'))) {
            session()->flush();
        }
        $dataArray = array(
            'mixVersion' => (string)$mixVersion,
            'sessionData' => Session()->all()
        );
        Log::info("### TbSalesmanController showMid END" . session()->get('SSEQNO'));
        return response($dataArray, Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Log::info("TbSalesmanController DESTROY START");
        Log::info($id);
        DB::beginTransaction();
        try {
            $tbSalesman = TbSalesman::find($id);
            $tbSalesman->delete();
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollback();

            return  response(0, Response::HTTP_EXPECTATION_FAILED);
        }

        DB::commit();
        Log::info("TbSalesmanCoontroller DESTROY END");
        return response($id, Response::HTTP_OK);
    }
}
