<?php

namespace App\Providers;

use App\Http\Controllers\SecurityController;
use App\User;
use Illuminate\Auth\GenericUser;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
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
     * Boot the authentication services for the application.
     *
     * @return void
     */
    public function boot()
    {
        // Here you may define how you wish users to be authenticated for your Lumen
        // application. The callback which receives the incoming request instance
        // should return either a User instance or null. You're free to obtain
        // the User instance via an API token or any other method necessary.

        $this->app['auth']->viaRequest('api', function ($request) {
            $tokenHash = $request->cookie(SecurityController::COOKIE_NAME, null);

            if (null !== $tokenHash) {
                if (password_verify(env('APP_PASSWORD'), $tokenHash)) {
                    return new GenericUser(['role' => 'admin']);
                }
            }

            return null;
        });
    }
}