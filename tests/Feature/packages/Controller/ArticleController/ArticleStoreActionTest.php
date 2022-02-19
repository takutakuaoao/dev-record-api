<?php

declare(strict_types=1);

namespace Tests\Feature\packages\Controller\ArticleController;

use App\Http\Requests\Article\StoreRequest;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ArticleStoreActionTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        DB::table('categories')->insert([
            'id'   => 'category-id',
            'name' => 'test',
            'slug' => 'test',
        ]);
    }
    public function test_公開記事を新規登録した後にDBにデータが登録されている(): void
    {
        $requestArticle = StoreRequest::makeRequest(
            'category-id',
            'タイトル',
            'コンテンツ',
            'slug-article',
            'https://example.com/main/img/img.png',
            '1',
        );

        $this->post(route('article.store'), $requestArticle);

        $this->assertDatabaseHas('articles', static::expectArticleDbRecord($requestArticle));
    }

    public function test_下書き記事を新規登録した後にDBにデータが登録されている(): void
    {
        $requestArticle = StoreRequest::makeRequest(
            'category-id',
            '下書きタイトル',
            '下書きコンテンツ',
            'slug-article-draft',
            'https://example.com/main/img/img.png',
            '2',
        );

        $this->post(route('article.store'), $requestArticle);

        $this->assertDatabaseHas('articles', static::expectArticleDbRecord($requestArticle));
    }

    public function test_記事の新規登録成功時に登録IDと成功フラグをレスポンスとして返す(): void
    {
        $requestArticle = StoreRequest::makeRequest(
            'category-id',
            'タイトル',
            'コンテンツ',
            'slug-article',
            'https://example.com/main/img/img.png',
            '1',
        );

        $response = $this->post(route('article.store'), $requestArticle);
        $this->assertTrue($response['result']);
        $this->assertTrue(isset($response['data']['id']));
    }

    public function test_バリデーションエラー発生時はレスポンスのresultはfalseに設定される(): void
    {
        $response = $this->post(route('article.store'), ['title' => null, 'content' => null, 'slug' => null, 'mainImgUrl' => null, 'type' => 1]);

        $this->assertFalse($response['result']);
    }

    public function test_バリデーションエラー発生時はレスポンスのstatusは400に設定される(): void
    {
        $response = $this->post(route('article.store'), ['title' => null, 'content' => null, 'slug' => null, 'mainImgUrl' => null, 'type' => 1]);

        $this->assertSame(400, $response['status']);
    }

    public function test_下書き記事登録時にタイトル、スラッグ、カテゴリ、メイン画像が入力されていない場合はメッセージは出力せずDBへの登録が完了する(): void
    {
        $request = StoreRequest::makeRequest(
            '',
            '',
            '',
            '',
            '',
            '2',
        );
        $this->post(route('article.store'), $request);

        $article = DB::table('articles')->where('type', 2)->first();

        $this->assertNull($article->title);
        $this->assertNull($article->content);
        $this->assertNull($article->slug);
        $this->assertNull($article->category_id);
        $this->assertNull($article->main_img_url);
        $this->assertSame($article->type, 2);
        $this->assertTrue(!is_null($article->created_at));
        $this->assertTrue(is_null($article->updated_at));
    }

    /**
     * @dataProvider publicArticleStoreDataProvider
     */
    public function test_新規登録時にバリデーションを通過しなかった場合にエラーメッセージをレスポンスに含める(array $request, array $expectErrorMessages): void
    {
        $response = $this->post(route('article.store'), $request);

        $this->assertEquals($expectErrorMessages, $response['errors']);
    }

    public function publicArticleStoreDataProvider(): array
    {
        return [
            [
                StoreRequest::makeRequest(
                    '',
                    '',
                    '',
                    '',
                    '',
                    '1',
                ),
                [
                    'categoryId' => '記事を公開する場合はカテゴリが必須です',
                    'title'      => '記事を公開する場合はタイトルが必須です',
                    'content'    => '記事を公開する場合はコンテンツが必須です',
                    'slug'       => '記事を公開する場合はスラッグが必須です',
                ],
            ],
            [
                StoreRequest::makeRequest(
                    '',
                    str_repeat('*', 101),
                    'content',
                    str_repeat('*', 101),
                    str_repeat('*', 2001),
                    '1',
                ),
                [
                    'categoryId' => '記事を公開する場合はカテゴリが必須です',
                    'title'      => 'タイトルを100文字以内で入力してください',
                    'slug'       => 'スラッグを100文字以内で入力してください',
                    'mainImgUrl' => 'メイン画像のURLを2000文字以内で入力してください',
                ],
            ],
            [
                StoreRequest::makeRequest(
                    '',
                    'title',
                    'content',
                    'slug',
                    '',
                    '999',
                ),
                [
                    'type' => '公開タイプの値が不正です',
                ],
            ],
            [
                StoreRequest::makeRequest(
                    [''],
                    ['title'],
                    ['content'],
                    ['slug'],
                    [''],
                    ['999'],
                ),
                [
                    'categoryId' => 'カテゴリの形式が不正です',
                    'title'      => 'タイトルの形式が不正です',
                    'content'    => 'コンテンツの形式が不正です',
                    'slug'       => 'スラッグの形式が不正です',
                    'mainImgUrl' => 'メイン画像のURLの形式が不正です',
                    'type'       => '公開タイプの形式が不正です',
                ],
            ],
            [
                StoreRequest::makeRequest(
                    999,
                    'title',
                    'content',
                    'slug',
                    '',
                    '1',
                ),
                [
                    'categoryId' => '存在しないカテゴリが設定されています',
                ],
            ],
        ];
    }

    private static function expectArticleDbRecord(array $requestArticle): array
    {
        return [
            'category_id'  => $requestArticle['categoryId'],
            'title'        => $requestArticle['title'],
            'content'      => $requestArticle['content'],
            'slug'         => $requestArticle['slug'],
            'main_img_url' => $requestArticle['mainImgUrl'],
            'type'         => (int)$requestArticle['type'],
        ];
    }
}
