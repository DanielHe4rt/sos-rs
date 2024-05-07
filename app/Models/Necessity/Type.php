<?php

namespace App\Models\Necessity;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Type extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'necessity_types';

    protected $fillable = [
        'name',
        'color',
    ];
}
