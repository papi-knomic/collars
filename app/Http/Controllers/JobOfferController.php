<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateJobOfferRequest;
use App\Http\Resources\JobOfferResource;
use App\Models\Job;
use App\Models\JobOffer;
use App\Repositories\JobOfferRepository;
use App\Traits\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JobOfferController extends Controller
{
    private $jobOfferRepository;


    public function __construct( JobOfferRepository $jobOfferRepository )
    {
        $this->jobOfferRepository = $jobOfferRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        if ( !auth()->user()->is_worker ) {
            return Response::errorResponse('Access Denied');
        }
        $id = auth()->id();
        $offers = $this->jobOfferRepository->getWorkerOffers( $id );
        $offersResource = JobOfferResource::collection($offers)->response()->getData();
        return Response::successResponseWithData( $offersResource, 'Job offers gotten');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateJobOfferRequest $request
     * @return JsonResponse
     */
    public function store(CreateJobOfferRequest $request)
    {
        $fields = $request->validated();

        if ( checkIfJobOfferExists( $fields['job_id'], auth()->id() ) ){
            return Response::errorResponse('Job offer already created for this job');
        }

        $jobOffer = $this->jobOfferRepository->create($fields);

        return Response::successResponseWithData($jobOffer, 'Job offer has been sent', 201);
    }

    /**
     * Display the specified resource.
     *
     * @param JobOffer $jobOffer
     * @return JsonResponse
     */
    public function show(JobOffer $jobOffer)
    {
        return Response::successResponseWithData($jobOffer);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param JobOffer $jobOffer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JobOffer $jobOffer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param JobOffer $jobOffer
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobOffer $jobOffer)
    {
        //
    }

    public function getForJob( Job $job ) : JsonResponse
    {
        $offers = $this->jobOfferRepository->getOffersForJob($job->id);
        $offersResource = JobOfferResource::collection($offers)->response()->getData();
        return Response::successResponseWithData( $offersResource, 'Job offers gotten');
    }
}
