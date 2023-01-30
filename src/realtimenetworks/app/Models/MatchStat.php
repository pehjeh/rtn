<?php

namespace App\Models;

use App\Observers\MatchStatObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchStat extends Model
{
    use HasFactory;

    public static function boot()
    {
        parent::boot();
//        MatchStat::observe(MatchStatObserver::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function match()
    {
        return $this->belongsTo(MatchModel::class);
    }

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function parameter()
    {
        return $this->belongsTo(MatchParameters::class, 'param_id');
    }
}
