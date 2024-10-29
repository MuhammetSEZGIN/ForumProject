<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\UserLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }
    public function userLogs()
    {
        $userLogs = UserLog::query()->with('user')->get();

        return view('admin.userLogs', ['userlogs' => $userLogs]);
    }

}

