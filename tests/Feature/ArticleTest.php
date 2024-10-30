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
        $response = $this->get('/article/1');
        $response->assertStatus(200); // 200 Durum Kodu (Başarılı)
        $response->assertViewIs('articles.show');
    }

    public function test_user_can_post_article(): void
    {

        $user = User::factory()->create();
        $article= Article::factory()->make()->toArray();
        $response = $this->actingAs($user)->post('/article', $article );
        $response->assertValid();
        $this->assertDatabaseHas('articles', $article);
        $response->assertRedirect('/mainMenu');
        $response->assertSessionHas('success', UserLogEnum::ARTICLE_ADD_SUCCESS);

    }
    public function test_user_can_add_an_article_a_category(): void
    {
        /*
         * User, category ve article factorylerini kullanarak veritabanına test verileri eklenir.
         * Article ve category tabloları arasında many-to-many ilişkisi olduğu için article__category tablosuna da veri eklenir.
         * */
        $user = User::factory()->create();
        $article= Article::factory()->create();

        $response = $this->actingAs($user)->post('/article', $article->toArray());

        $category1 = Category::factory()->create();
        $article->category()->attach($category1->categoryID);


        $response->assertRedirect('/mainMenu');
        $this->assertDatabaseHas('article__category', [
            'articleID' => 1,
            'categoryID' => 2,
        ]);
    }
    public function test_categories_in_database_cannot_be_empty() : void
    {
        $this->assertNotEmpty(Category::all());
    }


}
