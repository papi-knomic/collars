<?php

use App\Models\JobOffer;

if (!function_exists('checkIfJobOfferExists')) {
    /**
     * Return list of available meal types
     * @param int $jobID
     * @param int $workerID
     * @return bool
     */
    function checkIfJobOfferExists( int $jobID, int $workerID ): bool
    {
        return JobOffer::where('job_id', $jobID)
            ->where('worker_id', $workerID)->exists();
    }
}
