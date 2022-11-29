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

    public function update(array $data)
    {
        // TODO: Implement update() method.
    }

    public function delete(array $data)
    {
        // TODO: Implement delete() method.
    }

    public function getAll()
    {
        return JobType::orderBy('id')->paginate(10);
    }
}
