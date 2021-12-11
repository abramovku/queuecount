<?php

namespace Abram\Queuecount;

use Abram\Queuecount\Command\QueueCountCommand;
use Illuminate\Support\ServiceProvider;

class QueuecountServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/queueCount.php' => config_path('queueCount.php'),
            ]);

            $this->mergeConfigFrom(
                __DIR__.'/../config/queueCount.php', 'queueCount'
            );

            $this->commands([
                QueueCountCommand::class
            ]);
        }
    }
}
