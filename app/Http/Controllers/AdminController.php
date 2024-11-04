<?php

namespace App\Http\Controllers;


use App\Helpers\AdminMessageEnum;
use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\User;
use App\Models\UserLog;
use http\Message;
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
        $userLogs = UserLog::with('user')->get();
        return view('admin.userLogs', ['userLogs' => $userLogs])
            ->with('success', AdminMessageEnum::VIEW_ALL_LOGS);
    }

    public function userLogsDelete($id)
    {
        $userLogs = UserLog::find($id);
        if ($userLogs) {
            $userLogs->delete();
            return redirect()->route('userLogs')->
            with('success', AdminMessageEnum::USER_LOGS_DELETE_SUCCESS);
        } else {
            return redirect()->route('userLogs')->
            with('error', AdminMessageEnum::USER_LOGS_DELETE_FAIL);
        }
    }

    public function userLogsDeleteAll()
    {
        // ::delete metodu  yerine truncate metodu ile tüm verileri sileriz
        if (UserLog::truncate()) {
            return redirect()->route('userLogs')->
            with('success', AdminMessageEnum::USER_LOGS_DELETE_ALL_SUCCESS);
        }
        return redirect()->route('userLogs')->
        with('error', AdminMessageEnum::USER_LOGS_DELETE_ALL_FAIL);
    }

    public function allUsers()
    {
        $users = User::with('role')->select('id', 'name', 'email', 'created_at')->get();
        return redirect()->route('allUsers', ['users' => $users])->
        with('success', AdminMessageEnum::VIEW_ALL_USERS);
    }

    public function userDelete($id)
    {
        $user = User::where('id', $id)->first();
        if ($user) {
            $user->delete();
            return redirect()->route('allUsers')
                ->with('success', AdminMessageEnum::USER_DELETE_SUCCESS);
        }
        return redirect()->route('allUsers')->
        with('error', AdminMessageEnum::USER_DELETE_FAIL);
    }




    public function commentDelete($id)
    {
        $message = Comment::where('id', $id)->first();
        if ($message) {
            $message->delete();
            return redirect()->route('allComments')
                ->with('success', AdminMessageEnum::COMMENT_DELETE_SUCCESS);
        }
    }
}

