<?php


namespace App\Http\Controllers;


use Laravel\Lumen\Routing\Controller;

class ArticleController extends Controller
{
    public function read($themeSlug, $articleSlug=null)
    {
        return "$themeSlug, $articleSlug";
    }
}
