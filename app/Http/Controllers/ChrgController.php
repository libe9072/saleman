<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\WiredDevice;
use App\Models\CombineCondition;
use App\Models\CombineConditionWireProd;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Exception;
use Log;
use DB;

class ChrgController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        Log::info("### ChrgController INDEX");
        Log::info($request->all());
        $viewType = $request['viewType'];   //조회구분 
        /* 
            total : 전체 할인 정보 조회 (number, ratePlanType, teenagerNumber)
            internet : 요금대  별  인터넷(랜선) 할인  정보  조회 (number, type)
            line : 요금대  별  회선  할인  정보  조회 (lineNumber, number, ratePlanType)
            teenager : 요금대  별  청소년  할인  정보  조회 (number, teenagerNumber)
        */
        if (!isset($viewType) || empty($viewType)) {
            $viewType = 'total';
        }
        $number = $request['number'];   //결합인원(2~5)
        $ratePlanType = $request['ratePlanType'];   //요금제  가격대
        /*
            130000  // 기본값
            110000
            100000
            90000
            80000
        */
        if (!isset($ratePlanType) || empty($ratePlanType)) {
            $ratePlanType = '130000';
        }
        $teenagerNumber = $request['teenagerNumber'];   //청소년  할인수(0~5) : 기본값 0
        $lineNumber = $request['lineNumber'];   //결합회선  아이디(1~5)
        $type = $request['type'];   //인터넷(랜선)할인  유형(500M, 1G) : 기본값 1G
        if (!isset($type) || empty($type)) {
            $type = '1G';
        }

        $fullArray =  array(
            'SKT' => array(
                'id' => 17,
                'wired' => array(
                    '500M' => 235,
                    '1G' => 236,
                ),
                'wireless' => array(
                    80000 => 3077,
                    90000 => 3058,
                    100000 => 3078,
                    110000 => 3060,
                    130000 => 3060
                ),
                'combineid' => 1
            ),
            'LGU' => array(
                'id' => 18,
                'wired' => array(
                    '500M' => 351,
                    '1G' => 353,
                ),
                'wireless' => array(
                    80000 => 3633,
                    90000 => 2682,
                    100000 => 2683,
                    110000 => 2684,
                    130000 => 3634
                ),
                'combineid' => 17
            ),
            'KT' => array(
                'id' => 19,
                'wired' => array(
                    '500M' => 264,
                    '1G' => 280,
                ),
                'wireless' => array(
                    80000 => 2986,
                    90000 => 2985,
                    100000 => 3002,
                    110000 => 3005,
                    130000 => 3013
                ),
                'combineid' => 6
            ),

        );


        if ($number < 2 || $number > 5) {
            $message['error'] = "결합인원은  2~5명으로  선택해  주세요.";
        }

        if (isset($ratePlanType) && !in_array($ratePlanType, array_keys($fullArray['SKT']['wireless']))) {
            $message['error'] = "조회가능한  요금제  가격대가  아닙니다.";
        }

        if (isset($teenagerNumber)) {
            if ($teenagerNumber > $number) {
                $message['error'] = "청소년  할인  수는  결합인원  수보다  클  수  없습니다.";
            } else if ($teenagerNumber > 5) {
                $message['error'] = "청소년  할인은  5명  이내로  선택해  주세요.";
            }
        }

        if (!in_array($type, array_keys($fullArray['SKT']['wired']))) {
            $message['error'] = "조회가능한  인터넷  할인  유형이  아닙니다.";
        }

        if (isset($lineNumber) && $lineNumber > $number) {
            $message['error'] = "선택한  결합인원  수  보다  많은  회선을  선택할  수  없습니다.";
        }

        if (isset($message['error'])) {
            $message['status'] = "400 BAD_REQUEST";
            $message['details'] = null;
            return json_encode($message, JSON_UNESCAPED_UNICODE);
        } else {
            $telecomeArray = array();   //통신사
            $wiredArray = array(
                '500M' => array(),
                '1G' => array(),
            );  //유선
            $wirelessArray = array();  //무선

            foreach ($fullArray as $key => $value) {
                $telecomeArray[] = $value['id'];
                $wiredArray['500M'][] = $value['wired']['500M'];
                $wiredArray['1G'][] = $value['wired']['1G'];
                $wirelessArray[] = array_values($value['wireless']);
            }
            $wirelessArray = array_merge([], ...$wirelessArray);

            //무선요금제 : 고유번호,통신사,요금제명,월정액
            $Plans =
                Plan::select("id", "name", "cost_display", "classID")->whereIn('id', $wirelessArray);
            $Plans->with(array('plan_classification' => function ($query) use ($telecomeArray) {
                $query->select('id', 'telcomID');
                $query->whereIn('telcomID', $telecomeArray);
            }));
            $Plans = $Plans->get();

            //유선요금제 : 고유번호, 통신사, 요금제명
            $WiredDevices =
                WiredDevice::select(
                    "wd_id",
                    "telcomID",
                    "wd_name"
                )->whereIn('telcomID', $telecomeArray);
            $WiredDevices->whereIn('wd_id', $wiredArray[$type]);
            $WiredDevices = $WiredDevices->get();

            //투게더 결합 할인 조건
            $CombineConditions['LGU'] =
                CombineCondition::select(
                    "condition_default"
                )->where('id', $fullArray['LGU']['combineid']);

            $CombineConditions['LGU'] = $CombineConditions['LGU']->first();
            $CombineData['LGU'] = json_decode($CombineConditions['LGU']->condition_default, true);

            //총액 할인 조건
            $CombineConditions['KT'] =
                CombineConditionWireProd::select(
                    "cc_id",
                    "wd_id",
                    "condition_value"
                )->where('cc_id', $fullArray['KT']['combineid']);
            $CombineConditions['KT'] = $CombineConditions['KT']->where('wd_id', $fullArray['KT']['wired'][$type])->first();
            $CombineData['KT'] = json_decode($CombineConditions['KT']->condition_value, true);

            //온가족플랜 할인 조건
            $CombineConditions['SKT'] =
                CombineConditionWireProd::select(
                    "cc_id",
                    "wd_id",
                    "condition_value"
                )->where('cc_id', $fullArray['SKT']['combineid']);
            $CombineConditions['SKT'] = $CombineConditions['SKT']->where('wd_id', $fullArray['SKT']['wired'][$type])->first();
            $CombineData['SKT'] = json_decode($CombineConditions['SKT']->condition_value, true);


            $details['wireless'] = $Plans;

            foreach ($Plans as $key => $value) {
                $wirelessData[$value->plan_classification->telcomID][$value->id]['name'] = $value->name;
                $wirelessData[$value->plan_classification->telcomID][$value->id]['planPrice'] =
                    floor(round($value->cost_display + ($value->cost_display / 10)) / 10) * 10;
            }

            foreach ($WiredDevices as $key => $value) {
                $wiredData[$value->telcomID][$value->wd_id]['name'] = $value->wd_name;
            }
            $details['wired'] = $WiredDevices;
            $details['combine'] = $CombineData;


            $customData = array();
            $x = 0;
            foreach ($fullArray as $key => $value) {
                $customData[$x]['telecom'] = $key;
                if ($key === 'SKT') {
                    $idiscount = $CombineData['SKT']['basic_condition']['line']['2']['wire_basic_discount_1_line']['value'];
                    //$mdiscount = 0;
                    $mdiscount = $CombineData['SKT']['basic_condition']['line'][$number]['wireless_basic_discount']['value'] / $number;
                } else if ($key === 'LGU') {
                    $idiscount = $CombineData['LGU']['basic_condition']['1']['wire_basic_discount']['value'];
                    $mdiscount = $CombineData['LGU']['basic_condition'][$number - 1]['wireless_basic_discount']['value'];
                } else if ($key === 'KT') {
                    $idiscount = $CombineData['KT']['basic_discount_conditions_group_basic_wire']['line'][1]['wire_basic_discount_1_line']['value'] + $CombineData['KT']['basic_discount_condition'][3]['the_total_basic_discount_of_wire_1_line']['value'];

                    if ($wirelessData[$value['id']][$value['wireless'][$ratePlanType]]['planPrice'] < 108900) {
                        $mdiscount_1 = 5500;
                    } else {
                        $mdiscount_1 = 16610;
                    }
                    $mdiscount = $wirelessData[$value['id']][$value['wireless'][$ratePlanType]]['planPrice'] * ($CombineData['KT']['KT_premium_1_discount_condition_group']['line'][2]['wireless_basic_discount']['value'] / 100);
                }
                for ($i = 1; $i <= $number; $i++) {
                    $customData[$x]['lines'][$i] = array(
                        'lineNumber' => $i,
                        'telecom' => $key,
                        'planName' => $wirelessData[$value['id']][$value['wireless'][$ratePlanType]]['name'],
                        'discount' => $key === 'KT' && $i === 1 ? $mdiscount_1 : $mdiscount,
                        'planPrice' => $wirelessData[$value['id']][$value['wireless'][$ratePlanType]]['planPrice'],
                    );
                }
                if ($viewType === 'line') {
                    $singleLineData[$x] = $customData[$x]['lines'][$lineNumber];
                }
                $customData[$x]['internet'] = array(
                    'internetType' => $type,
                    'telecom' => $key,
                    'internetName' => $wiredData[$value['id']][$value['wired'][$type]]['name'],
                    'discount' => (int)$idiscount
                );
                if ($viewType === 'internet') {
                    if($key==='SKT'){
                        $customData[$x]['internet'] = array(
                            'salediscount' => (int)$mdiscount
                        );
                    }
                    $internetData[$x] = $customData[$x]['internet'];
                }
                $customData[$x]['teenager'] = array(
                    'telecom' => $key,
                    'teenagerNumber' => $key === 'LGU' ? $teenagerNumber : 0,
                    'discount' => $key === 'LGU' ? $teenagerNumber * 10000 : 0
                );
                if ($viewType === 'teenager') {
                    $teenagerData[$x] = $customData[$x]['teenager'];
                }

                $x++;
            }
            if ($viewType === 'internet') {
                $returnData = $internetData;
            } else if ($viewType === 'line') {
                $returnData = $singleLineData;
            } else if ($viewType === 'teenager') {
                $returnData = $teenagerData;
            } else {
                $returnData = $customData;
            }
            $message['result'] = true;
            $message['message'] = 'OK';
            $message['data'] = $returnData;
            return json_encode($message, JSON_UNESCAPED_UNICODE);
        }
    }
}
