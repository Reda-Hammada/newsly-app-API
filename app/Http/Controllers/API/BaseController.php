<?php  
    
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller as Controller;

class BaseController extends Controller 
{
    /**
     * return Success response
     * @param $result
     * @param string $message
     * @param int $status
     * @return \Illuminate\Http\Response
     */

     public function sendResponse($result, string $message, int $status)
     {
         $response =[
                'data' =>  $result,
                'message' => $message,
                'status'=> $status,
        ];

        return response()->json($response);
            
     }
     
      /** 
      * return error response
      * @param string $errorMessage
      * @param int $status
      */
     public function sendError( string $errorMessage, int $status)
     {
        $response =[
            'message' => $errorMessage,
            'status'=> $status,
        ];

        return response()->json($response);

     }
}