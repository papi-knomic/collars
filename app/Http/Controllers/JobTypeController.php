<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateJobTypeRequest;
use App\Repositories\JobTypeRepository;
use App\Traits\Response;
use Illuminate\Http\Request;

class JobTypeController extends Controller
{
    private $jobTypeRepository;

    public function __construct( JobTypeRepository $jobTypeRepository ) {
        $this->jobTypeRepository = $jobTypeRepository;
    }

    public function store( CreateJobTypeRequest $request ){
        $fields = $request->validated();
        if ( !auth()->user()->is_admin ){
            return Response::errorResponse('You are not an admin');
        }
        $jobType = $this->jobTypeRepository->create($fields);
        return  Response::successResponseWithData($jobType, 'Job type created', 201 );
    }

    public function index() {
        if ( !auth()->user()->is_admin ){
            return Response::errorResponse('You are not an admin');
        }
        $jobTypes = $this->jobTypeRepository->getAll();
        return  Response::successResponseWithData($jobTypes, 'Job types gotten', 201 );
    }
}
