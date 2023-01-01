<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateJobRequest;
use App\Http\Requests\SearchJobRequest;
use App\Http\Resources\JobResource;
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
        $jobsResource = JobResource::collection($jobs)->response()->getData(true);
        return Response::successResponseWithData( $jobsResource, 'Jobs gotten');

    }

    public function activeJobs()
    {
        $jobs = $this->jobRepository->getActive();
        $jobsResource = JobResource::collection($jobs)->response()->getData(true);
        return Response::successResponseWithData( $jobsResource, 'Jobs gotten');
    }


    public function show( Job $job ) {
        if ( !$job ) {
            return Response::errorResponse('Job not found');
        }
        $job = $this->jobRepository->getJob( $job->id );

        return Response::successResponseWithData( $job );
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

     if ( !checkJobCreator($job) ){
         return Response::errorResponse('You are not authorised to do this');
     }

     $job = $this->jobRepository->update( $job->id, $fields );
     return Response::successResponseWithData($job);
    }

    public function search( SearchJobRequest $request ) : JsonResponse
    {
        $filters = $request->validated();
        $jobs = $this->jobRepository->filterJob( $filters );
        $jobsResource = JobResource::collection($jobs)->response()->getData(true);
        return Response::successResponseWithData( $jobsResource, 'Jobs gotten');
    }

    public function activate( int $id ) : JsonResponse
    {
        $job = Job::find($id);
        if ( !$job ) {
            return Response::errorResponse('Job does not exist', 404 );
        }
        if ( !checkJobCreator($job) ){
            return Response::errorResponse('You are not authorised to do this');
        }
        $this->jobRepository->activateJob( $id );
        return  Response::successResponse('Job activated', 201 );
    }

    public function deactivate( int $id ) : JsonResponse
    {
        $job = Job::find($id);
        if ( !$job ) {
            return Response::errorResponse('Job does not exist', 404 );
        }
        if ( !checkJobCreator($job) ){
            return Response::errorResponse('You are not authorised to do this');
        }
        $this->jobRepository->deactivateJob( $id );
        return  Response::successResponse('Job deactivated', 201 );
    }


}
