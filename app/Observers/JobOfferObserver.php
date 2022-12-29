<?php

namespace App\Observers;

use App\Models\JobOffer;
use App\Models\JobType;

class JobOfferObserver
{
    /**
     * Handle the JobType "creating" event.
     *
     * @param JobOffer $jobOffer
     * @return void
     */
    public function creating(JobOffer $jobOffer)
    {
        $jobOffer->worker_id = auth()->id();
        $jobOffer->status = 'open';
    }

    /**
     * Handle the JobType "updating" event.
     *
     * @param JobOffer $jobOffer
     * @return void
     */
    public function updating(JobOffer $jobOffer)
    {
    }
}
