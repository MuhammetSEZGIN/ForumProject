<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        //$articles = Article::all();
        $articles = Article::query()->paginate(4);
//        $articles = Article::query()->simplePaginate(2);
        return view('articles.index', [
            'articles' => $articles,
            'header'=> 'Ana Sayfa'
        ]);
    }

    public function lastArticles()
    {

        $lastArticles = Article::query()->orderBy('created_at', 'desc')->paginate(4);

        return view('articles.index', [
            'articles' => $lastArticles,
            'header'=> 'Son Eklenenler'
        ]);
    }

    public function popularArticles()
    {

        $popularArticles= Article::query()->orderBy('viewCount', 'desc')->paginate(4);

        return view('articles.index', [
            'articles' => $popularArticles,
            'header'=> 'En Çok Okunanlar'
        ]);
    }

    public function findArticle(Request $request)
    {
        $article = Article::with("comments")->findOrFail($request['id']);
        return view('articles.show', [
            'article' => $article,

        ]);
    }
}
