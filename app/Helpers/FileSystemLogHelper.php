<?php

namespace App\Helpers;

use App\Models\FileSystemLog;

class FileSystemLogHelper
{
    /*
     * Action parametresi FileSystemLogHelper içerisinde tanımlı olan değerlerden biri olmalıdır.
     * */
    public static function logAction($action, $fileName, $info="no additional info")
    {

        FileSystemLog::create([
            'file_name' => $fileName,
            'action' => $action,
            'info' => $info,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
