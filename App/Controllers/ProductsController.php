<?php

namespace App\Controllers;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;
use Slim\Routing\RouteContext;

//Modelos
use App\Models\ProductModel;
use App\Models\Product;
use App\Models\CategoryModel;

class ProductsController{
    
    private $productModel;
    private $categoryModel;

    function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }

    /**
     * Muesta una lista de recursos
     *
     */
    public function index(Request $request, Response $response, $args){
        $view = Twig::fromRequest($request);
        $username = $_SESSION['user-sistema-inv']['username'];
        $userId = $_SESSION['user-sistema-inv']['idUser'];
        $products = $this->productModel->getAll();
        $categories = $this->categoryModel->getAll();
        $params = [
            'products' => $products,
            'categories' => $categories,
            'username' => $username,
            'userId' => $userId
        ];
        return $view->render($response, "products/index.html.twig", $params);   
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
        $categories = $this->categoryModel->getAll();
        $params = [
            'categories' => $categories,
            'username' => $username,
            'userId' => $userId
        ];
        return $view->render($response, "products/create.html.twig", $params);  
    }

    /**
     * Guarda los datos ingresados del formulario create
     * 
     */
    public function store(Request $request, Response $response, $args)
    {
        $body = $request->getParsedBody();

        $product = new Product($body['categoria'], $body['numeroSerie'], $body['nombreProducto'], $body['precioCosto'], $body['precioPublico'], $body['descripcionProducto'], $body['enStock'], $body['estatus']);


        $this->productModel->insertProduct($product);

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('products');

        return $response->withHeader('Location', $url)->withStatus(302);
    }

    /**
     * Muestra un recurso en especifico
     *
     */
    public function show(Request $request, Response $response, $args)
    {
        $view = Twig::fromRequest($request);
        $username = $_SESSION['user-sistema-inv']['username'];
        $userId = $_SESSION['user-sistema-inv']['idUser'];
        $id = $args['id'];
        $product = $this->productModel->getOne($id);
        $category = $this->categoryModel->getOne($product['idCategoria']);
        $params = [
            'product' => $product,
            'category' => $category,
            'username' => $username,
            'userId' => $userId
        ];
        return $view->render($response, "products/show.html.twig", $params);  
    }

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
        $product = $this->productModel->getOne($id);
        $categories = $this->categoryModel->getAll();
        $params = [
            'product' => $product,
            'categories' => $categories,
            'username' => $username,
            'userId' => $userId
        ];
        return $view->render($response, "products/edit.html.twig", $params);  
    }

    /**
     * Actualiza la informacion de un recurso en especifico
     * 
     */
    public function update(Request $request, Response $response, $args)
    {
        $body = $request->getParsedBody();

        $id =$args['id'];

        $product = new Product($body['categoria'], $body['numeroSerie'], $body['nombreProducto'], $body['precioCosto'], $body['precioPublico'], $body['descripcionProducto'], $body['enStock'], $body['estatus']);

        $this->productModel->updateProduct($product, $id);

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('products');

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
        $this->productModel->deleteProduct($id);

        $routeParser = RouteContext::fromRequest($request)->getRouteParser();
        $url = $routeParser->urlFor('products');

        return $response->withHeader('Location', $url)->withStatus(302);
    }

 
}
