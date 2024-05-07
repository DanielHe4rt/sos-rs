<?php

namespace App\Models\Shelter;

use App\Models\Necessity\Necessity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    public function shelter(): BelongsTo
    {
        return $this->belongsTo(Shelter::class);
    }

    public function necessity(): BelongsTo
    {
        return $this->belongsTo(Necessity::class);
    }
}
