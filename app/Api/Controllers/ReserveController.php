<?php
/**
 * Created by PhpStorm.
 * User: BIN
 * Date: 2017/11/27
 * Time: 13:54
 */

namespace App\Api\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Hotel;
use App\Models\Reserve_hotspring;

class ReserveController extends BaseController
{
    // 温泉预订ticket查询
    public function hotspring_ticket_query($secretcode){

        // 检查
//
//        if ($secretcode ) {
//            return [
//                'code' => 404,
//                'msg' => 'error',
//                'data' => ''
//            ];
//        }

        //$hotel_id = $request->get('hotel_id');
        $hotel = Hotel::where('wx_secret',$secretcode)->first();

        if (!$hotel)
        {
            return [
                'code' => 404,
                'msg' => 'error',
                'data' => '无此酒店'
            ];
        }

        $hotel_id = $hotel->hotel_id;



        //$start_time = "'".$request->get('start_time')."'";
        //$end_time = "'".$request->get('end_time')."'";
        //$from = "'".$request->get('from')."'";

        // 有价格日历的方式->找最低价格
//        $data = DB::select("SELECT T.ticket_id, T.ticket_name, C.min_rate FROM s_hotspring_ticket T ".
//            "LEFT JOIN ( ".
//	        "SELECT DISTINCT ticket_id, MIN(current_rate) AS min_rate ".
//	        "FROM s_hotspring_calendar ".
//	        "GROUP BY ticket_id ".
//            ") C ON T.ticket_id = C.ticket_id ".
//            "WHERE T.hotel_id = :hotel_id", ['hotel_id' => $hotel_id] );

        // 读取酒店信息
        $data_hotel = DB::select("SELECT hotel_id, hotel_name, hotel_address, lat,lng FROM m_hotel ".
            "WHERE hotel_id = :hotel_id", ['hotel_id' => $hotel_id] );

        // 直接读取原价
        $data_hotspring_ticket = DB::select("SELECT ticket_id, ticket_name, original_rate FROM s_hotspring_ticket ".
            "WHERE hotel_id = :hotel_id", ['hotel_id' => $hotel_id] );

//        // 房型数组
//        $array_room_type = array();
//        // 房价数组
//        $array_room_rate = array();
//
//        $roomtype_id=0;
//
//        // 是否循环过
//        $flag = 0;
//
//        $foreach_seq = 0;
//
//        foreach ($data as $list)
//        {
//            $foreach_seq = $foreach_seq + 1;
//
//            // roomtype_id 变化, 且不是第一次循环
//            if($roomtype_id<>$list->roomtype_id and $foreach_seq > 1)
//            {
//
//                array_push($array_room_type, [
//                    'roomtype_id'=>$list->roomtype_id,
//                    'roomtype_name'=>$list->roomtype_name,
//                    'room_url'=>$list->room_url,
//                    'data'=>$array_room_rate]);
//                $array_room_rate=array();
//            }
//
//            array_push($array_room_rate, $list);
//
//            // 如果 $array_room_rate 里有数据，并且 循环到最后了，则写入$array_room_type
//            if( count($array_room_rate)>0 and count($data)==$foreach_seq  )
//            {
//                array_push($array_room_type, [
//                    'roomtype_id'=>$list->roomtype_id,
//                    'roomtype_name'=>$list->roomtype_name,
//                    'room_url'=>$list->room_url,
//                    'data'=>$array_room_rate]);
//                $array_room_rate=array();
//            }
//
//            $roomtype_id = $list->roomtype_id;
//        }

        return [
            'code' => 200,
            'msg'  => 'success',
            'data_hotel' => $data_hotel,
            'data' => $data_hotspring_ticket
            //'data' => $array_room_type
        ];
    }


    public function hotspring_ticket_buy(Request $request){

        $Rese_hotspring = new Reserve_hotspring;

        $Rese_hotspring->ticket_id = $request->ticket_id;
        $Rese_hotspring->quantity = $request->quantity;
        $Rese_hotspring->rese_man = $request->rese_man;
        $Rese_hotspring->original_rate = 0;
        $Rese_hotspring->current_rate = $request->current_rate;

        $Rese_hotspring->arrivel_date = $request->arrivel_date;
        $Rese_hotspring->contacts = $request->contacts;
        $Rese_hotspring->contact_number = $request->contact_number;


        // 检查 Request数据


        // 保存
        $Rese_hotspring->save();


        return [
            'code' => 200,
            'msg' => 'success',
            'data' => $Rese_hotspring->rese_spring_id
        ];

    }
}