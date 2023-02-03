<?php

namespace App\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use Slim\Routing\RouteContext;


class LoginController
{
    public function index(Request $request, Response $response, $args){
        $view = Twig::fromRequest($request);
        $params = [];
        return $view->render($response, "login/index.html.twig", $params);   
    }

    public function login(Request $request, Response $response, $args){        
        $parsedUrl = RouteContext::fromRequest($request)->getRouteParser();
        $url = $parsedUrl->urlFor('auth');

        if(!empty($_SESSION)){
            if(isset($_SESSION['user-sistema-inv']) && $_SESSION['user-sistema-inv']['idUser'] != 0){
                    $url = $parsedUrl->urlFor('home');
                    return $response->withHeader('Location', $url)->withStatus(302);
            }
        }

        return $response->withHeader('Location', $url)->withStatus(302);
    }

    public function logout(Request $request, Response $response, $args){
        $parsedUrl = RouteContext::fromRequest($request)->getRouteParser();
        $url = $parsedUrl->urlFor('auth');
        
        unset($_SESSION['user-sistema-inv']);

        return $response->withHeader('Location', $url)->withStatus(302);
    }
}
