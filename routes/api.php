<?php


use App\Http\Controllers\AuthController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\ReviewsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');

Route::apiResource('reviews' , ReviewsController::class)->except(['update', 'index','show']);
Route::apiResource(  'businesses', BusinessController::class)->except(['update']);

Route::post('/reviews/{review}', [ReviewsController::class, 'update']);
Route::post('/businesses/{business}', [BusinessController::class, 'update']);
Route::get('/reviews/{id}', [ReviewsController::class, 'index']);

