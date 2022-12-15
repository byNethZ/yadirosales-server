<?php

namespace App\Console\Commands;

use App\Http\Controllers\ApiController;
use Illuminate\Console\Command;

class StoreData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'store:properties';

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

        $apiController->propertiesStore('a', 'Active');
        $apiController->propertiesStore('a', 'Pending');
        $apiController->propertiesStore('a', 'Contingent');

        $apiController->propertiesStore('b', 'Active');
        $apiController->propertiesStore('b', 'Pending');
        $apiController->propertiesStore('b', 'Contingent');

        $apiController->propertiesStore('c', 'Active');
        $apiController->propertiesStore('c', 'Pending');
        $apiController->propertiesStore('c', 'Contingent');

        $apiController->propertiesStore('d', 'Active');
        $apiController->propertiesStore('d', 'Pending');
        $apiController->propertiesStore('d', 'Contingent');

        return 0;
    }
}
