<?php

namespace Tests\Unit;

use App\Jobs\FetchArticlesJob;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class FetchArticlesJobTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_fetch_articles_job_stores_articles()
    {
        // Fake HTTP responses
        Http::fake([
            'https://newsapi.org/*' => Http::response([
                'articles' => [
                    [
                        'title' => 'Test News Article',
                        'author' => 'John Doe',
                        'description' => 'A brief description',
                        'url' => 'https://example.com/article',
                        'publishedAt' => '2025-01-01T12:00:00Z',
                    ],
                ],
            ], 200),
        ]);

        // Dispatch the job
        (new FetchArticlesJob())->handle();

        // Assert the article was saved in the database
        $this->assertDatabaseHas('articles', [
            'title' => 'Test News Article',
            'author' => 'John Doe',
            'source' => 'newsapi',
        ]);
    }
}
