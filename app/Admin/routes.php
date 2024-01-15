<?php

use App\Admin\Controllers\BookingController;
use App\Admin\Controllers\CompanyController;
use App\Admin\Controllers\DepartmentController;
use App\Admin\Controllers\DesignationController;
use App\Admin\Controllers\DestinationController;
use App\Admin\Controllers\EmployeeApproverController;
use App\Admin\Controllers\EmployeeController;
use App\Admin\Controllers\GenderController;
use App\Admin\Controllers\HodController;
use App\Admin\Controllers\IdTypeController;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use OpenAdmin\Admin\Facades\Admin;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {


    $router->get('/', 'HomeController@index')->name('home');
    $router->resource('bookings', BookingController::class);
    $router->resource('employees', EmployeeController::class);
    $router->resource('id-types', IdTypeController::class);
    $router->resource('hods', HodController::class);
    $router->resource('genders', GenderController::class);
    $router->resource('companies', CompanyController::class);
    $router->resource('departments', DepartmentController::class);
    $router->resource('designations', DesignationController::class);
    $router->resource('destinations', DestinationController::class);
    $router->resource('employee-approvers', EmployeeApproverController::class);
    $router->resource('booking-agents', BookingAgentController::class);

});
