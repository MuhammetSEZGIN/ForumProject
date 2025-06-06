<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    use HasFactory;
    protected $table = "comments";
    protected $primaryKey = "commentID";
    protected $guarded = [];


    public function user()
    {
        return $this->belongsTo(User::class, "userID", "id");
    }
    public function article()
    {
        return $this->belongsTo(Article::class , "articleID", "articleID");
    }

}
