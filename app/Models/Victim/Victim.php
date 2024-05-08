<?php

namespace App\Models\Victim;

use App\Enums\VictimStatusEnum;
use App\Models\Shelter\Shelter;
use Clickbar\Magellan\Database\Eloquent\HasPostgisColumns;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Victim extends Model
{
    use SoftDeletes, HasFactory, HasPostgisColumns;

    protected $fillable = [
        'status_id',
        'shelter_id',
        'location',
        'name',
        'phone_number',
        'address',
        'notes',
    ];

    public function shelter(): BelongsTo
    {
        return $this->belongsTo(Shelter::class);
    }

    protected function casts(): array
    {
        return [
            'address' => 'array',
            'status_id' => VictimStatusEnum::class
        ];
    }

    protected array $postgisColumns = [
        'location' => [
            'type' => 'geometry',
            'srid' => 4326,
        ],
    ];
}
