<?php

namespace App\Observers;

use App\Http\Controllers\VerificationCodeController;
use App\Mail\Verification;
use App\Models\Product;
use App\Models\User;
use App\Models\VerificationCode;
use App\Notifications\EmailVerificationNotification;
use App\Notifications\WelcomeMailNotification;
use App\Repositories\VerificationCodeRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param \App\Models\User $user
     * @return void
     * @throws \Exception
     */
    public function created(User $user)
    {
        $this->generateUserVerificationCode($user->email);
    }

    /**
     * Handle the Product "creating" event.
     *
     * @param  \App\Models\User  $product
     * @return void
     */
    public function creating(User $user)
    {
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        $emailWasVerified = $user->wasChanged('email_verified_at');

        if ($emailWasVerified) {
            $firstname = $user->firstname;

            $data = [
                'subject' => "Welcome to Collars {$firstname}",
                'firstname' => $firstname
            ];

            Notification::route('mail', $user->email)->notify((new WelcomeMailNotification($data)));
        }
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the User "restored" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }

    /**
     * @throws \Exception
     */
    private function generateUserVerificationCode(string $email ) {
        $code = generateVerificationCodeForUser($email);
        $firstname = getUserFirstNameFromEmail($email);

        $details = [
            'subject' => 'Verify Email Address',
            'message' => 'Your verification code: :code',
            'code' => $code,
            'firstname' => $firstname
        ];

        Notification::route('mail', $email)
            ->notify(new EmailVerificationNotification($details));

    }
}
