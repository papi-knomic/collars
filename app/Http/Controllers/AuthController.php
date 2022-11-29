<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Repositories\UserRepository;
use App\Traits\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Registers a user
     *
     * @param RegisterUserRequest $request
     * @return JsonResponse
     */
    public function register( RegisterUserRequest $request ): JsonResponse
    {
        $fields = $request->validated();
        if( $fields['role'] == 'worker' && empty( $fields['job_type'] ) ){
            return Response::errorResponse('Worker accounts must have job type');
        }
        $user = $this->userRepository->create($fields);

        return Response::successResponseWithData($user, 'Successful!, check your mail for verification code' );
    }

    /**
     * Logs in a user
     *
     * @param LoginUserRequest $request
     * @return JsonResponse
     */
    public function login( LoginUserRequest $request ): JsonResponse
    {
        $userData = $request->validated();

        if (Auth::attempt($userData)) {
            $accessToken = Auth::user()->createToken(env('TOKEN'))->plainTextToken;
            $data = auth()->user();
            return Response::successResponseWithData($data, 'Login successful', 200, $accessToken);
        }
        return Response::errorResponse('Invalid Login credentials', 400);
    }

    /**
     * Deletes current access token of user
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout( Request $request ): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return Response::successResponse('Logged out successfully');
    }

    public function profile( Request $request ): JsonResponse
    {
        $accessToken = Auth::user()->createToken(env('TOKEN'))->plainTextToken;
        $data = auth()->user();
        return Response::successResponseWithData($data, 'Profile data gotten', 200, $accessToken);
    }
}
