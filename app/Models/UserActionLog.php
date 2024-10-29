<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserActionLog extends Model
{
    protected $table = "userActionLogs";
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
