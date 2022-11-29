<?php

namespace App\Repositories;

use App\Interfaces\JobTypeInterface;
use App\Models\JobType;

class JobTypeRepository implements JobTypeInterface
{

    public function create(array $data)
    {
        return JobType::create($data);
    }

    public function update(int $id, array $data)
    {
        $jobType = JobType::find($id);
        $jobType->update($data);
        return $jobType;
    }

    public function delete(int $id)
    {
        return JobType::find($id)->delete();
    }

    public function getAll()
    {
//        return JobType::orderBy('id')->paginate(10);
        return JobType::get();
    }
}
