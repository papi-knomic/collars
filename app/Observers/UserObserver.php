<?php

namespace App\Observers;

use App\Http\Controllers\VerificationCodeController;
use App\Models\Product;
use App\Models\User;
use App\Repositories\VerificationCodeRepository;
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
        ( new VerificationCodeRepository() )->sendVerificationCode($user->email);
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
        //
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
}
