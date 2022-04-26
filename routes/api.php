<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\UserController as api_user;
use App\Http\Controllers\api\TitleController as api_title;
use App\Http\Controllers\api\AdminController as api_admin;
// use App\Models\Admin;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/test_user', [api_user::class, 'index']);
Route::get('/test_user/{id}', [api_user::class, 'show']);
Route::post('/test_user', [api_user::class, 'store']);
Route::patch('/test_user/{id}', [api_user::class, 'update']);
Route::delete('/test_user/{id}', [api_user::class, 'destroy']);


Route::get('/title', [api_title::class, 'index']);

Route::get('/admin', [api_admin::class, 'index']);
Route::post('/admin', [api_admin::class, 'store']);
Route::patch('/admin/{id}', [api_admin::class, 'update']);


// //測試API
// Route::get('test/{id}', function ($id) {
//     $user = Admin::find($id);
//     return [
//         'site' => 'Laravel学院',
//         'creator' => '学院君',
//         'user' => $user
//     ];
// });