<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Neighborhood extends Model
{
    use SoftDeletes, HasFactory;

    protected $table = 'neighborhoods';

    protected $fillable = [
        'name',
        'slug',
    ];
}
