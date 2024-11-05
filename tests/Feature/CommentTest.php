<?php

namespace Tests\Feature;

use App\Helpers\UserLogEnum;
use App\Models\Article;
use App\Models\Comment;
use App\Models\ReportedComment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentTest extends TestCase
{
    public function test_guest_can_post_comments_to_an_article()
    {
        $article = Article::factory()->create();
        $response = $this->post(route('sendComment', $article->articleID), [
            'articleID' => $article->articleID,
            'content' => 'This is a comment',
        ]);
        $response->assertValid();
        $this->assertDatabaseHas('comments', [
            'articleID' => $article->articleID,
            'content' => 'This is a comment',
            'isApproved' => false,
        ]);
        $response->assertRedirect(route('showArticle', $article->articleID));
        $response->assertSessionHas('success', UserLogEnum::COMMENT_ADD_SUCCESS);

    }

    public function test_guest_cannot_delete_comments()
    {
        $article = Article::factory()->create();
        $comment = $article->comments()->create([
            'userID' => 1, // 1 numaralı kullanıcı misafir kullanıcı
            'content' => 'This is a comment',
        ]);
        $response = $this->delete(route('deleteComment', $comment->commentID));
        // Misafir kullanıcılar yorum silemezler
        $response->assertRedirect(route('login'));
        // status redirect olduğundan emin ol
        $response->assertStatus(302);
        // Yorumun veritabanında hala olduğundan emin ol
        $this->assertDatabaseHas('comments', [
            'commentID' => $comment->commentID,
            'content' => 'This is a comment',
        ]);
    }

    public function test_author_can_see_comments_that_belongs_to_his_articles()
    {
        $article = Article::factory()->create();
        $userThatCommented = User::factory()->create();
        $comment = $article->comments()->create([
            'userID' => $userThatCommented->id,
            'content' => 'This is a comment',
        ]);
        $response = $this->actingAs($article->user)->get(route('myComments'));
        $response->assertStatus(200);
    }

    public function test_author_can_confirm_articles_comments()
    {
        $article = Article::factory()->create();
        $userThatCommented = User::factory()->create();
        $comment = $article->comments()->create([
            'userID' => $userThatCommented->id,
            'content' => 'This is a comment',
        ]);
        $response = $this->actingAs($article->user)->patch(route('approveComment', $comment->commentID));
        // Yazar yorumu onaylayabilir
        $response->assertRedirect(route('myComments'));
        $response->assertStatus(302);
        $response->assertSessionHas('success', UserLogEnum::COMMENT_CONFIRM_SUCCESS);
        $this->assertDatabaseHas('comments', [
            'commentID' => $comment->commentID,
            'isApproved' => true,
        ]);
    }

    public function test_author_can_delete_articles_comments()
    {
        // factoryde  makale için user oluşur
        $article = Article::factory()->create();
        $userThatCommented = User::factory()->create();
        $comment = $article->comments()->create([
            'userID' => $userThatCommented->id,
            'content' => 'This is a comment',
        ]);
        $response = $this->actingAs($article->user)->delete(route('deleteComment', $comment->commentID));
        // Yazar yorumu silebilir
        $response->assertRedirect(route('myComments'));
        $response->assertStatus(302);
        $response->assertSessionHas('success', UserLogEnum::COMMENT_DELETE_SUCCESS);
        $this->assertDatabaseMissing('comments', [
            'commentID' => $comment->commentID,
            'content' => 'This is a comment',
        ]);
    }

    public function test_user_can_report_comments()
    {
        $article = Article::factory()->create();
        $userThatCommented = User::factory()->create();
        $comment = $article->comments()->create([
            'userID' => $userThatCommented->id,
            'content' => 'This is a comment',
        ]);

        /*
        article user kullanıyorum çünkü factory de ayrı bir user oluşturuluyor
         tekrardan oluşturmak istemedim
       */
        $response = $this->actingAs($article->user)->post(route('reportComment', $comment->commentID),
            [
                'articleID' => $article->articleID,
                'commentID' => $comment->commentID,
                'userID' => $article->user->id,
                'reason' => 'This is a reason',
            ]
        );
        $response->assertValid();
        $response->assertSessionHas('success', UserLogEnum::COMMENT_REPORT_SUCCESS);
        $response->assertRedirect(route('showArticle', $article->articleID));
        $reportedComment = ReportedComment::where('commentID', $comment->commentID)
            ->where('userID', $article->user->id)
            ->first();
        $this->assertNotNull($reportedComment);
    }
}
