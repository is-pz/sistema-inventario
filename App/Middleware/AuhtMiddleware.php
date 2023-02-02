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
        
        if(isset($_COOKIE['authSistemaInventario'])){
            if($_COOKIE['authSistemaInventario']){
                return $handler->handle($request);
            }
        }

        if(!isset($_SESSION['auth'])){
            $routeParser = RouteContext::fromRequest($request)->getRouteParser();
            $url = $routeParser->urlFor('auth');
            $_SESSION['auth'] = false;
            $response = new \Slim\Psr7\Response();

            return $response->withHeader('Location', $url)->withStatus(302);
        }
       
        return $handler->handle($request);
    }
}
