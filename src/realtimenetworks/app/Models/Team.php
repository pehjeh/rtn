<?php

namespace App\Models;

use App\Models\Traits\Cacheable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use HasFactory, SoftDeletes, Cacheable;

    protected $cacheKey = 'model.teams';
    protected $cacheDriver = 'file';

    protected $fillable = [
        'name',
        'short_name',
    ];

    public function players()
    {
        return $this->hasMany(Player::class, 'team_id');
    }

    public function matches()
    {
        return $this->hasMany(MatchModel::class, 'team_id');
    }

    public function team_1()
    {
        return $this->belongsTo(Team::class, 'team_1_id');
    }

    public function team_2()
    {
        return $this->belongsTo(Team::class, 'team_2_id');
    }
}
