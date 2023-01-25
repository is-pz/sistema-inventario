<?php

namespace App\Controllers;

use App\Models\RolesModel;
use App\Models\User;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use Slim\Routing\RouteContext;

use App\Models\UserModel;

class UsersController{
    
    private $userModel;
    private $rolModel;

    function __construct()
    {
        $this->userModel = new UserModel();
        $this->rolModel = new RolesModel();
    }

    /**
     * Muesta na lista de recursos
     *
     */
    public function index(Request $request, Response $response, $args){
        $view = Twig::fromRequest($request);
        
        $listOfUsers = $this->userModel->getAll();
        $listOfRoles = $this->rolModel->getAll();

        $params = [
            'users' => $listOfUsers,
            'roles' => $listOfRoles,
        ];
        return $view->render($response, "users/index.html.twig", $params);   
     }


    /**
     * Muestra un formulario para la creacion de un recurso
     *
     * 
     */
    public function create(Request $request, Response $response, $args)
    {
        $view = Twig::fromRequest($request);
        $listOfRoles = $this->rolModel->getAll();

        $params = [
            'roles' => $listOfRoles,
        ];
        return $view->render($response, "users/create.html.twig", $params);   
    }

    /**
     * Guarda los datos ingresados del formulario create
     * 
     */
    public function store(Request $request, Response $response, $args)
    {
        $body = $request->getParsedBody();
        $user = new User( $body['rol'], $body['username'], $body['password'], '', $body['estatus'] );

        $addNewUser = $this->userModel->insertUser($user);

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('edit_user', ['id' => $addNewUser]);

        return $response->withHeader('Location', $url)->withStatus(302);
    }

    /**
     * Muestra un recurso en especifico
     *
     */
    public function show(Request $request, Response $response, $args)
    {
        $view = Twig::fromRequest($request);
        $params = [];
        return $view->render($response, "users/show.html.twig", $params);   
    }

    /**
     * Muestra un formulario para editar un recurso
     * 
     */
    public function edit(Request $request, Response $response, $args)
    {
        $view = Twig::fromRequest($request);
        $params = [];
        return $view->render($response, "users/create.html.twig", $params);   
    }

    /**
     * Actualiza la informacion de un recurso en especifico
     * 
     */
    public function update(Request $request, Response $response, $args)
    {
        //
    }

    /**
     * ELimina un recurso en especifico 
     * 
     */
    public function destroy(Request $request, Response $response, $args)
    {
        //
    }

}
