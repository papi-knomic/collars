<?php

namespace App\Observers;

use App\Models\JobType;
use App\Models\User;

class JobTypeObserver
{
    /**
     * Handle the JobType "creating" event.
     *
     * @param  \App\Models\JobType  $jobType
     * @return void
     */
    public function creating(JobType $jobType)
    {
        $name = strtolower( $jobType->name );
        $jobType->name = ucfirst( $name );
    }

    /**
     * Handle the JobType "updating" event.
     *
     * @param  \App\Models\JobType  $jobType
     * @return void
     */
    public function updating(JobType $jobType)
    {
        $name = strtolower( $jobType->name );
        $jobType->name = ucfirst( $name );
    }
}
