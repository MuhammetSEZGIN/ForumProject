<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Helpers\UserActionLogHelper;

class ArticleController extends Controller
{
    public function index()
    {
        //$articles = Article::all();
        $articles = Article::query()->where("isActive",1)->paginate(4);
//        $articles = Article::query()->simplePaginate(2);

        return view('articles.index', [
            'articles' => $articles,
            'header'=> 'Ana Sayfa'
        ]);
    }

    public function lastArticles()
    {

        $lastArticles = Article::query()->where("isActive",1)->orderBy('created_at', 'desc')->paginate(4);

        return view('articles.index', [
            'articles' => $lastArticles,
            'header'=> 'Son Eklenenler'
        ]);
    }

    public function popularArticles()
    {

        $popularArticles= Article::query()->where("isActive",1)->orderBy('viewCount', 'desc')->paginate(4);

        return view('articles.index', [
            'articles' => $popularArticles,
            'header'=> 'En Çok Okunanlar'
        ]);
    }

    public function findArticle($id)
    {
        $article = Article::with(['comments'=>function($query){
            $query->where('isApproved',true);
        }])->findOrFail($id);
        $article->viewCount++;
        $article->save();
        return view('articles.show', [
            'article' => $article,
        ]);
    }

    public function addArticleShow()
    {
        return view('articles.create', [
            'categories' => Category::all() ?? ["Kategori Yok"]
        ]);
    }
    public function addArticle(Request $request)
    {
        $validatedData = $request->validate([
            "title"=>"required",
            "text"=>"required",
            "categoryID"=>"required",

        ]);
        $newArticle=Article::create([
            "title"=>$validatedData["title"],
            "content"=>$validatedData["text"],
            "authorID"=> Auth::id(),
            "viewCount"=>0,
            "isActive"=>true,
        ]);

        if($newArticle){
            $newArticle->category()->attach($validatedData["categoryID"]);
            userActionLogHelper::logAction("Yeni makale eklendi", $request->all());

            return redirect("mainMenu");
        }else{
            userActionLogHelper::logAction("Makale eklenemedi", $validatedData);
            throw ValidationException::withMessages([
                "title"=>"Article could not be created",

            ]);
        }
    }

    public function myArticles(){
        $userId= Auth::id();
        // $Articles = Article::query()->where('authorID',$userId);
        if($userId){
            $articles = Article::query()->where('authorID',$userId)
            ->where('isActive',true)->get();
            return view('user.myArticles',[
                'articles' => $articles,
            ]);
        }else{
            return redirect("login");
        }


    }
    public function editArticleShow($id){
        $article= Article::query()->findOrFail($id);
        return view('articles.edit', [
            'article' => $article,
            'categories' => Category::all() ?? ["Kategori Yok"]
        ]);
    }

    public function editArticle(Request $request){
        $id=Auth::id();
        $validatedData = $request->validate([
            "title"=>"required",
            "text"=>"required",
            "categoryID"=>"required",
        ]);

        $updatedArticle=Article::query()->findOrFail($id);
        $updatedArticle->update([
            "title"=>$validatedData["title"],
            "content"=>$validatedData["text"],
        ]);
        $updatedArticle->category()->attach($validatedData["categoryID"]);
        UserActionLogHelper::logAction("Makale guncellendi", $request->all());
        return redirect()->route('showArticle', ['id' => $id]);
    }

    public function deleteArticle($id){
        $article=Article::query()->findOrFail($id);
        $article->isActive=false;
        if($article->save()){
            UserActionLogHelper::logAction("Makale silindi", request()->all());
        }else{
            UserActionLogHelper::logAction("Makale silinemedi", request()->all());
        }
        return redirect('myArticles');
    }
}
