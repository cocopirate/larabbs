<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
	{
		\App\Models\User::observe(\App\Observers\UserObserver::class);
		\App\Models\Reply::observe(\App\Observers\ReplyObserver::class);
		\App\Models\Topic::observe(\App\Observers\TopicObserver::class);
		\App\Models\Link::observe(\App\Observers\LinkObserver::class);

        if (getenv('IS_IN_HEROKU')){
            \URL::forceScheme('https');
        }

        Carbon::setLocale('zh');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if( app()->isLocal() ){
            $this->app->register(\VIACreative\SudoSu\ServiceProvider::class);
        }

        \API::error(function (ModelNotFoundException $exception){
            abort(404);
        });

        \API::error(function (AuthorizationException $exception){
            abort(403, $exception->getMessage());
        });
    }
}
