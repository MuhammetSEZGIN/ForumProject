<?php

namespace App\Http\Controllers;

use App\Helpers\UserActionLogHelper;
use App\Helpers\UserLogEnum;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\User;
use App\Models\UserLog;
use App\Modules\FileHandlers\ExcelHandler;
use App\Modules\FileHandlers\PdfHandler;
use App\Services\FileService;
use App\Services\FtpService;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Shuchkin\SimpleXLSX;


class FileController extends Controller
{

    public function test()
    {
        //Storage::put('test.txt', 'Hello World');
        try {
            $data = "Bu, FTP sunucusuna yazılacak basit bir metin dosyası içeriğidir.";
            $fileName = 'deneme.txt';
            Storage::disk('ftp')->put($fileName, $data);
            return response()->json('File uploaded successfully');
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }
    public function takeArticlesFromFiles(){
        $files=Storage::disk('local_files')->files('INBOX');
        if(count($files)==0){
            return response()->json('There is no file in the INBOX folder');
        }

        foreach ($files as $file){
            $xlsx = SimpleXLSX::parse(base_path('FTP/'.$file));
             for($i=1; $i<count($xlsx->rows()); $i++){
                 if(User::where('id',$xlsx->rows()[$i][1])->count()!=1){
                     UserActionLogHelper::logAction(UserLogEnum::REGISTER_FAIL, ['error'=>'Author not found']);
                     $this->removeFilesToErrors($file);
                     echo 'Author not found';
                     continue;
                 }
                Article::create([
                    'authorID'=>$xlsx->rows()[$i][1],
                    'content'=>$xlsx->rows()[$i][3],
                    'title'=>$xlsx->rows()[$i][2],
                    'viewCount'=>$xlsx->rows()[$i][4],
                    'isActive'=>$xlsx->rows()[$i][5],
                    'created_at'=>$xlsx->rows()[$i][6],
                    'updated_at'=>$xlsx->rows()[$i][7]
                ]);
             }
        }


        return response()->json('Files are taken from the INBOX folder');

    }

    function removeFilesToErrors($from): void{
        if(Storage::exists($from)){
           Storage::move($from, 'ERRORS/');
        }
    }





}
