<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    /** @use HasFactory<\Database\Factories\GenreFactory> */
    use HasFactory;

    public static function inRandomOrder()
    {
    }

    public function movies(){
        return $this->hasMany(Movie::class);
    }

}
