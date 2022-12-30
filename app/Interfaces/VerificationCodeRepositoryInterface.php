<?php

namespace App\Interfaces;

interface VerificationCodeRepositoryInterface
{
    public function verifyEmail( string $code, string $email );

    public function sendResetPasswordCode( string $email );
}
