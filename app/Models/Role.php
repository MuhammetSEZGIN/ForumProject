<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    use HasFactory;
    protected $table = "roles";
    protected $primaryKey = "roleID";
    public function users()
    {
        return $this->belongsTo(User::class,"userID","id" );
    }
}
