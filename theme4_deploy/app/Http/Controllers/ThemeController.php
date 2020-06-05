<?php


namespace App\Http\Controllers;


use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use MongoDB\Client;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class ThemeController extends Controller
{
    /**
     * @var Client
     */
    private $mongo;
    /**
     * @var Environment
     */
    private $twig;

    public function __construct(Client $mongo, Environment $twig)
    {
        $this->mongo = $mongo;
        $this->twig = $twig;
    }

    /**
     * List themes.
     *
     * @param Request $request
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function index(Request $request)
    {
        return $this->twig->render('theme/index.html.twig');
    }

    /**
     * REST. Create a new theme.
     *
     * @param Request $request
     * @return string
     */
    public function create(Request $request, JsonResponse $response)
    {
        $code = Response::HTTP_CREATED;
        $data = [];

        $name = $request->input('name');
        $slug = $request->input('slug');

        if ($name && $slug) {
            // TODO: check the slug
            $collection = $this->mongo->web_portfolio->computerWorkshop;

            $theme = $collection->findOne(['slug' => $slug]);

            if (null === $theme) {
                $collection->insertOne(['name' => $name, 'slug' => $slug]);
                $data['msg'] = "Successful";
            } else {
                $code = Response::HTTP_BAD_REQUEST;
                $data['err'] = "Slug '$slug' is used already.";
                $data['slug'] = $slug;
            }
        } else {
            $data['err'] = 'Some fields are not provided';
        }

        return $response->setStatusCode($code)->setData($data);
    }

    public function read($themeSlug)
    {
        return "read $themeSlug";
    }

    public function put($themeSlug)
    {

    }

    public function delete($themeSlug)
    {

    }
}
