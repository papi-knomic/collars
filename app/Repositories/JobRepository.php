<?php

namespace App\Repositories;

use App\Interfaces\JobRepositoryInterface;
use App\Models\Job;

class JobRepository implements JobRepositoryInterface
{

    public function getAll()
    {
//        return Job::orderBy('id)->paginate(10);
        return Job::get();
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

    public function filterJob($title = null, $description = null, $status = null)
    {
//       $jobQuery = Job::active()->where('name', 'LIKE', "%{$name}%");
    }
}
