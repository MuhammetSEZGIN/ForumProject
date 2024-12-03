<?php

namespace App\Http\Controllers;


use App\Helpers\AdminMessageEnum;
use App\Helpers\UserActionLogHelper;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Comment;
use App\Models\ReportedComment;
use App\Models\User;
use App\Models\UserLog;
use http\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function userLogs()
    {
        $userLogs = UserLog::with('user')->get();
        return view('admin.userlogs', ['userLogs' => $userLogs])
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

    public function allUsers(Request $request)
    {
        $query = User::query();
        if ($request->has('search') && $request["search"] != '') {
            $query->where('name', 'like', '%' . $request["search"] . '%')
                ->orWhere('email', 'like', '%' . $request["search"] . '%');
        }
        $users = $query->with('role')->where("id","!=",1)->paginate(15);

        return view('admin.allUsers', ['users' => $users])->
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

    public function allArticles(Request $request)
    {
        $query = Article::query();
        if($request->has('search') && $request["search"] != ''){
            $query->where('title', 'like', '%' . $request["search"] . '%')
                ->orWhere('content', 'like', '%' . $request["search"] . '%')
                ->orWhereHas('user', function($q) use ($request) {
                    $q->where('name', 'like', '%' . $request["search"] . '%');
                });
        }
        $articles = $query->with('user')->paginate(15);
        return view('admin.allArticles', ['articles' => $articles]);
    }

    public function deleteArticleAdmin($id){

        $article=Article::query()->findOrFail($id);

        if($article) {
            $article->delete();
            UserActionLogHelper::logAction("Makale silindi", request()->all());
        }else
            UserActionLogHelper::logAction("Makale silinemedi", request()->all());

        return redirect()->back();
    }
    public function reportedComments()
    {
        $comments = ReportedComment::with('user')->with('comment')->get();
        return view('admin.reportedComments', ['comments' => $comments]);
    }

    public function articleDelete($id)
    {
        $article= Article::where('id', $id)->first();
        if ($article) {
            $article->delete();
            return redirect()->route('reportedArticles')
                ->with('success', AdminMessageEnum::ARTICLE_DELETE_SUCCESS);
        }
        return redirect()->route('allArticles')
            ->with('error', AdminMessageEnum::ARTICLE_DELETE_FAIL);
    }

    public function commentDelete($id)
    {
        $message = Comment::where('id', $id)->first();
        if ($message) {
            $message->delete();
            return redirect()->route('reportedComments')
                ->with('success', AdminMessageEnum::COMMENT_DELETE_SUCCESS);
        }
        return redirect()->route('reportedComments')
            ->with('error', AdminMessageEnum::COMMENT_DELETE_FAIL);
    }

    public function userExportExcel()
    {
        $data = User::select('id', 'name', 'email', 'created_at')->get()->toArray();
        $columnNames = ['id', 'name', 'email', 'created_at'];
        $data = array_merge([$columnNames], $data);
        $filePath = $this->excelService->export($data, 'users');
        // dosyayı indir ve sadece indirilen yerde kalsın
        return response()->download($filePath)->deleteFileAfterSend(true);
    }

    public function userLogExportExcel()
    {
        $data = UserLog::all()->toArray();
        $columnNames = Schema::getColumnListing('userLogs');
        $data = array_merge([$columnNames], $data);
        $filePath = $this->excelService->export($data, 'user_logs');
        // dosyayı indir ve sadece indirilen yerde kalsın
        return response();
    }

}

