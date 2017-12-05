<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');

    //$router->resource('users', UserController::class);

    //$router->resource('organization/orgs', OrganizationController::class);

    $router->resource('hotel', HotelController::class);
    $router->resource('roomtype', RoomtypeController::class);
    $router->resource('room', RoomController::class);
    $router->resource('salesman', SalesmanController::class);

    $router->resource('corporation', CorporationController::class);
    $router->resource('rate-calendar', RoomratecalendarController::class);
    $router->resource('rate-agreement', RoomrateagreementController::class);
    $router->resource('reserve-room', ReserveroomController::class);

});
