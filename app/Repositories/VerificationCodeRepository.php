<?php

namespace App\Repositories;

use App\Interfaces\VerificationCodeInterface;

class VerificationCodeRepository implements VerificationCodeInterface
{

    public function sendVerificationCode(string $email)
    {
        // TODO: Implement sendVerificationCode() method.
    }

    public function verifyEmail(string $code, string $email)
    {
        // TODO: Implement verifyEmail() method.
    }

    public function sendResetPasswordCode(string $email)
    {
        // TODO: Implement sendResetPasswordCode() method.
    }
}
