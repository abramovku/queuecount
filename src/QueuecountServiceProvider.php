<?php

namespace Abramovku\Queuecount;

use Abramovku\Queuecount\Command\QueueCountCommand;
use Illuminate\Support\ServiceProvider;

class QueuecountServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/queueCount.php' => config_path('queueCount.php'),
            ], 'queueConfig');

            $this->mergeConfigFrom(
                __DIR__.'/../config/queueCount.php', 'queueCount',
            );

            $this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/queueCount'),
            ], 'queueLocale');

            $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'queueCount');

            $this->commands([
                QueueCountCommand::class
            ]);
        }
    }
}
