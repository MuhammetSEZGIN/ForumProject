<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileSystemLog extends Model
{

    use HasFactory;
    protected $table = 'fileSystemLogs';
    protected $fillable = ['file_name', 'action', 'ip'];
}
