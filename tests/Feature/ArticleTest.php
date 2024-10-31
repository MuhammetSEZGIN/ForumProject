<?php

namespace Tests\Feature;

use App\Helpers\UserLogEnum;
use App\Models\Article;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    public function test_guest_user_can_view_main_menu(): void
    {
        $response = $this->get('/mainMenu');
        $response->assertStatus(200); // 200 Durum Kodu (Başarılı)

        $response->assertViewIs('articles.index');
    }

    public function test_guest_user_can_view_article(): void
    {
        $article = Article::factory()->create();
        $response = $this->get(route('showArticle', $article->articleID));
        $response->assertStatus(200);
        $response->assertViewIs('articles.show');
    }

    public function test_author_can_see_add_article_form(): void
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $response = $this->actingAs($user)->get(route('addArticle'),
        [
            'categories' => Category::all() ?? "Kategori Yok",
        ]
        );
        $response->assertStatus(200);
    }
    public function test_user_can_post_article(): void
    {
        $article = Article::factory()->make();
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $response = $this->actingAs($user)->post(route('addArticle'),[
            'title' => $article->title,
            'text' => $article->content,
            'categoryID' => $category->CategoryID,
        ]);
        $response->assertValid();
        $this->assertDatabaseHas('articles', [
            'title' => $article->title,
            'content' => $article->content,
        ]);
        $addedArticle= Article::where('title', $article->title)->first();
        $response->assertRedirect(route('showArticle', [$addedArticle->articleID]));
        $response->assertSessionHas('success', UserLogEnum::ARTICLE_ADD_SUCCESS);

    }

    public function test_author_can_see_edit_article_form(): void
    {
        $article= Article::factory()->create();
        $category = Category::factory()->create();
        $article->category()->attach($category->CategoryID);

        $response = $this->actingAs($article->user)->get(route('article.edit.show', $article->articleID),
        [
            'categories' => Category::all() ?? "Kategori Yok",
        ]
        );
        $response->assertStatus(200);

    }


    public function test_author_can_edit_article(): void
    {
        $article= Article::factory()->create();
        $category = Category::factory()->create();

        $response = $this->actingAs($article->user)->patch(route('editArticle', $article->articleID),[
            'title' => $article->title,
            'text' => $article->content,
            'categoryID' => $category->CategoryID,
        ]);
        $response->assertValid();
        $response->assertSessionHas('success', UserLogEnum::ARTICLE_UPDATE_SUCCESS);
        $response->assertRedirect(route('showArticle', [$article->articleID]));
    }

    /*
     * AssertStatus 302 vermemize gerek var mı ?
     * Çünkü devamında  $response->assertRedirect('myArticles'); ile yönlendirme yapıyoruz.
     * */
    public function test_author_can_delete_article(): void
    {

        $article= Article::factory()->create();
        $category = Category::factory()->create();
        $article->category()->attach($category->CategoryID);
        $response = $this->actingAs($article->user)->delete(route('deleteArticle', $article->articleID))->assertStatus(302);
        $response->assertRedirect('myArticles');
    }

    public function test_categories_in_database_cannot_be_empty() : void
    {
        $this->assertNotEmpty(Category::all());
    }


}
