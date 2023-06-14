<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\JsonResponse;
use App\Models\Preference;

class PreferenceController extends BaseController { 


    /**
     * fetch preferences
     * @param int $userId
     * @return \Illuminate\Http\Response
     */

     public function index(int $userId):JsonResponse
     {
        
     }

    /**
     * store new preferences author,category,source
     * @param int $userId 
     * @return void
     */

     public function store(Request $request,int $userId):void
     {
        
        $request->validate([
            'categories'=> 'array',
            'categories.*'=>'string',
            'sources'=> 'array',
            'sources.*'=>'string',
            'authors'=> 'array',
            'authors.*'=>'string',
            
        ]);


            
            // get categories after validating them
            $categories = $request->input('categories');
            // loop through all categories and store them
            if(!empty(($categories))){
                foreach($categories as $category):
                    $preference = new Preference();

                    $preference->preferred_category = $category;
                    $preference->user_id = $userId;
                    $preference->save();
                    
            endforeach;
            }
            $sources = $request->input('sources');

            if (!empty($sources)) {
                foreach ($sources as $source) {
                    
                    $preference = new Preference();

                    $preference->preferred_source = $source;
                    $preference->user_id = $userId;
                    $preference->save();
                }
            }

            $authors = $request->input('authors');
            
            if (!empty($authors)) {
                foreach ($authors as $author) {
                    $preference = new Preference();

                    $preference->preferred_author = $author;
                    $preference->user_id = $userId;
                    $preference->save();
                }
            }






        
     }
    
}