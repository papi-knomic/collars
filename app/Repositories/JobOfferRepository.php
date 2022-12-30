<?php

namespace App\Repositories;

use App\Interfaces\JobOfferRepositoryInterface;
use App\Models\JobOffer;

class JobOfferRepository implements JobOfferRepositoryInterface
{

    public function create(array $data)
    {
       return JobOffer::create($data);
    }

    public function update(array $data)
    {
        // TODO: Implement update() method.
    }

    public function getOffersForJob(int $jobID)
    {
        return JobOffer::where('job_id', $jobID)->paginate(10);
    }

    public function getWorkerOffers(int $workerID)
    {
        return JobOffer::where('worker_id', $workerID)->paginate(10);
    }

    public function getOffer(int $offerID)
    {
        // TODO: Implement getOffer() method.
    }

    public function acceptOffer(int $offerID)
    {
        // TODO: Implement acceptOffer() method.
    }

    public function rejectOffer(int $offerID)
    {
        // TODO: Implement rejectOffer() method.
    }
}
