<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\NewsController;
use App\Http\Controllers\API\PreferenceController;

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

// get available categories and sources
Route::get('/categories', [NewsController::class, 'getCategories']);
Route::get('/sources', [NewsController::class, 'getSources']);


// user routes login & signup 
Route::controller(UserController::class)->group(function(){

    Route::post('/register','register');
    Route::post('/login', 'login');
    
    
});



// guarded APIs routes
Route::group(['middleware'=>['auth:sanctum','throttle:90,1']],function(){
    // user protected routes
    Route::put('/user/{userId}',[UserController::class, 'updateUserData']);
    // preferences routes
    Route::post('/preferences/{userId}', [PreferenceController::class,'store']);


    
});