<?php

namespace App\Controllers;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

class ProductsController{
    

    public function index(Request $request, Response $response, $args){
        $view = Twig::fromRequest($request);
        $params = [];
        return $view->render($response, "products/index.html.twig", $params);   
    }

 
}
