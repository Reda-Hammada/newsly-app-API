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
                    

                    $accessToken = $user->createToken('myapptoken')->plainTextToken;

                    $fetchUser = [
                        'id'=> $user->id,
                        'fullname' => $user->name,
                        'email' => $user->email,
                        'accessToken' =>$accessToken,
                        'imagePath'=>   $user->image ? $user->image->image_path : false
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
    public function login(Request $request): JsonResponse
{
    $fields = $request->validate([
        'email' => 'string|required',
        'password' => 'string|required',
    ]);

    $user = User::where('email', $fields['email'])->first();

    if (!empty($user)) {
        $isPasswordTrue = Hash::check($fields['password'], $user->password);

        if ($isPasswordTrue) {
            $accessToken = $user->createToken('myapptoken')->plainTextToken;

            $fetchUser = [
                'id' => $user->id,
                'fullname' => $user->name,
                'email' => $user->email,
                'imagePath' => $user->image ? $user->image->image_path : false,
                'accessToken' => $accessToken,
            ];

            return $this->sendResponse($fetchUser, 'You are being logged in', 200);
        } else {
            return $this->sendError('Email or password invalid', 401);
        }
    } else {
        return $this->sendError('This user does not exist in our records', 404);
    }
}


   /**
     * update user info 
     *  @param int $userId
     *  @param  \Illuminate\Http\Request  $request
     *  @return \Illuminate\Http\Response
     */

     public function updateUserInfo(Request $request,$userId):JsonResponse
     {
        
        try{
               
             $user = User::findOrFail($userId);
                
 
                 $updatedFields = [];
  
                 // user full name
                 if ($request->filled('fullname')) :
 
                     $request->validate([
                        'fullname' => 'string',
                     ]);
                       
                     $user->name = $request->input('fullname');
                     $user->save();
 
                    $updatedFields[] = 'fullname';
                    
                 endif;
 
                 // user email
                 if ($request->filled('email')):
                     
                     $request->validate([
                         'email' => 'string|email',
                     ]);
                     
                     $user->email = $request->input('email');
                     $user->save();
 
                     $updatedFields[] = 'email';
 
                 endif;
 
                 // user password
                 if ($request->filled('newpass') && $request->filled('currentpassword')):
 
                     $request->validate([
                         'currentpassword'=>'string',
                         'newpass' => 'string',
                     ]);
                      
                     $isPassTrue = Hash::check($request['currentpassword'], $user->password);
                     
                     if($isPassTrue):
 
                         $user->password = bcrypt($request->input('newpass'));
                         $user->save();
     
                         $updatedFields[] = 'password';
                         
                     else:
                         $msg = 'Password is invalid';
                         return response()->json([
                             'msg' => $msg,
                             'status'=>401,
                              
                         ]);
 
                     endif;
 
                 endif;
                 // user image
                //  if():




                //  endif;
                 
                 // keeping track of which fields have been updated to send it through the response to the client
                 if(!empty($updatedFields)):
 
                      if(in_array('email',$updatedFields) && in_array('userfullname', $updatedFields) && in_array('password', $updatedFields)):
                             
                             $msg ='Your personal information has been successfully updated';
 
                             return response()->json([
                                 'msg' => $msg,
                                 'userData'=>$user,
                                 'status' => 200,
                             ]);
                             
                      endif;
 
                      if(in_array('userfullname', $updatedFields)):
                             $msg = 'Your full name has been successfully updated';
 
                             return response()->json([
                                 'msg' => $msg,
                                 'userData'=>$user,
                                 'status' => 200,
                             ]);;
 
                      endif;
                      
                      if(in_array('email', $updatedFields)):
                         
                         $msg = 'Your email has been successfully updated';
 
                         return response()->json([
                                 'msg' => $msg,
                                 'userData'=>$user,
                                 'status' => 200,
                             ]);
 
                  endif;
 
                      if(in_array('password', $updatedFields)):
                         $msg = 'Your password has been successfully changed';
 
                         return response()->json([
                             'msg' => $msg,
                             'userData'=>$user,
                             'status' => 200,
                         ]);
                         
                      endif;
                      
                 endif;
             
                 
        } 
        catch (\Exception $e) {
 
             return response([
                 
                 'error' => $e->getMessage(),
                 'status' => 500,
                 
             ]);
     }
        
         
     }    
    
}