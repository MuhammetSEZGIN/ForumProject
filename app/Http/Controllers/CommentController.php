<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use function PHPUnit\Framework\isEmpty;

class CommentController extends Controller
{
    public function sendComment(Request $request){

        $request->validate([
            'content' => 'required|string|max:255',
            'articleID' => 'required|integer',
        ]);
        $userID = (int)($request->get('userID')) ?? 0;

        Comment::query()->insert([
            "articleID"=>$request->get('articleID'),
            "userID" => $userID,
            "content"=>$request->get('content'),
            "isApproved" => false,
            "created_at"=> now(),
            "updated_at"=>now(),

        ]);
        return redirect()->back();
    }
    public function deleteComment($id){

        Comment::query()->findOrFail($id)->delete();
        return redirect()->back();
    }
    public function getComments(){
        $userID= Auth::id();
        if($userID){
            return Comment::query()->where('userID',$userID)->get();
        }else{
            return redirect("login");
        }

    }
    public function approveComment($id){
        Comment::query()->findOrFail($id)->update([
            "isApproved"=>true,
        ]);
        return redirect()->back();
    }
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
        else{
            // controller a auth eklenebilir mi bakacağım bu şekilde olmaz hep
            return redirect("login");
        }
    }
}
