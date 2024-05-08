<?php

namespace App\Console\Commands;

use App\Clients\Airtable\AirtableClient;
use App\Clients\Airtable\Enums\NeedVolunteersEnum;
use App\Enums\DataProviderEnum;
use App\Models\Neighborhood;
use App\Models\Shelter\Shelter;
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

        $shelters = $airtableClient->getRecords(config('services.airtable.base_id'), $tableId);

        foreach($shelters as $shelter) {

            $neighborhoodName = str($shelter->neighborhood)->slug()->toString();

            $neighborhoodId = Neighborhood::where('slug', $neighborhoodName)->first()?->id ?? 1;

            Shelter::updateOrCreate([
                'provider' => DataProviderEnum::Airtable,
                'provider_id' => $shelter->id,
            ], [
                'name' => $shelter->institution_name,
                'neighborhood_id' => $neighborhoodId,
                'zone' => $shelter->zone,
                'need_volunteers' => $shelter->need_volunteers, // ENUM: yes, no, not informed
                'address' => $shelter->address,
                'pix' => 'N/A',
                'phone_number' => $shelter->responsible_phone,
                'shelter_capacity_count' => 100,
                'sheltered_capacity_count' => 100,
                'is_pet_friendly' => false,
            ]);

        }


        return self::SUCCESS;
    }
}
