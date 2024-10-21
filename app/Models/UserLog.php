<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{

    protected $table = "userlogs";
    use HasFactory;

    protected function casts(){
        return
        [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',

        ];
    }

}
