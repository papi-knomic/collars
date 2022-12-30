<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResendVerificationCodeRequest;
use App\Http\Requests\VerifyEmailRequest;
use App\Models\User;
use App\Models\VerificationCode;
use App\Repositories\JobRepository;
use App\Repositories\VerificationCodeRepository;
use App\Traits\Response;
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

        $code = VerificationCode::where('verifiable', $data['email'])->first();

        if (!$code) {
            return Response::errorResponse('Invalid code!', 403);
        }

        if ($code->expires_at < now()) {
            return Response::errorResponse('Invalid code!', 403);
        }

        $verify = $this::verify( $data['code'], $data['email'] );

        dd( $verify);

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
