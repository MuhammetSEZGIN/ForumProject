<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

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
            "created_at"=> now(),
            "updated_at"=>now(),
        ]);
        return redirect()->back();
    }
}
