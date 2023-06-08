<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravolt\Avatar\Avatar;
use App\Models\Image;
class ImageController extends Controller
{
    //
    /**
     * @var Avatar
     */
    private $avatarGenerator;
    public function __construct(Avatar $avatarGenerator)
    {
            $this->$avatarGenerator =  $avatarGenerator;
    }

    /**
     * Store user image in database 
     * @param  string $userFullName 
     * @param int $userId
     * @return void
     */
    public function store(string $userFullName, int $userId):void
    {
            $fullName =  mb_convert_encoding($userFullName,'UTF-8', 'UTF-8');
            $imagePath = $this->avatarGenerator->create($fullName);
            $imagePath->save(public_path('storage/avatars/' . $fullName. '.png'),100);

            Image::create([
                   'image_path'=>$imagePath ,
                   'user_id'=> $userId,
                ]);
            
            
    }
}