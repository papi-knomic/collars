<?php

namespace App\Interfaces;

interface RatingRepositoryInterface
{
    public function create( array $data );

    public function update( array $data );

    public function getRatings( int $workerID );
}
