<?php

use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Slim\Routing\RouteCollectorProxy;

//Controladores
use App\Controllers\HomeController;
use App\Controllers\UsersController;
use App\Controllers\CategoriesController;
use App\Controllers\ProductsController;
use App\Controllers\SellsController;
use App\Controllers\LoginController;

//Middlewares
use App\Middleware\AuhtMiddleware;
use App\Middleware\LoginMiddleware;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$twig = Twig::create('../src/views', ['cache' => false]);

$app->add(TwigMiddleware::create($app, $twig));

$app->get("/", [HomeController::class, 'index'])->setName('home')->addMiddleware(new AuhtMiddleware());


$app->group('/user', function (RouteCollectorProxy $group) {
    $group->get("", [UsersController::class, 'index'])->setName('users');

    $group->get("/create", [UsersController::class, 'create'])->setName('create_user'); //create

    $group->get("/{id}", [UsersController::class, 'show'])->setName('show_user'); //show

    $group->get("/edit/{id}", [UsersController::class, 'edit'])->setName('edit_user'); //edit
    
    $group->post("/store", [UsersController::class, 'store'])->setName('store_user'); //store

    $group->post("/update/{id}", [UsersController::class, 'update'])->setName('update_user'); //update

    $group->post("/delete", [UsersController::class, 'destroy'])->setName('delete_user'); //destroy
})->addMiddleware(new AuhtMiddleware());

$app->group('/categories', function (RouteCollectorProxy $group) {
    $group->get("", [CategoriesController::class, 'index'])->setName('categories');

    $group->get("/create", [CategoriesController::class, 'create'])->setName('create_category'); //create

    $group->get("/edit/{id}", [CategoriesController::class, 'edit'])->setName('edit_category'); //edit
    
    $group->post("/store", [CategoriesController::class, 'store'])->setName('store_category'); //store

    $group->post("/update/{id}", [CategoriesController::class, 'update'])->setName('update_category'); //update

    $group->post("/delete", [CategoriesController::class, 'destroy'])->setName('delete_category'); //destroy
})->addMiddleware(new AuhtMiddleware());

$app->group('/products', function (RouteCollectorProxy $group) {
    $group->get("", [ProductsController::class, 'index'])->setName('products');

    $group->get("/create", [ProductsController::class, 'create'])->setName('create_product'); //create

    $group->get("/{id}", [ProductsController::class, 'show'])->setName('show_product'); //show

    $group->get("/edit/{id}", [ProductsController::class, 'edit'])->setName('edit_product'); //edit
    
    $group->post("/store", [ProductsController::class, 'store'])->setName('store_product'); //store

    $group->post("/update/{id}", [ProductsController::class, 'update'])->setName('update_product'); //update

    $group->post("/delete", [ProductsController::class, 'destroy'])->setName('delete_product'); //destroy
})->addMiddleware(new AuhtMiddleware());

$app->group('/sells', function (RouteCollectorProxy $group) {
    $group->get("", [SellsController::class, 'index'])->setName('sells');

    $group->get("/create", [SellsController::class, 'create'])->setName('create_sell'); //create

    $group->get("/{id}", [SellsController::class, 'show'])->setName('show_sell'); //show

    $group->get("/edit/{id}", [SellsController::class, 'edit'])->setName('edit_sell'); //edit
    
    $group->post("/store", [SellsController::class, 'store'])->setName('store_sell'); //store

    $group->post("/update/{id}", [SellsController::class, 'update'])->setName('update_sell'); //update

    $group->post("/delete", [SellsController::class, 'destroy'])->setName('delete_sell'); //destroy
})->addMiddleware(new AuhtMiddleware());

//Grupo para login
$app->group('/auth', function(RouteCollectorProxy $group){
    $group->get('/', [LoginController::class, 'index'])->setName('auth');

    $group->post('/login', [LoginController::class, 'login'])->setName('login');

    $group->get('/logout', [LoginController::class, 'logout'])->setName('logout');

})->addMiddleware(new LoginMiddleware());

$app->run();