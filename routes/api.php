<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Middleware\StaffType;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::apiResource('departments', 'Api\DepartmentController');
Route::apiResource('staff', 'Api\StaffController')->middleware(StaffType::class);
Route::apiResource('material', 'Api\MaterialController');
Route::apiResource('users', 'Api\UserController');
Route::apiResource('testimonial', 'Api\testimonialController');
Route::apiResource('course', 'Api\courseController');
Route::apiResource('post', 'Api\PostController');
Route::apiResource('reply', 'Api\replyController');

Route::post('login', 'Api\LoginController@store');
Route::get('logout', 'Api\LoginController@logout')->middleware('auth:sanctum');

Route::post('login/staff', 'Api\StaffLoginController@store');
Route::get('logout/staff', 'Api\StaffLoginController@logout')->middleware('auth:sanctum');
