<?php

use App\Models\Job;
use Illuminate\Support\Str;

if (!function_exists('getJobTypesArray')) {
    /**
     * Return list of available meal types
     * @return array
     */
    function getJobTypesArray(): array
    {
        return Job::orderBy('id')
            ->get()->pluck('id')
            ->toArray();
    }
}

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
