<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\FileHandlers\PdfHandler;
use App\Services\FileService;
use App\Services\FtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class FileController extends Controller
{
    public function test()
    {
        //Storage::put('test.txt', 'Hello World');
        try{
            $data = "Bu, FTP sunucusuna yazılacak basit bir metin dosyası içeriğidir.";
            $fileName = 'deneme.txt';
            Storage::disk('ftp')->put($fileName, $data);
            return response()->json('File uploaded successfully');
        }catch (\Exception $e){
            return response()->json($e->getMessage());
        }
    }
    public function exportPdf($data)
    {
        // Export data to pdf
        $pdfService = new FileService(new PdfHandler());
        $filePath = $pdfService->export($data);
        return response()->download($filePath);

    }
    public function importPdf(Request $request)
    {
        // Import data from pdf
        $pdfService = new FileService(new PdfHandler());
        $data = $pdfService->import($request->file('file'));
        return response()->json($data);

    }

    public function exportExcel()
    {
        // Export data to excel
    }

    public function importExcel(Request $request)
    {
        // Import data from excel
    }

   /*
    * Daha fazla dosya formatı eklemek istediğimizde
    * FileHandler kısmına eklememiz gerekir
    * */

}
