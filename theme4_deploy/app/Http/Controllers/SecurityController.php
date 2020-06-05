<?php


namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laravel\Lumen\Routing\Controller;
use Symfony\Component\HttpFoundation\Cookie;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class SecurityController extends Controller
{
    const COOKIE_NAME = 'api_token';

    /**
     * @var Environment
     */
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }


    /**
     * Generate login view or authenticate.
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function login(Request $request, Response $response)
    {
        $err = [];

        if ($request->method() === 'POST') {
            $password = $request->input('password');

            if ($password === env('APP_PASSWORD')) {
                $response
                    ->setStatusCode(Response::HTTP_MOVED_PERMANENTLY)
                    ->header('Location', route('index'))
                    ->withCookie(new Cookie(self::COOKIE_NAME, password_hash($password, PASSWORD_DEFAULT)))
                ;
                return $response;
            } else {
                $err['password'] = 'Incorrect password';
            }
        }

        $response
            ->setContent($this->twig->render('security/login.html.twig', ['errors' => $err]))
        ;

        return $response;
    }

    /**
     * Remove the cookie.
     *
     * @param Response $response
     * @return Response
     */
    public function logout(Response $response)
    {
        $response
            ->setStatusCode(Response::HTTP_MOVED_PERMANENTLY)
            ->header('Location', route('index'))
            ->withCookie(new Cookie(self::COOKIE_NAME, null, 1))
        ;

        return $response;
    }
}
