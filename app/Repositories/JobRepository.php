<?php

namespace App\Repositories;

use App\Interfaces\JobRepositoryInterface;
use App\Models\Job;

class JobRepository implements JobRepositoryInterface
{

    public function getAll()
    {
//        return Job::orderBy('id)->paginate(10);
        return Job::with('jobType')->get();
    }

    public function getActive()
    {
        return Job::isActive(1)
            ->with('jobType')
            ->get();
    }

    public function getJob( int $id )
    {
        return Job::where('id', $id)->with('jobType')->first();
    }

    public function create(array $data)
    {
        return Job::create($data);
    }

    public function update(int $id, array $data)
    {
        $job = Job::find($id);
        $job->update($data);

        return $job;
    }

    public function delete(int $id)
    {
        return Job::find($id)->delete();
    }

    public function changeStatus(int $id, string $status)
    {
        return Job::where('id', $id)->update(['status' => $status]);
    }

    public function filterJob($title = null, $description = null, $status = null, $min = 0, $max = 0, $jobID = 0 )
    {
       $jobQuery = Job::isActive(1)->where('title', 'LIKE', "%{$title}%")
       ->with('jobType');

       if ( $description ) {
           $jobQuery->orWhere('description', 'LIKE', "%{$description}%");
       }

        if ( $status ) {
            $jobQuery->where('status', $status );
        }

        if ( $jobID ) {
            $jobQuery->where('job_id', $jobID );
        }

        if ( $min ) {
            $jobQuery->whereBetween('price_range_min', '>=', $min );
        }

        if ( $max ) {
            $jobQuery->where('price_range_max', '<=', $max );
//                ->orWhere('price_range_max', '>=', $max);
        }

       return $jobQuery->get();
    }
}
