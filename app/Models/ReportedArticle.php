<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportedArticle extends Model
{
    /** @use HasFactory<\Database\Factories\ReportedArticleFactory> */
    use HasFactory;
    protected $fillable = ['articleID', 'userID', 'reason'];
    protected $table = 'reportedArticles';

    protected function article()
    {
        return $this->belongsTo(Article::class, 'articleID', 'articleID');
    }
    protected function user()
    {
        return $this->belongsTo(User::class, 'userID', 'id');
    }
}
