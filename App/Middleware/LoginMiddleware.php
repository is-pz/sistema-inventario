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
       
        if(!isset($_SESSION)){ //Si la sesion es null, se incia una
            session_start();
        }

        if((isset($body['username']) && isset($body['password']))){   
            if($body['username'] != '' && $body['password'] != ''){ //Valida que no sean vacios el nombre de usuario y password
            
                $user = $body['username'];
                $pass = $body['password'];

                $loginModel = new LoginModel();
                $dataUser = $loginModel->getOne($user);
                
                //TODO: devolver un un mensaje de error si no se encuentra un usuario

                if($dataUser['password'] == md5($pass)){ 

                    $_SESSION['user-sistema-inv'] = [
                        'username' => $dataUser['name'],
                        'idUser' => $dataUser['id'],
                        'rol' => $dataUser['idRol'],
                        'imageUser' => $dataUser['imageUser'],
                    ];

                    setcookie('user-sistema-inv', '1', time() + 1800, '/'); //Agrega una cookie para una sesion de media hora
                }
            }
            
        }
        return $handler->handle($request);
    }

}