<?php

namespace App\Console\Commands;

use App\Clients\AirtableClient;
use Illuminate\Console\Command;

class PopulateSheltersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'shelter:airtable';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Populate shelters from Airtable Link.';

    /**
     * Execute the console command.
     */
    public function handle(AirtableClient $airtableClient): int
    {
        $tableId = 'tbliNxYn72u47Y1E3';

        $response = $airtableClient->getRecords(config('services.airtable.base_id'), $tableId);


        return self::SUCCESS;
    }
}
