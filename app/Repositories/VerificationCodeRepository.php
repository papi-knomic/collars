<?php

namespace App\Repositories;

use App\Interfaces\VerificationCodeRepositoryInterface;
use App\Mail\Verification;
use App\Models\VerificationCode;
use Carbon\Carbon;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Mail;

class VerificationCodeRepository implements VerificationCodeRepositoryInterface
{


    public function verifyEmail(string $code, string $email)
    {
        // TODO: Implement verifyEmail() method.
    }

    public function sendResetPasswordCode(string $email)
    {
        // TODO: Implement sendResetPasswordCode() method.
    }
}
