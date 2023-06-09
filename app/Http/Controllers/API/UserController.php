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
                    
        if($fields){
            // create the mew user
            $user = User::create([
                'name'=>$fields['fullname'],
                'email'=>$fields['email'],
                'password'=>bcrypt($fields['password']),
                
           ]);
           
            $latestUserId = $user->latest()->value('id');
          
                
            if($user){
                    
                    // call the store method in the image controller to pass the user fullname and id
                    $this->imageController->store($user->name, $latestUserId);   
                    
                    $accessToken = $user->createToken('myapptoken')->plainTextToken;

                    $fetchUser = [
                        'id'=> $user->id,
                        'fullname' => $user->name,
                        'email' => $user->email,
                        'accessToken' =>$accessToken,
                        'imagePath'=>  $user->image->image_path
                    ];
                
                return $this->sendResponse($fetchUser, 'Your Account has been successfully created', 201);
                
            }
            else{
                
                return $this->sendError('Failed to register user', 400);

                }

            }
        
    }

    /**
     * Log in user
     *  @return \Illuminate\Http\Response

     */
    public function login(Request $request):JsonResponse
    {   
        $fields = $request->validate([
            'email' => 'string|required',
            'password' => 'string|required',
        ]);
        
        
        $User = User::where('email', $fields['email'])->first();


        if($User):

            // check if the password is right 
            $isPasswordTrue = Hash::check($fields['password'], $User->password);

           if($isPasswordTrue):

                $accessToken = $User->createToken('myapptoken')->plainTextToken;
                
                $fetchUser = [
                    'id' =>$User->id,
                    'name'=>$User->name,
                    'imagePath' => $User->image->image_path,
                    'accessToken' => $accessToken,
                ];
                

                return $this->sendResponse($fetchUser ,'You are being logged in ',200);

           endif;


        else:
            return $this->sendError('Email or password invalid', 401);

        endif;
 
    }

   /**
    * log out user and destroy access token
    * @param \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */

    public function logOut(Request $request):JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        return $this->sendResponse();
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