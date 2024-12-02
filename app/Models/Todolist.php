<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todolist extends Model
{
    protected $table="todolists";
    protected $guarded  =[];
    use HasFactory;
    public function user()
    {
        $this->belongsTo(User::class);
    }
}
