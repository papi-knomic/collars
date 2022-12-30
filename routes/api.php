<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\JobOfferController;
use App\Http\Controllers\JobTypeController;
use App\Traits\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['middleware' => ['json']], function () {
    Route::get('/', function () {
        return Response::successResponse('Welcome to Collars');
    });

    //register
    Route::post('/register', [AuthController::class, 'register']);
    //login
    Route::post('/login', [AuthController::class, 'login']);

    //protected routes
    Route::group(['middleware' => ['auth:sanctum']], function () {
        Route::prefix('account')->group(function () {
            //create
            Route::get('/profile', [AuthController::class, 'profile']);
        });

        //get all job types
        Route::get('/job-types', [JobTypeController::class, 'index']);

        Route::prefix('jobs')->group( function () {
            //get all
            Route::get('/', [ JobController::class, 'index' ] );
            //get active jobs
            Route::get('/active', [ JobController::class, 'activeJobs' ] );
            //search
            Route::get('/search', [JobController::class, 'search']);
            //get single job
            Route::get('/{job}', [JobController::class, 'show']);

            Route::middleware('user')->group( function () {
                //create job
                Route::post('/', [JobController::class, 'store']);
                //update job
                Route::put('/{job}', [JobController::class, 'update']);
                //activate job
                Route::put('/activate/{id}', [JobController::class, 'activate']);
                //deactivate job
                Route::put('/deactivate/{id}', [JobController::class, 'deactivate']);
            });
        });


        //admin prefix
        Route::prefix('admin')->middleware('admin')->group( function () {
            //create job type
            Route::post('/job-types', [JobTypeController::class, 'store']);
            //update job type
            Route::put('/job-types/{jobType}', [JobTypeController::class, 'update']);
            //delete job type
            Route::delete('/job-types/{jobType}', [JobTypeController::class, 'delete']);
        });

        Route::prefix('job-offers')->group( function () {
            //get single offer
            Route::get('/{jobOffer}', [JobOfferController::class, 'show']);
            //all job offer endpoints for user
            Route::middleware('user')->group(function () {
                Route::get('/job/{job}', [JobOfferController::class, 'getForJob']);
            });
            //
            Route::middleware('worker')->group(function () {
                //Get job offers
                Route::get('/', [JobOfferController::class, 'index']);
                //Create job offer
                Route::post('/', [JobOfferController::class, 'store']);

            });



        });

        //logout
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});
