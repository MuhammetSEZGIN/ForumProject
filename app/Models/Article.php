<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{

    use HasFactory;
    protected $table = "articles";
    protected $primaryKey = "articleID";
    public function user()
    {
        return $this->belongsTo(User::class, "authorID", "id");
    }
    public function category()
    {
        return $this->belongsToMany(Category::class, "article__category", "articleID", "categoryID");
    }
    public function comments()
    {
        return $this->hasMany(Comment::class, "articleID", "articleID");
    }

}
