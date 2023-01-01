<?php

namespace App\Repositories;

use App\Interfaces\JobRepositoryInterface;
use App\Models\Job;

class JobRepository implements JobRepositoryInterface
{

    public function getAll()
    {
        return Job::with( 'jobType', 'jobOffers' )->paginate(10);
    }

    public function getActive()
    {
        return Job::isActive(1)
            ->with('jobType', 'jobOffers')
            ->paginate(10);
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

    public function filterJob( array $filters )
    {
       $jobQuery = Job::isActive(1)->with('jobType');

       if ( isset($filters['title'])) {
           $jobQuery->where('title', 'LIKE', "%{$filters['title']}%");
       }
       if ( isset($filters['description']) ) {
           $jobQuery->orWhere('description', 'LIKE', "%{$filters['description']}%");
       }

        if ( isset($filters['status']) ) {
            $jobQuery->whereStatus($filters['status'] );
        }

        if ( isset($filters['job_id']) ) {
            $jobQuery->whereJobId( $filters['job_id'] );
        }
        if ( isset($filters['min']) ) {
            $jobQuery->where('budget', '>=', $filters['min']  );
        }

        if ( isset($filters['min'])  && isset($filters['max'])  ) {
            $jobQuery->whereBetween('budget', [$filters['min'], $filters['max'] ] );
        }

       return $jobQuery->paginate(10);
    }

    public function activateJob(int $id)
    {
        return Job::where('id', $id)->update(['is_active' => true]);
    }

    public function deactivateJob(int $id)
    {
        return Job::where('id', $id)->update(['is_active' => false]);
    }
}
