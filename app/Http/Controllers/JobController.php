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

    public function activeJobs()
    {
        $jobs = $this->jobRepository->getActive();
        return Response::successResponseWithData( $jobs, 'Jobs gotten');
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

    public function search( Request $request ) : JsonResponse
    {
        $title = $request->title;
        $description = $request->description;
        $status = $request->status;
        $min = $request->min;
        $max = $request->max;
        $jobID = $request->job_id;
        $jobs = $this->jobRepository->filterJob( $title, $description, $status, $min, $max, $jobID );
        return Response::successResponseWithData( $jobs, 'Jobs gotten');
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
