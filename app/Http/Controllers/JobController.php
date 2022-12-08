<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateJobRequest;
use App\Models\Job;
use App\Repositories\JobRepository;
use App\Repositories\JobTypeRepository;
use App\Traits\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JobController extends Controller
{

    private $jobRepository;

    public function __construct( JobRepository $jobRepository ) {
        $this->jobRepository = $jobRepository;
    }

    public function index() {
        $jobs = $this->jobRepository->getAll();
        return Response::successResponseWithData( $jobs, 'Jobs gotten');
    }

    public function store( CreateJobRequest $request ): JsonResponse
    {
        $fields = $request->validated();
        $job = $this->jobRepository->create( $fields );
        return Response::successResponseWithData( $job, 'Job created', 201 );
    }

    public function update( CreateJobRequest $request, Job $job ) : JsonResponse
    {
     $fields = $request->validated();

     if ( auth()->id() != $job->user_id ){
         return Response::errorResponse('You are not authorised to do this');
     }

     $job = $this->jobRepository->update( $job->id, $fields );
     return Response::successResponseWithData($job);
    }


}
