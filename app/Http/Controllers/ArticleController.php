<?php

namespace App\Http\Controllers;

use App\Helpers\UserLogEnum;
use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\ReportedArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\ValidationException;
use App\Helpers\UserActionLogHelper;

class ArticleController extends Controller
{

    /*
     Ana sayfada makaleleri listeler.
     */
    public function index()
    {
       // pagine fonksiyonu sayfalama yaparken sayfa başına kaç tane makale gösterileceğini belirler.
        $articles = Article::where("isActive",1)->paginate(4);
//       $articles = Article::query()->simplePaginate(2);
//       simplePaginate() fonksiyonu sayfalama yaparken sadece ileri ve geri butonları gösterir.
        return view('articles.index', [
            'articles' => $articles,
            'header'=> 'Ana Sayfa'
        ]);
    }

    /*
     * Son eklenen makaleleri listeler.
     * */
    public function lastArticles()
    {
        $lastArticles = Article::where("isActive",1)->orderBy('created_at', 'desc')->paginate(4);
        return view('articles.index', [
            'articles' => $lastArticles,
            'header'=> 'Son Eklenenler'
        ]);
    }

    /*
     * En çok okunan makaleleri listeler.
     * */
    public function popularArticles()
    {

        $popularArticles= Article::query()->where("isActive",1)
            ->orderBy('viewCount', 'desc')->paginate(4);

        return view('articles.index', [
            'articles' => $popularArticles,
            'header'=> 'En Çok Okunanlar'
        ]);
    }

    /*
     * Seçilen id ye ait makalenin detaylarını article.show sayfasında gösterir.
     * */
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

    /*
     * Makale eklenmesini sağlayacak sayfanın görüntülenmesi.
     * */
    public function addArticleShow()
    {
        return view('articles.create', [
            'categories' => Category::all() ?? ["Kategori Yok"]
        ]);
    }

    /*
     * Makale eklemek için kullanılan fonksiyon.
     * */
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
           // Katagori tablosu ile ilişkilendirme yapar.
            $newArticle->category()->attach($validatedData["categoryID"]);
            userActionLogHelper::logAction(UserLogEnum::ARTICLE_ADD_SUCCESS, $request->all());

            return redirect()->route('showArticle', $newArticle->articleID)
                ->with('success', UserLogEnum::ARTICLE_ADD_SUCCESS);
        }else{
            userActionLogHelper::logAction(UserLogEnum::ARTICLE_ADD_FAIL, $validatedData);
            throw ValidationException::withMessages([
                "title"=>"Article could not be created",
            ]);
        }
    }

    /*
     * Kullanıcının eklediği makaleleri listeler. Sadece giriş yapmış kullanıcılar için çalışır.
     * */
    public function myArticles(){
        $userId= Auth::id();
      if($userId){
            $articles = Article::query()->where('authorID',$userId)
            ->where('isActive',true)->get();
            return view('user.myarticles',[
                'articles' => $articles,
            ]);
        }else{
            return redirect()->route("login");
        }


    }

    /*
     * Kullanıcının eklediği makaleyi düzenlemesini sağlayacak sayfanın görüntülenmesi.
     * */
    public function editArticleShow($id){
        $article= Article::query()->findOrFail($id);
        return view('articles.edit', [
            'article' => $article,
            'categories' => Category::all() ?? ["Kategori Yok"]
        ]);
    }

    /*
     * Kullanıcının eklediği makaleyi düzenlemesi sağlanır.
     * */
    public function editArticle(Request $request, $id){
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
        UserActionLogHelper::logAction(UserLogEnum::ARTICLE_UPDATE_SUCCESS, $request->all());
        return redirect()->route('showArticle', ['id' => $id])
            ->with('success', UserLogEnum::ARTICLE_UPDATE_SUCCESS);
    }

    /*
     * Kullanıcının eklediği makaleyi silmesini sağlar.
     * */
    public function deleteArticle($id){
        $article=Article::query()->findOrFail($id);
        $article->isActive=false;
        if($article->save()){
            UserActionLogHelper::logAction("Makale silindi", request()->all());
        }else{
            UserActionLogHelper::logAction("Makale silinemedi", request()->all());
        }
        return redirect()->back();
    }

    /*
     * Kullanıcılar eklenen makaleleri şikayet edebilir
     * */
    public function reportArticle( $id){
        $article=Article::findOrFail($id);
        $validatedData = request()->validate([
            "reason"=>"required",
        ]);

        if($article){
            ReportedArticle::create([
                'articleID'=>$id,
                'userID'=>Auth::id(),
                'reason'=>$validatedData['reason'],
            ]);
            UserActionLogHelper::logAction(UserLogEnum::ARTICLE_REPORT_SUCCESS, request()->all());
            return redirect()->route('showArticle', ['id' => $id])
                ->with('success', UserLogEnum::ARTICLE_REPORT_SUCCESS);
        }else{
            UserActionLogHelper::logAction(UserLogEnum::ARTICLE_REPORT_FAIL, request()->all());

            /*
             * comment report daki fonksiyonda return redirect()->route('showArticle', ['id' => $id])->with('fail', UserLogEnum::ARTICLE_REPORT_FAIL);
             * şeklinde bir kullanım var. Bu kullanımı burada da yapabilirdik.
             * */
            throw ValidationException::withMessages([
                "fail"=>UserLogEnum::ARTICLE_REPORT_FAIL,
            ]);
        }
    }


    public function exportArticleToExcel($id)
    {
        $article= Article::where('articleID', $id)->get()->toArray();
        $columnNames = Schema::getColumnListing('articles');
        $data = array_merge([$columnNames], $article);
        $filePath = $this->excelService->export($data, $article[0]['title']);
        // dosyayı indir ve sadece indirilen yerde kalsın
        return response("File exported successfully");

    }

    public function exportAllArticlesToExcel()
    {
        $userId= Auth::id();
        $articles = Article::where('userID', $userId)->get()->toArray();
        $columnNames = Schema::getColumnListing('articles');
        $data = array_merge([$columnNames], $articles);
        $filePath = $this->excelService->export($data, 'articles');
        // dosyayı indir ve sadece indirilen yerde kalsın
        return response()->download($filePath)->deleteFileAfterSend(true);
    }

    public function importArticleFromExcel(Request $request)
    {
        $inportedData = $this->excelService->import($request->file('file'));
        $validatedData = $request->validate([
            'title' => 'required',
            'content' => 'required',
            'category_id' => 'required',
            'isActive' => 'required',
        ]);
        $article = Article::create([
            'title' => $validatedData['title'],
            'content' => $validatedData['content'],
            'category_id' => $validatedData['category_id'],
            'isActive' => $validatedData['isActive'],
        ]);
        return response()->json($article);
    }

}
