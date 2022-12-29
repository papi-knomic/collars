<?php

namespace App\Http\Controllers;

use App\Models\VerificationCode;
use App\Repositories\JobRepository;
use App\Repositories\VerificationCodeRepository;
use Illuminate\Http\Request;

class VerificationCodeController extends Controller
{
    private $verificationRepository;

    public function __construct( VerificationCodeRepository $verificationRepository) {
        $this->verificationRepository = $verificationRepository;
    }

    /**
     * @throws \Exception
     */
    public function sendVerificationCode(string $email ) {
        $this->verificationRepository->sendVerificationCode( $email );
    }
}
