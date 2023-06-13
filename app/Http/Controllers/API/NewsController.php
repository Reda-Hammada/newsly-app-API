<?php

   
namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller as Controller;
use App\Services\NewsApiService;

class NewsController extends Controller
{
    private $newsApiService;
    
    public function __construct(NewsApiService $newsApiService)
    {
        $this->newsApiService = $newsApiService;
    }

     /**
     * @return \Illuminate\Http\Response
     */
    public function getCategories()
    {
        $categories = $this->newsApiService->getCategories();
        return response()->json(['categories'=>$categories , 'status'=> 200]);


    }
}