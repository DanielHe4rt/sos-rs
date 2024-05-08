<?php

namespace App\Models\Shelter;

use App\Enums\ShelterNeedTypeEnum;
use App\Models\Necessity\Necessity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShelterNeed extends Pivot
{
    use SoftDeletes, HasFactory;

    protected $table = 'shelters_needs';

    protected $fillable = [
        'shelter_id',
        'necessity_id',
        'type_id',
    ];

    protected $casts = [
        'type_id' => ShelterNeedTypeEnum::class
    ];

    public function shelter(): BelongsTo
    {
        return $this->belongsTo(Shelter::class);
    }

    public function necessity(): BelongsTo
    {
        return $this->belongsTo(Necessity::class);
    }
}
