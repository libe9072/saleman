<?php

namespace App\Http\Controllers;

use App\Models\TbSalesman;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Exception;
use Log;
use DB;

class CheckDuplicationDataController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response

     */
    public function index(Request $request)
    {
        Log::info("### CheckDuplicationDataController INDEX START");
        Log::info($request->all());
        $result = self::{$request['type']}($request);
        $resultData = $result->getOriginalContent();
        Log::info("### CheckDuplicationDataController INDEX END");
        return $resultData;
    }

    /**
     * Display a listing of the resource.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function saleman(Request $request)
    {
        Log::info("### CheckDuplicationDataController saleman START");
        Log::info($request->all());
        $duplicate = TbSalesman::where('sm_name', $request['name'])
            ->where('sm_phone', $request['phone']);
        if ($request['seq_no'] > 0) {
            $duplicate->where('seq_no', '<>', $request['seq_no']);
        }
        $duplicate = $duplicate->first();
        Log::info($duplicate);
        if ($duplicate) {
            $message = "입력하신 이름 및 연락처는 이미 등록되어 있습니다.";
            return response(['code' => 0, 'message' => $message], Response::HTTP_OK);
        }
        Log::info("### CheckDuplicationDataController saleman END");
        return response(['code' => 1, 'data' => null], Response::HTTP_OK);
    }
}
