<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Laravel\Spark\Repositories\NotificationRepository as Notification;

class ComposerServiceProvider extends ServiceProvider
{
    public function __construct(){
	  $this->data = array(
		'appcolor' => 'bg-darkTeal',
	  );
	}
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        $this->composeLatestNotification();
        $this->composeLogin();
        $this->composeAppColor();
        $this->composeTenant();
        $this->composeGuard();
        $this->composeFormBuilder();
        
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
    // Allow Notification in All View!
    private function composeLatestNotification()
    {
        view()->composer(['partials.header.notification_latest'], function($view)
        {
        $notification = new Notification();
        $notification = $notification->recent(auth()->user())->first();
        
        $view->with(compact('notification'));
        });

    }
    private function composeAppColor()
    {
        view()->composer('*', function($view){
            $view->with($this->data);
        });
    }

    private function composeTenant()
    {
        view()->composer('*', function($view){
        $guard = $this->getAuthGuard();
        if($guard === 'employee'){
        $employee = auth()->guard($guard)->user();
        $tenant = $employee->byTenant();
        }
        elseif($guard === 'client'){
        $client = auth()->guard($guard)->user();
        $tenant = $client->byTenant();
        } else {
        $tenant = auth()->guard('web')->user();
        }
        $view->with(['tenant' => $tenant]);
        });
    }

    private function getAuthGuard()
    {
        $guards = ['web', 'employee', 'client'];
        foreach ($guards as $guard) {
            if (auth()->guard($guard)->check()) {
                return $guard;
            }
        }
        return null;
    }

    private function composeGuard()
    {
        view()->composer('*', function($view){
        $guard = $this->getAuthGuard();
        $view->with(['guard' => $guard]);
        });
    }
 

    private function composeLogin()
    {
        view()->composer(['spark::auth.login', 'employee::login', 'client::login', 'employee::forgotpassword', 'client::forgotpassword', 'spark::auth.passwords.email'], function($view)
        {
        $dir = scandir(base_path('public/images/lock/landscape'));
        foreach ($dir as $key => $value) {
            if(preg_match('/^\.+$/',$value)) {unset($dir[$key]);continue;}
            $tdir[] = $dir[$key];
        }
        $lock_images = $tdir;
        $view->with(compact('lock_images'));
        });
    }

    private function composeFormBuilder()
    {
        view()->composer(['form::builder'], function($view){
        $this->data['js']['be_html'] = 'metro/plugins/beautify/beautify-html.js';
		$this->data['js']['zencode'] = 'metro/plugins/jQuery-ZenCoding.js';
		$this->data['js']['HTML']    = 'metro/plugins/HTML.js';
		$this->data['js']['pb']      = 'metro/plugins/powerbuilder/form.js';
		$this->data['js']['jqui']    = 'metro/plugins/jquery-ui.min.js';
        $view->with($this->data);
        });
    }
}