<?php 

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class UserController extends BaseController 
{
    /**
     * Register a new user
     * @return \Illuminate\Http\Response
     */

    public function register(Request $request):JsonResponse
    {
        
    }

    /**
     * Log in user
     *  @return \Illuminate\Http\Response

     */
    public function login(Request $request):JsonResponse
    {
        
    }
    /**
     *  Update user data
     *  @param int $userId
     *  @return  @return \Illuminate\Http\Response
     */

     public function updateUserData(Request $request):JsonResponse
     {
        
     }
    
}