<?php

namespace App\Interfaces;

interface JobRepositoryInterface
{
    public function getAll();

    public function create( array $data );

    public function update( int $id, array $data );

    public function delete( int $id );

    public function changeStatus( int $id, string $status );
}
