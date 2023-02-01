<?php

namespace App\Controllers;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

//Modelos
use App\Models\ProductModel;
use App\Models\CategoryModel;

class HomeController{
    private $productModel;
    private $categoryModel;

    function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
    }


    public function index(Request $request, Response $response, $args){
        $view = Twig::fromRequest($request);
        
        $lastAddedProduct = $this->productModel->getLastAddedProducts();
        $listCategories = $this->categoryModel->getAll();

        $params = [
            'lastAddedProduct' => $lastAddedProduct,
            'categories' => $listCategories,
        ];
        return $view->render($response, "home/index.html.twig", $params);   
     }

}
