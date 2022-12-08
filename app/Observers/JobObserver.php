<?php

namespace App\Observers;

use App\Models\Job;
use Illuminate\Support\Str;

class JobObserver
{
    /**
     * Handle the Job "creating" event.
     *
     * @param  \App\Models\Job  $job
     * @return void
     */
    public function creating(Job $job)
    {
        $job->slug = generateJobSlug($job->title);
        $job->user_id = auth()->id();
        $job->status = 'open';
    }

    /**
     * Handle the Job "updating" event.
     *
     * @param  \App\Models\Job  $job
     * @return void
     */
    public function updating(Job $job)
    {
        $job->slug = Str::slug($job->title);
    }
}
