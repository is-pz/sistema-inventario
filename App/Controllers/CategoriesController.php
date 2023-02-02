<?php

namespace App\Controllers;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use Slim\Routing\RouteContext;


//Modelos
use App\Models\CategoryModel;
use App\Models\Category;

class CategoriesController{
    private $categoryModel;
    
    function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }


    public function index(Request $request, Response $response, $args){
        $view = Twig::fromRequest($request);
        $categories = $this->categoryModel->getAll();

        $username = $_SESSION['user-sistema-inv']['username'];
        $userId = $_SESSION['user-sistema-inv']['idUser'];

        $params = [
            'categories' => $categories,
            'username' => $username,
            'userId' => $userId
        ];
        return $view->render($response, "categories/index.html.twig", $params);   
     }

      /**
     * Muestra un formulario para la creacion de un recurso
     * 
     */
    public function create(Request $request, Response $response, $args)
    {
        $view = Twig::fromRequest($request);
        $username = $_SESSION['user-sistema-inv']['username'];
        $userId = $_SESSION['user-sistema-inv']['idUser'];
        $params = [
            'username' => $username,
            'userId' => $userId
        ];
        return $view->render($response, "categories/create.html.twig", $params);   
    }

    /**
     * Guarda los datos ingresados del formulario create
     * 
     */
    public function store(Request $request, Response $response, $args)
    {
        $body = $request->getParsedBody();

        $category = new Category($body['nombreCategoria'], $body['descripcionCategoria'], $body['estatus']);

        $this->categoryModel->insertCategory($category);

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('categories');

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
        $username = $_SESSION['user-sistema-inv']['username'];
        $userId = $_SESSION['user-sistema-inv']['idUser'];
        $id = $args['id'];
        $category = $this->categoryModel->getOne($id);

        $params = [
            'category' => $category,
            'username' => $username,
            'userId' => $userId
        ];
        return $view->render($response, "categories/edit.html.twig", $params);   
    }

    /**
     * Actualiza la informacion de un recurso en especifico
     * 
     */
    public function update(Request $request, Response $response, $args)
    {
        $body = $request->getParsedBody();
        $id = $args['id'];
        $category = new Category($body['nombreCategoria'], $body['descripcionCategoria'], $body['estatus']);


        $this->categoryModel->updateCategory($category, $id);

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('categories');

        return $response->withHeader('Location', $url)->withStatus(302);
    }

    /**
     * ELimina un recurso en especifico 
     * 
     */
    public function destroy(Request $request, Response $response, $args)
    {
        $body = $request->getParsedBody();
        $username = $_SESSION['user-sistema-inv']['username'];
        $userId = $_SESSION['user-sistema-inv']['idUser'];
        $id = $body['id'];
        $this->categoryModel->deleteCategory($id);

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('categories');

        return $response->withHeader('Location', $url)->withStatus(302);
    }
}
