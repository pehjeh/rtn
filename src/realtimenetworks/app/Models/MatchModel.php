<?php

namespace App\Models;

use App\Models\Traits\Cacheable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchModel extends Model
{
    use HasFactory, Cacheable;

    protected $cacheKey = 'model.matches';
    protected $cacheDriver = 'file';

    protected $table = 'matches';

    protected $fillable = [
        'name',
        'match_at',
        'team_1_id',
        'team_1_score',
        'team_2_id',
        'team_2_score'
    ];

    protected $casts = [
        'match_at' => 'datetime:Y-m-d H:i:s',
    ];

    public function match_stats()
    {
        return $this->hasMany(Team::class, 'team_id');
    }
}
