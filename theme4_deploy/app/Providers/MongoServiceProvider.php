<?php


namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use MongoDB\Client;

class MongoServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }

    public function register()
    {
        $dsn = 'mongodb+srv://horoshijavtobus:'.env('DB_PASSWORD').'@horoshijavtobus-gaihs.mongodb.net/test?retryWrites=true&w=majority';
        $this->app->instance(Client::class, new Client($dsn));
    }
}
