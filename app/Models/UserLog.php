<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{

    protected $table = "userlogs";
    use HasFactory;

    protected $guarded = [];
    protected function casts(){
        return
        [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, "userID", "id");
    }

}
