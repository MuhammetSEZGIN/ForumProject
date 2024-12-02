<?php

namespace App\Http\Controllers;

use App\Helpers\TodoEnum;
use App\Helpers\UserActionLogHelper;
use App\Helpers\UserLogEnum;
use App\Models\Todolist;
use Illuminate\Http\Request;

class UserController
{
    /*
     * todolist sayfasına gider
     * */
    public function todolists(){
        $todolists = Todolist::where('user_id', auth()->id())->get();
        return view('user.todolist', compact('todolists'));
    }
    public function addTodoList(Request $request){

        $validatedData = $request->validate([
            'content' => 'required|max:255',
        ]);

       Todolist::create([
            'content' => $validatedData['content'],
            'status' => TodoEnum::IN_PROGRESS,
            'user_id' => auth()->id()
        ]);

        return redirect()->route('todolist')->with('success',  UserLogEnum::TODOLIST_ADD_SUCCESS);
    }

    public function todoStatusUpdate($id)
    {
        Todolist::findOrfail($id)->update([
            'status' => TodoEnum::DONE
        ]);
        return redirect()->route('todolist')->with('success', UserLogEnum::TODOLIST_STATUS_UPDATE_SUCCESS);
    }
    public function deleteTodoList($id)
    {
        $control=Todolist::findOrfail($id)->delete();
        return redirect()->route('todolist')->with('success', UserLogEnum::TODOLIST_ADD_FAIL);
    }


}
