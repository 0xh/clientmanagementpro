<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Subtask;
use App\Observers\SubtaskObserver;
use Queue;
use DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Subtask::observe(SubtaskObserver::class);
        Queue::looping(function () {
            while (DB::transactionLevel() > 0) {
                DB::rollBack();
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
