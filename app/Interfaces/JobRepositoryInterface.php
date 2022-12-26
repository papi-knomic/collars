<?php

namespace App\Interfaces;

interface JobRepositoryInterface
{
    public function getAll();

    public function getActive();

    public function getJob( int $id );

    public function create( array $data );

    public function update( int $id, array $data );

    public function delete( int $id );

    public function changeStatus( int $id, string $status );

    public function filterJob( array $filters );

    public function activateJob( int $id );

    public function deactivateJob( int $id );
}
