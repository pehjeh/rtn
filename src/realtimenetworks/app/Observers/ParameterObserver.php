<?php

namespace App\Observers;

use App\Models\MatchParameters;

class ParameterObserver
{
    /**
     * Handle the MatchParameter "created" event.
     *
     * @param \App\Models\MatchParameters $matchParameter
     * @return void
     */
    public function created(MatchParameters $matchParameter)
    {
        $matchParameter->cacheBuild();
    }

    /**
     * Handle the MatchParameter "updated" event.
     *
     * @param \App\Models\MatchParameters $matchParameter
     * @return void
     */
    public function updated(MatchParameters $matchParameter)
    {
        $matchParameter->cacheBuild();
    }

    /**
     * Handle the MatchParameter "deleted" event.
     *
     * @param \App\Models\MatchParameters $matchParameter
     * @return void
     */
    public function deleted(MatchParameters $matchParameter)
    {
        $matchParameter->cacheBuild();
    }

    /**
     * Handle the MatchParameter "restored" event.
     *
     * @param \App\Models\MatchParameters $matchParameter
     * @return void
     */
    public function restored(MatchParameters $matchParameter)
    {
        //
    }

    /**
     * Handle the MatchParameter "force deleted" event.
     *
     * @param \App\Models\MatchParameters $matchParameter
     * @return void
     */
    public function forceDeleted(MatchParameters $matchParameter)
    {
        //
    }
}
