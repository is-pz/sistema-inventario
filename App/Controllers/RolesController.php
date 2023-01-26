<?php

namespace App\Controllers;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use Slim\Routing\RouteContext;


//Modelos
use App\Models\RolesModel;
use App\Models\Rol;

class RolesController{

    private $rolModel;

    function __construct()
    {
        $this->rolModel = new RolesModel();
    }
    
    public function index(Request $request, Response $response, $args){
        $view = Twig::fromRequest($request);
        
        $roles = $this->rolModel->getAll();

        $params = [
            'roles' => $roles,
        ];
        return $view->render($response, "roles/index.html.twig", $params);   
     }

      /**
     * Muestra un formulario para la creacion de un recurso
     * 
     */
    public function create(Request $request, Response $response, $args)
    {
        $view = Twig::fromRequest($request);
        $params = [];
        return $view->render($response, "roles/create.html.twig", $params);  
    }

    /**
     * Guarda los datos ingresados del formulario create
     * 
     */
    public function store(Request $request, Response $response, $args)
    {
        $body = $request->getParsedBody();

        $rol = new Rol($body['nombreRol'], $body['descripcionRol'], $body['estatus']);

        $this->rolModel->insertRol($rol);

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('roles');

        return $response->withHeader('Location', $url)->withStatus(302);
    }

    /**
     * Muestra un recurso en especifico
     *
     public function show(Request $request, Response $response, $args)
     {
         
    }
    */
    
    /**
     * Muestra un formulario para editar un recurso
     * 
     */
    public function edit(Request $request, Response $response, $args)
    {
        $view = Twig::fromRequest($request);
        
        $id = $args['id'];

        $rol = $this->rolModel->getOne($id);

        $params = [
            'rol' => $rol,
        ];
        return $view->render($response, "roles/edit.html.twig", $params);   
    }

    /**
     * Actualiza la informacion de un recurso en especifico
     * 
     */
    public function update(Request $request, Response $response, $args)
    {
        $body = $request->getParsedBody();
        $id = $args['id'];
        $rol = new Rol($body['nombreRol'], $body['descripcionRol'], $body['estatus']);

        $this->rolModel->updateRol($rol, $id);

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('roles');

        return $response->withHeader('Location', $url)->withStatus(302);
    }

    /**
     * ELimina un recurso en especifico 
     * 
     */
    public function destroy(Request $request, Response $response, $args)
    {
        $body = $request->getParsedBody();

        $id = $body['id'];
        $this->rolModel->deleteRol($id);

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('roles');

        return $response->withHeader('Location', $url)->withStatus(302);
    }
}
