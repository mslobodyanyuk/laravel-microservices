<?php

namespace App\Providers;

use App\Jobs\TestJob;
use App\Jobs\ProductLiked;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    public function boot()
    {
        \App::bindMethod(TestJob::class . '@handle', fn($job) => $job->handle());
        \App::bindMethod(ProductLiked::class. '@handle', fn($job) => $job->handle());
    }
}
