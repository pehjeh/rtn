<?php

namespace App\Observers;

use App\Models\MatchModel;

class MatchObserver
{
    /**
     * Handle the MatchModel "created" event.
     *
     * @param \App\Models\MatchModel $matchModel
     * @return void
     */
    public function created(MatchModel $matchModel)
    {
        $matchModel->cacheBuild();
    }

    /**
     * Handle the MatchModel "updated" event.
     *
     * @param \App\Models\MatchModel $matchModel
     * @return void
     */
    public function updated(MatchModel $matchModel)
    {
        $matchModel->cacheBuild();
    }

    /**
     * Handle the MatchModel "deleted" event.
     *
     * @param \App\Models\MatchModel $matchModel
     * @return void
     */
    public function deleted(MatchModel $matchModel)
    {
        $matchModel->cacheBuild();
    }

    /**
     * Handle the MatchModel "restored" event.
     *
     * @param \App\Models\MatchModel $matchModel
     * @return void
     */
    public function restored(MatchModel $matchModel)
    {
        //
    }

    /**
     * Handle the MatchModel "force deleted" event.
     *
     * @param \App\Models\MatchModel $matchModel
     * @return void
     */
    public function forceDeleted(MatchModel $matchModel)
    {
        //
    }
}
