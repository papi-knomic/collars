<?php

namespace App\Interfaces;

interface VerificationCodeInterface
{
    public function sendVerificationCode( string $email );

    public function verifyEmail( string $code, string $email );

    public function sendResetPasswordCode( string $email );



}
