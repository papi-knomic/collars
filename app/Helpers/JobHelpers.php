<?php

use App\Models\Job;
use Illuminate\Support\Str;

if ( !function_exists('generateJobSlug') ) {
    function generateJobSlug( string $title ): string
    {
        $slug = Str::slug($title);
        $count = Job::where('slug', 'LIKE', "%$slug%")->count();

        if ( $count ){
            $count += 1;
            return "$slug-{$count}";
        }
        return $slug;
    }
}

if ( !function_exists('checkJobCreator') ) {
    function checkJobCreator( Job $job): string
    {
        return auth()->id() == $job->user_id;
    }
}
