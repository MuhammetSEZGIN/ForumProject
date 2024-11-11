<?php

namespace App\Http\Controllers;

use App\Helpers\FileMessagesEnum;
use App\Helpers\FileSystemLogHelper;
use App\Helpers\UserActionLogHelper;
use App\Helpers\UserLogEnum;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Comment;
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
use Shuchkin\SimpleXLSXGen;


class FileController extends Controller
{

    /*
     * File controller ı yeniden yazman gerekir
     *
     * */

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

    /*
     * FTP sunucusundan dosyaları local sunucuya çeker
     * */
    public function updateLocalFromFtp()
    {
        $files = Storage::disk('ftp')->files();
        if (empty($files)) {
            FileSystemLogHelper::logAction(FileMessagesEnum::NO_FILE_IN_FTP, Storage::directories('ftp'));
            return response()->json(FileMessagesEnum::NO_FILE_IN_FTP);
        }
        foreach ($files as $file) {

            Storage::disk('local_files')->put('INBOX/'.basename($file), $file);
            FileSystemLogHelper::logAction(FileMessagesEnum::FILE_DOWNLOADED_FROM_FTP_SERVER_SUCCESSFULLY, $file);
        }
        return response()->json(FileMessagesEnum::FILE_DOWNLOADED_FROM_FTP_SERVER_SUCCESSFULLY);

    }

    public function createAndSendRaporFiles()
    {
        $this->updateLocalFromFtp();
        $files = Storage::disk('local_files')->files('INBOX');
        if (count($files) == 0) {
            FileSystemLogHelper::logAction(FileMessagesEnum::NO_FILE_IN_INBOX, 'INBOX');
            return response()->json(FileMessagesEnum::NO_FILE_IN_INBOX);
        }
        // $test= basename($files[0]);
        foreach ($files as $file) {
            // metadata kontrol et ?
            if(pathinfo($file, PATHINFO_EXTENSION) != 'xlsx') {
                continue;
            }
            $raporArray = $this->createRaporArray(base_path('FTP/'.$file));
            /*echo "<pre>";
            print_r($raporArray);
            echo "</pre>";*/
            if(is_array($raporArray)){
                $this->createRaporFile($raporArray, $file);
                $this->sendToFtp('OUTBOX/'.basename($file));
                FileSystemLogHelper::logAction(FileMessagesEnum::FILE_UPLOADED_TO_FTP_SUCCESSFULLY, basename($file));
                return response()->json(FileMessagesEnum::FILE_UPLOADED_TO_FTP_SUCCESSFULLY);
            }
        }
    }

    /*
     * Verilen dosyaların içerisindeki makalelere ait yorumları database den çekerek makale ve yorumların olduğu
     * yeni bir array oluşturur.
     * */
    public function createRaporArray($filePath)
    {
        $xlsx = SimpleXLSX::parse($filePath);
        if($xlsx){
            $raporArray= [];
            $raporArray[0]= $xlsx->rows()[0];
            $articleIdColumnNo= array_search("articleID",$xlsx->rows()[0]);
            $count=1;
            $rowCount= count($xlsx->rows());
            for($i=1; $i<$rowCount; $i++){
                // $raporArray[$count]=$xlsx->rows()[$i];
                $raporArray[$count]=[
                    $xlsx->rows()[$i][0],
                    $xlsx->rows()[$i][1],
                    $xlsx->rows()[$i][2],
                    $xlsx->rows()[$i][3],
                    $xlsx->rows()[$i][4],
                    $xlsx->rows()[$i][5],
                    $xlsx->rows()[$i][6],
                    $xlsx->rows()[$i][7]
                ];
                $comments = Comment::where('articleID', $xlsx->rows()[$i][$articleIdColumnNo])->get();
                $comments->each(function ($comment) use (&$raporArray, &$count){
                    //$raporArray[++$count]=$comment->toArray();
                    $raporArray[++$count]=[
                        $comment->commentID,
                        $comment->articleID,
                        $comment->content,
                        $comment->isActive,
                        $comment->created_at->format('Y-m-d H:i:s'),
                        $comment->updated_at->format('Y-m-d H:i:s'),
                    ];
                });
                $count++;
            }
            return $raporArray;
        }
        else{
            FileSystemLogHelper::logAction(FileMessagesEnum::FILE_COULD_NOT_READ_FROM_FILE, $filePath);
            $this->moveFilesToErrors($filePath);
            FileSystemLogHelper::logAction(FileMessagesEnum::FILE_MOVED_TO_ERROR_DIRECTORY, $filePath);
            return response()->json(FileMessagesEnum::FILE_NOT_FOUND_FROM_LOCAL);
        }


    }

