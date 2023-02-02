<?php

namespace App\Middleware;

use Slim\Routing\RouteContext;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;


use App\Models\LoginModel;

class LoginMiddleware implements MiddlewareInterface{


    public function process(Request $request, RequestHandler $handler): Response
    {

        $body = $request->getParsedBody();
        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
       
        if(!isset($_SESSION)){
            session_start();
        }
       
        if((isset($body['user']) && isset($body['password']))){   
            if($body['user'] != '' && $body['password'] != ''){
                $user = $body['user'];
                $pass = $body['password'];
    
                $model = new LoginModel();
                $dataInfo = $model->getData($user)[0];

                if($dataInfo['Pass'] == $pass){
                    
                    $_SESSION['user'] = $dataInfo['IdUsuario'];
                    $_SESSION['auth'] = true;
                    setcookie('logAuthEVCLD', '1', time () + 1800, '/admin');
                }
               
            }
            
        }
        return $handler->handle($request);
    }

}