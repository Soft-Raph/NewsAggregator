<?php

namespace Tests\Feature;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class FetchArticlesFullFlowTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_fetch_articles_command_full_flow()
    {
        // Fake HTTP responses
        Http::fake([
            'https://newsapi.org/*' => Http::response([
                'articles' => [
                    [
                        'title' => 'Full Flow Article',
                        'author' => 'Jane Smith',
                        'description' => 'Description for full flow',
                        'url' => 'https://example.com/full-flow',
                        'publishedAt' => '2025-01-01T15:00:00Z',
                    ],
                ],
            ], 200),
        ]);

        // Run the command
        $this->artisan('articles:fetch')
            ->expectsOutput('Article fetching job dispatched successfully.')
            ->assertExitCode(0);

        // Assert the article was saved in the database
        $this->assertDatabaseHas('articles', [
            'title' => 'Full Flow Article',
            'author' => 'Jane Smith',
            'source' => 'newsapi',
        ]);
    }
}
