<?php

namespace CspCascade;

use Illuminate\Support\ServiceProvider;

class CspCascadeServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot(CspCascade $extension)
    {
        if (! CspCascade::boot()) {
            return ;
        }

        if ($views = $extension->views()) {
            $this->loadViewsFrom($views, 'laravel-admin-cascade');
        }

        if ($this->app->runningInConsole() && $assets = $extension->assets()) {
            $this->publishes(
                [$assets => public_path('vendor/laravel-admin-ext/cascade')],
                'laravel-admin-cascade'
            );
        }

        $this->app->booted(function () {
            CspCascade::routes(__DIR__.'/../routes/web.php');
        });
    }
}