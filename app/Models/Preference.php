<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Preference extends Model
{
    use HasFactory;
    protected $fillable = [
      'preferred_category',
      'preferred_source',
      'preferred_author',
  ];
   public function User(){
     return  $this->belongsTo(User::class);
   }
}