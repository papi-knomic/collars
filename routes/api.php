<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobController;
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

        Route::prefix('jobs')->group( function () {
            //get all
            Route::get('/', [ JobController::class, 'index' ] );
            //get single job
            Route::get('/{job}', [JobController::class, 'show']);
            //create job
            Route::post('/', [JobController::class, 'store']);
            //update job
            Route::put('/{job}', [JobController::class, 'update']);
        });


        //admin prefix
        Route::prefix('admin')->group( function () {
            //get all job types
            Route::get('/job-type', [JobTypeController::class, 'index']);
            //create job type
            Route::post('/job-type', [JobTypeController::class, 'store']);
            //update job type
            Route::put('/job-type/{jobType}', [JobTypeController::class, 'update']);
            //delete job type
            Route::delete('/job-type/{jobType}', [JobTypeController::class, 'delete']);
        });

        //logout
        Route::post('/logout', [AuthController::class, 'logout']);
    });
});
