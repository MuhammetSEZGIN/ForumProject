<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportedComment extends Model
{
    /** @use HasFactory<\Database\Factories\ReportedCommentFactory> */
    use HasFactory;

    protected $table = 'reportedComments';
    protected $fillable = ['commentID', 'userID', 'reason'];
    protected function comment()
    {
        return $this->belongsTo(Comment::class, 'commentID', 'commentID');
    }
    protected function user($class)
    {
        return $this->belongsto(User::class,'userID','id');
    }
    protected function reportedComments()
    {
        return $this->hasMany(ReportedComment::class, 'commentID', 'commentID');
    }
}
