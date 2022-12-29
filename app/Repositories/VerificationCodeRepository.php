<?php

namespace App\Repositories;

use App\Interfaces\VerificationCodeInterface;
use App\Mail\Verification;
use App\Models\VerificationCode;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

class VerificationCodeRepository implements VerificationCodeInterface
{

    /**
     * @throws \Exception
     */
    public function sendVerificationCode(string $email)
    {
        $verifyData = generateVerificationCode();
        $hashedCode = $verifyData['hash'];
        $code = $verifyData['code'];
        $firstname = getUserFirstNameFromEmail($email);
        $data = [
            'code' => $hashedCode,
            'verifiable' => $email,
            'expires_at' => Carbon::now()->addHour()->toDateTimeString(),
        ];

        $checkExistingCodes = VerificationCode::where('verifiable',  $email)->get();

        if ($checkExistingCodes) {
            foreach ($checkExistingCodes as $existingCodes) {
                $codes = VerificationCode::find($existingCodes->id);
                $codes->delete();
            }
        }

        VerificationCode::create($data);

        $details = [
            'subject' => 'Verify Email Address',
            'message' => 'Your verification code: :code',
            'code' => $code,
            'firstname' => $firstname
        ];

        Mail::to($email)->send( new Verification($details));

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
