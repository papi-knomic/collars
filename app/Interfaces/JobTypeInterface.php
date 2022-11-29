<?php

namespace App\Interfaces;

interface JobTypeInterface
{
    public function create( array $data );

    public function update( array $data );

    public function delete( array $data );
}
