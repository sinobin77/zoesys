<?php

namespace App\Api\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends BaseController
{
    public function confirmnumbers(Request $request)
    {
        if($request->get('mobile_no') == '' || !is_numeric($request->get('mobile_no'))){
            return [
                'code' => 401,
                'msg' => '手机号为空或格式错误',
                'data' => ''
            ];
        }

        $resour = User::where('mobile_no',$request->get('mobile_no'))->get();

        if(!$resour->isEmpty()){
            return [
                'code' => 401,
                'msg' => '该手机号已注册，请直接登陆',
                'data' => ''
            ];
        }

        // 手机短信 验证码
        $yzm = rand(1000,9999);
        return [
            'code' => 200,
            'msg' => 'success',
            'data' => [
                'yzm' => $yzm,
                'expire_time' => 60
            ]
        ];

    }

    public function register(Request $request)
    {
        if($request->get('mobile_no') == '' || $request->get('password') == ''){
            return [
                'code' => 401,
                'msg' => '手机号或密码为空',
                'data' => ''
            ];
        }

        $is_reg = User::where('mobile_no',$request->get('mobile_no'))->get();
        if(!$is_reg->isEmpty()){
            return [
                'code' => 401,
                'msg' => '该手机号已注册，请直接登陆',
                'data' => ''
            ];
        }

        $newUser = [
            'mobile_no' => $request->get('mobile_no'),
            'name' => 'name',
            'password' => md5($request->get('password')),
        ];

        $user = User::create($newUser);

        if($user){
            return [
                'code' => 201,
                'msg' => 'success',
                'data' => $user
            ];
        }

    }

    public function login(Request $request)
    {

        $souc = User::Where('mobile_no',$request->get('mobile_no'))->first();
        if (empty($souc)) {
            return [
                'code' => 401,
                'msg' => '手机号未注册，请先注册后再登陆',
                'data' => ''
            ];
        }

        $data = [
            'mobile_no' => $request->get('mobile_no'),
            'password' => md5($request->get('password')),
        ];

        $resour = User::Where($data)->get();

        if ($resour->isEmpty()) {
            return [
                'code' => 404,
                'msg' => '密码错误',
                'data' => ''
            ];
        }

        return [
            'code' => 200,
            'msg' => 'success',
            'data' => $resour
        ];

    }

    public function center(Request $request){

        $modile_no = $request->get('mobile_no');

        if($modile_no == '' || !is_numeric($modile_no)){
            return [
                'code' => 401,
                'msg' => '手机号为空或格式错误',
                'data' => ''
            ];
        }

        $resour = User::Where('mobile_no',$modile_no)->get();

        if ($resour->isEmpty()) {
            return [
                'code' => 404,
                'msg' => '未找到该用户,请检查你的手机号是否正确',
                'data' => ''
            ];
        }

        return [
            'code' => 200,
            'msg' => 'success',
            'data' => $resour
        ];
    }

    public function reserve_1(Request $request){

        //return phpinfo();
        $hotel_id = $request->get('hotel_id');
        $start_time = "'".$request->get('start_time')."'";
        $end_time = "'".$request->get('end_time')."'";
        $from = "'".$request->get('from')."'";

//        return $start_time;
//        $hotel_id = 1;
//        $start_time = "'"."2017-11-7"."'";
//        $end_time = "'"."2017-11-8"."'";
//        $from = "'"."wx"."'";

        $data = DB::select("CALL sp_reserve_room_bookable($hotel_id, $start_time, $end_time, $from, @return_str)");

        // 存储过程返回值，未检查，未处理
        //$data2 = DB::select("select @return_str");

        return [
            'code' => 200,
            'msg' => 'success',
            'data' => $data
        ];
        //return $data1;
    }