    public function createRaporFile(array $raporArray, $fileName):void
    {
        SimpleXLSXGen::fromArray($raporArray)->saveAs(base_path("FTP/OUTBOX/".basename($fileName)));
    }
    public function sendToFtp($filePath)
    {
        $file= Storage::disk('local_files')->get($filePath);
        if($file==null){
            FileSystemLogHelper::logAction(FileMessagesEnum::FILE_NOT_FOUND_FROM_LOCAL, $filePath);
            return response()->json(FileMessagesEnum::FILE_NOT_FOUND_FROM_LOCAL);
        }
        Storage::disk('ftp')->put($filePath, $file );
        FileSystemLogHelper::logAction(FileMessagesEnum::FILE_NOT_FOUND_FROM_LOCAL, $filePath);
        return response()->json(FileMessagesEnum::FILE_SEND_TO_FTP);

    }

    /*
    * dosya içerisinde userID verisini arar ve bulduğu user verilerini dosyaya yazar
    * kullanıcı bulunamadıysa ağer dosya error kalsörüne aktarılır
    * */
    public function takeArticlesFromFiles()
    {
        $this->updateLocalFromFtp();
        $files = Storage::disk('local_files')->files('INBOX');
        if (count($files) == 0) {
            return response()->json('There is no file in the INBOX folder');
        }
        foreach ($files as $file) {
            if(pathinfo($file, PATHINFO_EXTENSION) != 'xlsx') {
                continue;
            }
            //$this->createRaporFiles('FTP/' . $file);
            $xlsx = SimpleXLSX::parse(base_path('FTP/' . $file));

            for ($i = 1; $i < count($xlsx->rows()); $i++) {

                if ($user=User::where('id', $xlsx->rows()[$i][1])->firstOrFail()) {
                    UserActionLogHelper::logAction(UserLogEnum::REGISTER_FAIL, ['error' => 'Author not found']);
                    FileSystemLogHelper::logAction(
                        FileMessagesEnum::USER_NAME_DOESNT_EXISTS_IN_FOLDER,
                        $file,
                        "User is not valid: User name:". $user->name ."User ID:". $user->id
                    );
                    $this->moveFilesToErrors($file);
                    continue;
                }

                Article::create([
                    'authorID' => $xlsx->rows()[$i][1],
                    'content' => $xlsx->rows()[$i][3],
                    'title' => $xlsx->rows()[$i][2],
                    'viewCount' => $xlsx->rows()[$i][4],
                    'isActive' => $xlsx->rows()[$i][5],
                    'created_at' => $xlsx->rows()[$i][6],
                    'updated_at' => $xlsx->rows()[$i][7]
                ]);
            }
        }


        return response()->json('Files are taken from the INBOX folder');

    }

    /*
     * Oluşan hatalar varsa bu hatalı dosyaları ERROR klasörüne taşır
     * */
    function moveFilesToErrors($from): void
    {
        if(!Storage::disk('local_files')->exists('ERROR/')) {
            Storage::disk('local_files')->makeDirectory('ERROR/');
        }
        if (Storage::disk('local_files')->exists($from)) {
           $control= Storage::disk('local_files')->move($from, 'ERROR/'.basename($from));
           if($control) {
               FileSystemLogHelper::logAction(FileMessagesEnum::FILE_MOVED_TO_ERROR_DIRECTORY, $from);
           }
        }
    }


}
