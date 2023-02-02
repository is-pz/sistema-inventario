<?php

namespace App\Middleware;

use Slim\Routing\RouteContext;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class AuhtMiddleware implements MiddlewareInterface
{
    public function process(Request $request, RequestHandler $handler): Response
    {
        
        if(!isset($_SESSION)){
            session_start();
        }     
        
        // if(isset($_COOKIE['sistema-inventario'])){
        //     if($_COOKIE['sistema-inventario']){
        //         return $handler->handle($request);
        //     }
        // }

        if(!isset($_SESSION['user-sistema-inv'])){
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            $url = $routeParser->urlFor('auth');
            $_SESSION['user-sistema-inv'] = null;
            $response = new \Slim\Psr7\Response();

            return $response->withHeader('Location', $url)->withStatus(302);
        }
       
        return $handler->handle($request);
    }
}
