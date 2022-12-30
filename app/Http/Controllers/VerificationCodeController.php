<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResendVerificationCodeRequest;
use App\Http\Requests\VerifyEmailRequest;
use App\Models\User;
use App\Models\VerificationCode;
use App\Repositories\JobRepository;
use App\Repositories\VerificationCodeRepository;
use App\Traits\Response;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class VerificationCodeController extends Controller
{
    private $verificationRepository;

    public function __construct(VerificationCodeRepository $verificationRepository) {
        $this->verificationRepository = $verificationRepository;
    }


    public function verifyEmail( VerifyEmailRequest $request ) {


        $data = $request->validated();

        $user = User::whereEmail($data['email'])->first();
        $code = VerificationCode::where('verifiable', $data['email'])->first();
        $invalidResponse = Response::errorResponse('Invalid code!');

        if (!$user) {
            return Response::errorResponse('Invalid details');
        }

        auth()->loginUsingId($user->id);

        if ($request->user()->hasVerifiedEmail()) {
            return Response::successResponse('Already verified', 200);
        }

        if (!$code) {
            return $invalidResponse;
        }

        if ($code->expires_at < now()) {
            return $invalidResponse;
        }

        $verify = $this::verify( $data['code'], $data['email'] );

        if (!$verify ) {
            return $invalidResponse;
        }

        $request->user()->markEmailAsVerified();

        return Response::successResponse('Verification successful', 200);
    }

    public function resendVerificationCode( ResendVerificationCodeRequest $request ) {

    }

    public static function verify($code, $email): bool
    {
        $getCode = VerificationCode::where('verifiable', $email)->first();
        if ($getCode) {
            $existingCode = $getCode->code;
            $correctCode = Hash::check($code, $existingCode);
            if ($correctCode) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}
