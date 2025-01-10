<?php

namespace Tests\Unit;

use App\Models\Article;
use Tests\TestCase;

class FetchArticlesTest extends TestCase
{
    public function test_fetch_articles_endpoint()
    {
        // Insert test data into the database
        Article::create([
            'title' => 'Test Article',
            'author' => 'John Doe',
            'source' => 'newsapi',
            'description' => 'This is a test description.',
            'url' => 'https://example.com/test-article',
            'published_at' => '2025-01-08 10:00:00',
            'category' => 'technology',
        ]);

        // Call the endpoint
        $response = $this->getJson('/api/articles');

        // Assert the response structure and data
        $response->assertStatus(200)
            ->assertJsonPath('data.data.0.description', 'Machado’s appearance at the rally was her first public appearance in months, since a government crackdown on Venezeulan opposition figures and their supporters last year.');
    }
}
