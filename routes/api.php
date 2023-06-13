<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
// user routes login & signup 
Route::controller(UserController::class)->group(function(){

    Route::post('/register','register');
    Route::post('/login', 'login');
    
    
});


// guarded APIs routes
Route::group(['middleware'=>['auth:sanctum','throttle:90,1']],function(){
    
    Route::put('/user/{userId}',[UserController::class, 'updateUserData']);


    
});