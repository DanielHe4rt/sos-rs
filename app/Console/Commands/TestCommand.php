<?php

namespace App\Console\Commands;

use App\Clients\GoogleMaps\GoogleMapsClient;
use GoogleMaps\Facade\GoogleMapsFacade;
use Illuminate\Console\Command;

class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(GoogleMapsClient $client)
    {
        $response = $client->getLocation('-22.661083333333334', '-44.99455533333333');

        dd($response);
    }
}
