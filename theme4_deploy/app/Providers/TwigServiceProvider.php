<?php


namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Twig\TwigFunction;

class TwigServiceProvider extends ServiceProvider
{
    const TEMPLATE_PATH = __DIR__.'/../Views';

    public function boot()
    {
        $loader = new FilesystemLoader(self::TEMPLATE_PATH);

        $twig = new Environment($loader);

        $twig->addFunction(new TwigFunction('route', [$this, 'generateRoute']));
        $twig->addGlobal('user', null);

        $this->app->instance(Environment::class, $twig);
    }

    /**
     * Generate route by its name and parameters.
     *
     * @param string $name
     * @param array $parameters
     * @return string
     */
    public function generateRoute(string $name, array $parameters = []): string
    {
        return route($name, $parameters);
    }
}
