<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

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
            $this->avatarGenerator =  $avatarGenerator;
    }

    /**
     * Store user image in database 
     * @param  string $userFullName 
     * @param int $userId
     * @return void
     */
    public function store(string $userFullName, int $userId):void
    {
           
        $fullName = mb_convert_encoding($userFullName, 'UTF-8', 'UTF-8');
        $imagePath = $this->avatarGenerator->create($fullName);

        // Save the image file
        $storagePath = '/app/public/avatars/';
        $imageName = $fullName . '.png';
        $imagePath->save(storage_path($storagePath . $imageName), 100);

        // Store the image path in the database
        $image = new Image();
        $image->image_path = $storagePath . $imageName;
        $image->user_id = $userId;
        $image->save();
            
    
        }

}