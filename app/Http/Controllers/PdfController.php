<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use \Barryvdh\DomPDF\ServiceProvider;
use Illuminate\Support\Facades\App;

class PdfController extends Controller
{

     public function createPdf()
     {
         $users= User::all();
         $data = [
             'users' => $users,
         ];
         $pdf = PDF::loadView('pdf.allUsers', $data);
            return $pdf->download('deneme.pdf');
     }
     public function allUsers()
     {
         $users= User::all();
         $data = [
             'users' => $users,
         ];

        return view('pdf.allUsers', $data);
     }
}
