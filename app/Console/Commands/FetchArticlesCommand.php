<?php

namespace App\Console\Commands;

use App\Jobs\FetchArticlesJob;
use Illuminate\Console\Command;

class FetchArticlesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'articles:fetch';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch articles from news APIs and store them in the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        FetchArticlesJob::dispatch();

        $this->info('Article fetching job dispatched successfully.');

        return Command::SUCCESS;
    }
}
