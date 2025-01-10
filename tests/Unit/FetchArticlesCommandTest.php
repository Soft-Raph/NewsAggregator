<?php

namespace Tests\Unit;

use App\Jobs\FetchArticlesJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class FetchArticlesCommandTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_fetch_articles_command_dispatches_job()
    {
        // Fake the job queue
        Queue::fake();

        // Run the command
        $this->artisan('articles:fetch')
            ->expectsOutput('Article fetching job dispatched successfully.')
            ->assertExitCode(0);

        // Assert the job was dispatched
        Queue::assertPushed(FetchArticlesJob::class);
    }
}
