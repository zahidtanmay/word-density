<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DensityList extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'url',
        'notes',
    ];

    protected $table = 'word_density';
}
