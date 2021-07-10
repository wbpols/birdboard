<?php

namespace App\Providers;

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
        $this->bootObservers();
    }


    /*
    |--------------------------------------------------------------------------
    | Custom Methods
    |--------------------------------------------------------------------------
    */

    /**
     * Bootstrap the model observers.
     *
     * @return void
     */
    private function bootObservers()
    {
        \App\Models\Project\Project::observe(\App\Observers\Project\ProjectObserver::class);
        \App\Models\Project\Task::observe(\App\Observers\Project\TaskObserver::class);
    }
}
