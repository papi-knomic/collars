<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

if (!function_exists('generateVerificationCode')) {
    /**
     * Generate Verification Code
     * @return array
     * @throws Exception
     */
    function generateVerificationCode(): array
    {
        $code = random_int(1000, 9999);
        $hashedCode = Hash::make($code);
        return [
            'code' => $code,
            'hash' => $hashedCode
        ];
    }
}

if ( !function_exists('getUserFirstNameFromEmail') ) {
    function getUserFirstNameFromEmail( string $email )
    {
        $user = User::where('email', $email)->first();

        if ( $user ) {
            return $user->first_name;
        }

        return false;
    }
}
