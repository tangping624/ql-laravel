<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class EloquentEventServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // \App\Models\Praise::observe(\App\Models\Observers\Praise::class);
        // \App\Models\Star::observe(\App\Models\Observers\Star::class);
        \App\Models\Image::observe(\App\Models\Observers\Image::class);
        \App\Models\Tag::observe(\App\Models\Observers\Tag::class);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
