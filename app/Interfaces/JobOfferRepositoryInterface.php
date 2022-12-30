<?php

namespace App\Interfaces;

interface JobOfferRepositoryInterface
{
    public function create( array $data );

    public function update( array $data );

    public function getOffersForJob( int $jobID );

    public function getWorkerOffers( int $workerID );

    public function getOffer( int $offerID );

    public function acceptOffer( int $offerID );

    public function rejectOffer( int $offerID );

}
