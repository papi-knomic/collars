<?php

use App\Models\JobType;

if (!function_exists('getJobTypesArray')) {
    /**
     * Return list of available meal types
     * @return array
     */
    function getJobTypesArray(): array
    {
        return JobType::orderBy('id')
            ->get()->pluck('id')
            ->toArray();
    }
}
