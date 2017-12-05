<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    $api->group(['namespace' => 'App\Api\Controllers'], function ($api) {
        // Endpoints registered here will have the "foo" middleware applied.

        // 组织机构
        $api->get('orgina/{code}','OrganizationsController@getimages');
        // 机构下的所有分店
        $api->get('orgina/{code}/hotels','OrganizationsController@gethotels');

        // 貌似没有用到
        $api->post('user/login', 'AuthController@authenticate');
        $api->post('user/register', 'AuthController@register');

        //预定->可预订房源查询
        $api->post('human/reserve', 'UserController@reserve');
        $api->post('human/reserve_test', 'UserController@reserve_test');
        // 客房预订->下订单
        $api->post('human/reserve-booking', 'UserController@reserve_booking');


        // 温泉，当前酒店信息，及可预订温泉票
        $api->get('reserve/hotspring/{secretcode}','ReserveController@hotspring_ticket_query');
        //预定->可预订温泉票
        //$api->post('reserve/hotspring', 'ReserveController@hotspring_ticket_query');
        // 温泉预订->下订单
        $api->post('reserve/hotspring-booking', 'ReserveController@hotspring_ticket_buy');

        //验证手机号
        $api->post('human/confirmnumbers', 'UserController@confirmnumbers');
        //注册
        $api->post('human/register', 'UserController@register');
        //登陆
        $api->post('human/login', 'UserController@login');
        //个人中心
        $api->post('human/center', 'UserController@center');

        // 需要token
        $api->group(['middleware'=>'jwt.refresh'], function($api){

            $api->get('user/me', 'AuthController@getAuthenticatedUser');

        });

    });

});

