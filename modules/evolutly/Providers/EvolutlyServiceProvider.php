<?php

namespace Modules\Evolutly\Providers;

use Modules\Evolutly\Evolutly;
use Illuminate\Support\ServiceProvider;
use Modules\Evolutly\Console\Commands\VersionCommand;

class EvolutlyServiceProvider extends ServiceProvider
{

    public function boot()
    {   
        $this->loadViewsFrom(EVOLUTLY_PATH.'/resources/views/modules/employee', 'employee');
        $this->loadViewsFrom(EVOLUTLY_PATH.'/resources/views/modules/client', 'client');
        $this->loadViewsFrom(EVOLUTLY_PATH.'/resources/views/modules/evolutly', 'evolutly');
        $this->loadViewsFrom(EVOLUTLY_PATH.'/resources/views/modules/project', 'project');
        $this->loadViewsFrom(EVOLUTLY_PATH.'/resources/views/modules/campaign', 'campaign');
        $this->loadViewsFrom(EVOLUTLY_PATH.'/resources/views/modules/task', 'task');
        $this->loadViewsFrom(EVOLUTLY_PATH.'/resources/views/modules/subtask', 'subtask');
        $this->loadViewsFrom(EVOLUTLY_PATH.'/resources/views/modules/form', 'form');
        $this->loadViewsFrom(EVOLUTLY_PATH.'/resources/views/modules/activity', 'activity');
        $this->loadViewsFrom(EVOLUTLY_PATH.'/resources/views/modules/comment', 'comment');
        $this->loadViewsFrom(EVOLUTLY_PATH.'/resources/views/modules/css', 'css');
        $this->loadViewsFrom(EVOLUTLY_PATH.'/resources/views/modules/tenant', 'tenant');
        $this->loadViewsFrom(EVOLUTLY_PATH.'/resources/views/modules/file', 'file');
        $this->loadViewsFrom(EVOLUTLY_PATH.'/resources/views/modules/template', 'template');
    }

    public function register()
    {
        if (! defined('EVOLUTLY_PATH')) {
            define('EVOLUTLY_PATH', realpath(__DIR__.'/../../../'));
        }

         if (! class_exists('Evolutly')) {
            class_alias('Modules\Evolutly\Evolutly', 'Evolutly');
        }

        if ($this->app->runningInConsole()) {
            $this->commands([
                VersionCommand::class,
                // Add Other Console Commands Here
            ]);
        }

        $this->registerServices();
    }

    /**
     * Register the Evolutly services.
     *
     * @return void
     */
    protected function registerServices()
    {

        $services = [
            'Contracts\InitialFrontendState' => 'InitialFrontendState',
        ];

        foreach ($services as $key => $value) {
            $this->app->singleton('Modules\Evolutly\\'.$key, 'Modules\Evolutly\\'.$value);
        }
    }
}
