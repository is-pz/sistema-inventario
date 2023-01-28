<?php

namespace App\Controllers;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use Slim\Routing\RouteContext;


//Modelos
use App\Models\SellModel;
use App\Models\Sell;
use App\Models\UserModel;
use App\Models\ProductModel;

class SellsController{
    
    private $sellsModel;
    private $usersModel;
    private $productsModel;

    function __construct()
    {
        $this->sellsModel = new SellModel();
        $this->usersModel = new UserModel();
        $this->productsModel = new ProductModel();
    }

    public function index(Request $request, Response $response, $args){
        $view = Twig::fromRequest($request);
        $sells = $this->sellsModel->getAll();
        $params = [
            'sells' => $sells,
        ];
        return $view->render($response, "sells/index.html.twig", $params);   
     }

      /**
     * Muestra un formulario para la creacion de un recurso
     * 
     */
    public function create(Request $request, Response $response, $args)
    {
        $view = Twig::fromRequest($request);
        $products = $this->productsModel->getAll();
        $params = [
            'products' => $products,
        ];
        return $view->render($response, "sells/create.html.twig", $params);   
    }

    /**
     * Guarda los datos ingresados del formulario create
     * 
     */
    public function store(Request $request, Response $response, $args)
    {
        $body = $request->getParsedBody();

        $idUsuario = 1; // se debe cambiar para obtener de la sesion de usuario

        $product = $this->productsModel->getOne($body['idProducto']);

        $sell = new Sell($body['idProducto'], $idUsuario, $product['nombreProducto'], $product['precioCosto'], $body['precioVenta'], $body['descripcionProducto']);

        $this->sellsModel->insertSell($sell);

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('sells');

        return $response->withHeader('Location', $url)->withStatus(302);
    }

    /**
     * Muestra un recurso en especifico
     *
     */
    public function show(Request $request, Response $response, $args)
    {
        $view = Twig::fromRequest($request);
        $id = $args['id'];
        $sell = $this->sellsModel->getOne($id);
        $user = $this->usersModel->getOne($sell['idUsuario']);
        $params = [
            'sell' => $sell,
            'user' => $user
        ];
        return $view->render($response, "sells/show.html.twig", $params);   
    }

    /**
     * Muestra un formulario para editar un recurso
     * 
     */
    public function edit(Request $request, Response $response, $args)
    {
        $view = Twig::fromRequest($request);
        $id = $args['id'];
        $sell = $this->sellsModel->getOne($id);
        $products = $this->productsModel->getAll();
        $params = [
            'sell' => $sell,
            'products' => $products,
        ];
        return $view->render($response, "sells/edit.html.twig", $params);   
    }

    /**
     * Actualiza la informacion de un recurso en especifico
     * 
     */
    public function update(Request $request, Response $response, $args)
    {
        $body = $request->getParsedBody();

        $idVenta = $args['id'];

        $idUsuario = 1; // se debe cambiar para obtener de la sesion de usuario

        $product = $this->productsModel->getOne($body['idProducto']);

        $sell = new Sell($body['idProducto'], $idUsuario, $product['nombreProducto'], $product['precioCosto'], $body['precioVenta'], $body['descripcionProducto']);

        $this->sellsModel->updateSell($sell, $idVenta);

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('sells');

        return $response->withHeader('Location', $url)->withStatus(302);
    }

    /**
     * ELimina un recurso en especifico 
     * 
     */
    public function destroy(Request $request, Response $response, $args)
    {
        $body = $request->getParsedBody();

        $id = $body['idSell'];
        $this->sellsModel->deleteSell($id);

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('sells');

        return $response->withHeader('Location', $url)->withStatus(302);
    }
}
