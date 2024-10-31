<?php

namespace App\Http\Controllers;

use App\Helpers\UserActionLogHelper;
use App\Helpers\UserLogEnum;
use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use function PHPUnit\Framework\isEmpty;

class CommentController extends Controller
{

    /*
     * Yorum gönderme işlemi. Yorum gönderildikten sonra yorumun onaylanması gerekmektedir.
     * Her kullanıcı yorum gönderebilir.
     * */
    public function sendComment(Request $request){

        $request->validate([
            'content' => 'required|string|max:255',
            'articleID' => 'required|integer',
        ]);
        $userID = (int)($request->get('userID') ?? 1);

        $result=Comment::insert([
            "articleID"=>$request->get('articleID'),
            "userID" => $userID,
            "content"=>$request->get('content'),
            "isApproved" => false,
            "created_at"=> now(),
            "updated_at"=>now(),

        ]);
        if($result) {
            userActionLogHelper::logAction(UserLogEnum::COMMENT_ADD_SUCCESS, request()->all());
            return redirect(route('showArticle',$request->get('articleID') ))->with('success', UserLogEnum::COMMENT_ADD_SUCCESS);
        }
        return redirect(route('showArticle',$request->get('articleID') ))->with('fail', UserLogEnum::COMMENT_ADD_FAIL);
    }

    /*
     * Yorum silme işlemi. Sadece yorumun yapıldığı makaleyi yazan kişi yorumu silebilir.
     * */
    public function deleteComment($id){

        if(Comment::query()->findOrFail($id)->delete()) {
            userActionLogHelper::logAction(UserLogEnum::COMMENT_DELETE_SUCCESS, request()->all());
            return redirect(route('myComments'))->with('success', UserLogEnum::COMMENT_DELETE_SUCCESS);
        }else{
            userActionLogHelper::logAction(UserLogEnum::ARTICLE_DELETE_FAIL, request()->all());
            return redirect(route('myComments'))->with('fail', UserLogEnum::COMMENT_DELETE_FAIL);
        }

    }
    public function getComments(){
        $userID= Auth::id();
        if($userID){
            return Comment::query()->where('userID',$userID)->get();
        }else{
            return redirect("login");
        }

    }

    /*
     * Makaleye yapılan yorumların onaylanması işlemi.
     * */
    public function approveComment($id){
        if(Comment::query()->findOrFail($id)->update([
            "isApproved"=>true,
        ])){
            userActionLogHelper::logAction("Yorum onaylandı", request()->all());
        }else
        {
            userActionLogHelper::logAction("Yorum onaylanamadı", request()->all());
        }
        return redirect(route('myComments'))->with('success', UserLogEnum::COMMENT_CONFIRM_SUCCESS);
    }


    /*
     * Kullanıcıya yapılan yorumların listelenmesi.
     * */
    public function myComments(){
        $userID= Auth::id();
        if($userID){

            $articles=Article::query()->where('authorID',$userID)->get();
            $comments=Comment::query()->whereIn('articleID',$articles->pluck('articleID'))->get();

            return view("user.comments",
            [
                "comments"=>$comments
            ]
            );
        }

        // middleware ile kontrol ediliyor ama burda yapsak da sorun yok.
        else{
            return redirect("login");
        }
    }
}
