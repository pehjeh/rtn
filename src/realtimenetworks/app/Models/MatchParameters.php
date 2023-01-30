<?php

namespace App\Models;

use App\Models\Traits\Cacheable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchParameters extends Model
{
    use HasFactory, Cacheable;

    protected $cacheKey = 'model.match_parameters';
    protected $cacheDriver = 'file';

    protected $fillable = [
        'id',
        'name',
    ];
}
