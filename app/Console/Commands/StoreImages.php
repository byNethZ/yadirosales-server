<?php

namespace App\Console\Commands;

use App\Http\Controllers\ApiController;
use Illuminate\Console\Command;

class StoreImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'store:images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $apiController = new ApiController;
        $apiController->storeImages();

        //$this->info($apiController->storeImages());

        return 0;
    }
}
