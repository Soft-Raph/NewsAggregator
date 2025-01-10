<?php

namespace App\Jobs;

use App\Models\Article;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;

class FetchArticlesJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $sources = config('news_apis');

        foreach ($sources as $source => $config) {
            $response = Http::get($config['url']);

            if ($response->ok()) {
                $articles = $this->{$config['transform']}($response->json());

                foreach ($articles as $article) {
                    Article::updateOrCreate(
                        ['url' => $article['url']],
                        $article
                    );
                }
            }
        }
    }

    /**
     * Transform response for NewsAPI
     */
    private function transformNewsApi(array $data): array
    {
        return collect($data['articles'] ?? [])->map(function ($article) {
            return [
                'title' => $article['title'],
                'author' => $article['author'],
                'source' => 'newsapi',
                'description' => $article['description'],
                'url' => $article['url'],
                'published_at' => $article['publishedAt'],
                'category' => null,
            ];
        })->toArray();
    }

    /**
     * Transform response for The Guardian API
     */
    private function transformGuardianApi(array $data): array
    {
        return collect($data['response']['results'] ?? [])->map(function ($article) {
            return [
                'title' => $article['webTitle'],
                'author' => null,
                'source' => 'guardian',
                'description' => null,
                'url' => $article['webUrl'],
                'published_at' => $article['webPublicationDate'],
                'category' => null,
            ];
        })->toArray();
    }

    /**
     * Transform response for New York Times API
     */
    private function transformNYTimesApi(array $data): array
    {
        return collect($data['results'] ?? [])->map(function ($article) {
            return [
                'title' => $article['title'],
                'author' => $article['byline'],
                'source' => 'nytimes',
                'description' => $article['abstract'],
                'url' => $article['url'],
                'published_at' => $article['published_date'],
                'category' => $article['section'],
            ];
        })->toArray();
    }
}
