<?php

namespace App\Models;

use App\Models\Traits\Cacheable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Player extends Model
{
    use HasFactory, Cacheable;

    protected $cacheKey = 'model.players';
    protected $cacheDriver = 'file';

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
}
