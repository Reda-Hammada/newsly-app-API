<?php 

namespace App\Services;

use jcobhams\NewsApi\NewsApi;

/**
 *  this is news api service that will fetch the available categories and sources for to our NewsApi controller serve 
 *  which will fetch the  available categories to our user , so that he can search for the articles and filter the results 
 *
 */
class NewsApiService
{
    private $newsApi;
    private $categoryForSources = 'general';

    public function __construct($apiKey)
    {
        $this->newsApi = new NewsApi($apiKey);
    }

 
    public function getCategories()
    {
        return $this->newsApi->getCategories();
    }

  
}