    public function reserve(Request $request){

        $hotel_id = $request->get('hotel_id');
        $start_time = "'".$request->get('start_time')."'";
        $end_time = "'".$request->get('end_time')."'";
        $from = "'".$request->get('from')."'";

        $data = DB::select("CALL sp_reserve_room_bookable($hotel_id, $start_time, $end_time, $from, @return_str)");

        // 房型数组
        $array_room_type = array();
        // 房价数组
        $array_room_rate = array();

        $roomtype_id=0;

        // 是否循环过
        $flag = 0;

        $foreach_seq = 0;

        //$array_room_type = array_add(['name'=>'kk'],'key','value');
        //$array_room_type = array_add(['name'=>'kk'],'key','value');

        foreach ($data as $list)
        {
            $foreach_seq = $foreach_seq + 1;

            // $org_id = $org->org_id;
            //$roomtype_id = $rate_list->roomtype_id;

            // roomtype_id 变化, 且不是第一次循环
            if($roomtype_id<>$list->roomtype_id and $foreach_seq > 1)
            {
                //$room_type = array_add($room_type, $rate_list->roomtype_id);
                //$room_type = array_add($room_type, 'roomtype_id', $rate_list->roomtype_id);
                //$room_type = array_add($room_type, 'roomtype_name', $rate_list->roomtype_name);
                //$room_type = array_prepend($room_type, $rate_list);
                //$room_type = array_push($room_type, $rate_list);

                // $array_room_rate -> $array_room_type
                //array_push($array_room_type, $list->roomtype_id);

                //$array_room_type = array_add(['roomtype_name'=>$list->roomtype_name],'room_rate',$array_room_rate);
                //array_push($array_room_type, $array_room_rate);
                array_push($array_room_type, [
                    'roomtype_id'=>$list->roomtype_id,
                    'roomtype_name'=>$list->roomtype_name,
                    'room_url'=>$list->room_url,
                    'data'=>$array_room_rate]);
                $array_room_rate=array();
            }

            // $list -> $array_room_rate
            array_push($array_room_rate, $list);

            //$array_room_rate = array_prepend($array_room_rate, 'foreach_seq',$foreach_seq);
            //$array_room_rate = array_prepend($array_room_rate, 'foreach_seq',count($data));

            // 如果 $array_room_rate 里有数据，并且 循环到最后了，则写入$array_room_type
            if( count($array_room_rate)>0 and count($data)==$foreach_seq  )
            {
                //array_push($array_room_type, 'end');
                //array_push($array_room_type, ['room_rate'=>$array_room_rate]);
                array_push($array_room_type, [
                    'roomtype_id'=>$list->roomtype_id,
                    'roomtype_name'=>$list->roomtype_name,
                    'room_url'=>$list->room_url,
                    'data'=>$array_room_rate]);
                $array_room_rate=array();
            }

            $roomtype_id = $list->roomtype_id;
        }

        //$data = array_prepend($data, $rate_list);

//        return [
//            $array_room_type
//        ];

        return [
            'code' => 200,
            'msg'  => 'success',
            //'data' => $data
            'data' => $array_room_type
        ];
        //return $data1;
    }

    public function reserve_booking(Request $request){

        //return phpinfo();
        $agreement_type = "'".$request->get('agreement_type')."'";
        $rese_man = $request->get('rese_man');
        $roomtype_id = $request->get('roomtype_id');
        $room_number = $request->get('room_number');
        $original_rate = $request->get('original_rate');
        $room_rate = $request->get('room_rate');

        $arrivel_date = "'".$request->get('arrivel_date')."'";
        $departure_date = "'".$request->get('departure_date')."'";

        $contacts = "'".$request->get('contacts')."'";
        $contact_number = "'".$request->get('contact_number')."'";
        $rese_user_id = $request->get('rese_user_id');

//        $data1 = DB::select("CALL sp_reserve_room_booking (?,?,?,?,?,?,?,?,?,?,?, @return_str)", [
//            $agreement_type, $rese_man,
//            $roomtype_id, $room_number, $original_rate, $room_rate,
//            $arrivel_date, $departure_date, $contacts, $contact_number,
//            $rese_user_id ]);
        $data1 = DB::select("CALL sp_reserve_room_booking($agreement_type, $rese_man,
            $roomtype_id, $room_number, $original_rate, $room_rate,
            $arrivel_date, $departure_date, $contacts, $contact_number,
            $rese_user_id, @return_str)");

        // 存储过程返回值，未检查，未处理
        //$data2 = DB::select("select @return_str");

        //dd( $data1 );

        return [
            'code' => 200,
            'msg' => 'success',
            'data' => $data1
        ];
        //return $data1;
    }
}