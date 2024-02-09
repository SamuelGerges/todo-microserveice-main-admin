<?php

namespace App\Providers;

use App\Jobs\ProductDeleted;
use App\Jobs\ProductJob;
use App\Jobs\ProductUpdated;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{

    public function boot()
    {
        \App::bindMethod(ProductJob::class.'@handle',function($job){
            $job->handle();
        });
        \App::bindMethod(ProductUpdated::class.'@handle',function($job){
            $job->handle();
        });

        \App::bindMethod(ProductDeleted::class.'@handle',function($job){
            $job->handle();
        });

    }
}
