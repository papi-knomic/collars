<?php

namespace App\Providers;

use App\Models\Job;
use App\Models\JobOffer;
use App\Models\JobType;
use App\Models\Product;
use App\Models\User;
use App\Models\Worker;
use App\Observers\JobObserver;
use App\Observers\JobOfferObserver;
use App\Observers\JobTypeObserver;
use App\Observers\ProductObserver;
use App\Observers\UserObserver;
use App\Observers\WorkerObserver;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        User::observe(UserObserver::class);
        Job::observe( JobObserver::class );
        JobType::observe( JobTypeObserver::class );
        JobOffer::observe( JobOfferObserver::class );
    }
}
