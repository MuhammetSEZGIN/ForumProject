<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;

abstract class Controller
{
    protected  $excelService;
    protected  $pdfService;
    protected  $wordService;
    function __construct()
    {
        $this->excelService= App::make('App\Services\FileService.excel');
        $this->pdfService= App::make('App\Services\FileService.pdf');
        $this->wordService= App::make('App\Services\FileService.word');
    }
}
