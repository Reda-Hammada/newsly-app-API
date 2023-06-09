<?php  
    
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller as Controller;

class BaseController extends Controller 
{
    /**
     * return Success response
     * @param mixed $result (optional)
     * @param string $message
     * @param int $status
     * @return \Illuminate\Http\Response
     */

     public function sendResponse($result = null, string $message, int $status)
     {
         $response =[
                'message' => $message,
                'status'=> $status,
        ];

        if($result !== null):
            $response['data']= $result;
        endif;

        return response()->json($response);
            
     }
     
      /** 
      * return error response
      * @param string $errorMessage
      * @param int $status
      */
     public function sendError(string $errorMessage, int $status)
     {
        $response =[
            'message' => $errorMessage,
            'status'=> $status,
        ];

        return response()->json($response);

     }
}