<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Image extends Model
{
    protected $fillable = [
        'image_path',
        'user_id',
    ];
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class);
    }
}