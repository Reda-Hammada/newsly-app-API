<?php 

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\ImageController;

use App\Models\User;

class UserController extends BaseController 
{

    /**
     * @var ImageController
     */
    private $imageController;
    
    public function __construct(ImageController $imageController)
    {
        $this->imageController = $imageController;
    }
    
    /**
     * Register a new user
     * @return \Illuminate\Http\Response
     */

    public function register(Request $request):JsonResponse
    {   
        // get data from the request and validate it
        $fields = $request->validate(
                        [
                            'fullname' => 'string|required',
                            'email' => 'string|required|unique:users,email',
                            'password'=> 'string|required',
                        ]
                    );
        if($fields):
            // create the mew user
            $user = User::create([
                'fullname'=>$fields['fullname'],
                'email'=>$fields['email'],
                'password'=>bcrypt($fields['password']),
                
           ]);
           
            $latestUserId = $user->latest()->value('id');
           
             // call the store method in the image controller to pass the user fullname and id
            $userImage =  $this->imageController->store($user->fullname, $latestUserId);
            
            if($user && $userImage):
                $token = $user->createToken('myapptoken')->plainTextToken;

                $fetchUser = [
                    'id'=> $user->id,
                    'fullname' => $user->fullname,
                    'email' => $user->email,
                    'accessToken' =>$token,
                    'imagePath'=>  $user->image->image_path
                ];
               
               return $this->sendResponse($fetchUser, 'Your Account has been successfully created', 201);
            endif;
        endif;
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