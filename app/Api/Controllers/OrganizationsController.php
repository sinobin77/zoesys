<?php
/**
 * Created by PhpStorm.
 * User: BIN
 * Date: 2017/10/11
 * Time: 14:47
 */

namespace App\Api\Controllers;

//use App\Api\Transformers\OrganizationTransformer;
use App\Hotel;
use App\Organization;
use App\Swiper;

use Illuminate\Routing\Controller;


class OrganizationsController extends BaseController
{

    public function index()
    {

    }

    public function show($code)
    {

        $org = Organization::Where('OrgCode',$code)->get(['OrgCode','OrgName','OrgLevel']);

        return [
            'code' => 200,
            'mes' => 'success',
            'data' => $org
        ];
    }

    public function hotels($code)
    {
        $orgs = Organization::where('OrgCode',$code)->get(['OrgID']);

        foreach ($orgs as $org) {
            $OrgID = $org->OrgID;
        }

        $hotels = Hotel::where('OrgID',$OrgID)->orderBy('IsDefault','DESC')->get();

        //return $hotels;
        return $this->response->error('This is an error.', 404);
    }


    public function getimages($code){

        $org_id = 0;
        $orgs = Organization::Where('wx_secret',$code)->get(['org_id']);

        if ($orgs->isEmpty()) {
            return [
                'code' => 404,
                'msg' => 'error',
                'data' => ''
            ];
        }

        // 确定 org_id
        foreach ($orgs as $org) {
            $org_id = $org->org_id;
        }

        // 为啥不使用ID查询信息？
        // $org_info = Organization::Where('wx_secret',$code)->get();
        $org_info = Organization::where('org_id',$org_id)->get();

        $hotels = Swiper::where('org_id',$org_id)->orderBy('show_order','ASC')->get(['show_order','pic_url','link_url']);

        return [
            //'test' => $orgs,
            //'test2' => $info,
            //'test3' => $info->org_id,
            'code' => 200,
            'msg' => 'success',
            'data' => [
                'images' =>$hotels,
                'info' => $org_info
            ]
        ];
    }


    public function gethotels($code)
    {
        $orgs = Organization::where('wx_secret',$code)->get(['org_id']);

        if ($orgs->isEmpty()) {
            return [
                'code' => 404,
                'msg' => 'error',
                'data' => ''
            ];
        }

        foreach ($orgs as $org) {
            $org_id = $org->org_id;
        }

        $hotels = Hotel::where('org_id',$org_id)->orderBy('is_default','DESC')->get(
            ['hotel_id','hotel_code','hotel_name','hotel_setting','is_default','lat','lng','hotel_address']);

        return [
            'code' => 200,
            'msg' => 'success',
            'data' => $hotels
        ];
    }


}