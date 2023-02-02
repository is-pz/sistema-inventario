<?php

namespace App\Controllers;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;

//Modelos
use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\SellModel;

class HomeController{
    private $productModel;
    private $categoryModel;
    private $sellModel;

    function __construct()
    {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->sellModel = new SellModel();
    }


    public function index(Request $request, Response $response, $args){
        $view = Twig::fromRequest($request);
        
        $lastAddedProduct = $this->productModel->getLastAddedProducts();
        $listCategories = $this->categoryModel->getAll();
        $bestSellers = $this->sellModel->getBestSellers();
        $lastSold = $this->sellModel->getLastSold();
 
        $username = $_SESSION['user-sistema-inv']['username'];
        $userId = $_SESSION['user-sistema-inv']['idUser'];

        $params = [
            'lastAddedProduct' => $lastAddedProduct,
            'categories' => $listCategories,
            'bestsellers'=> $bestSellers,
            'lastSold' => $lastSold,
            'username' => $username,
            'userId' => $userId
        ];
        return $view->render($response, "home/index.html.twig", $params);   
     }

}
