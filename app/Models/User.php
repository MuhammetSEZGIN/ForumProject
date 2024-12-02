<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'name',
        'email',
        'password',
        'roleID',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function todolists()
    {
        return $this->hasMany(Todolist::class);
    }
    public function articles()
    {
        return $this->hasMany(Article::class);
    }
    public function role()
    {
        return $this->belongsTo(Role::class, "roleID", "id");
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function isAdmin(){
        return $this->role()->where('name','admin')->exists();
    }
    public function isAuthor(){
        return $this->role()->where('name','author')->exists();
    }
    public function userLogs()
    {
        return $this->hasMany(UserLog::class, "userID", "id");
    }

    public function reportedComments()
    {
        return $this->hasMany(ReportedComment::class, 'userID', 'commentID');
    }
}
