<?php

use Slim\Factory\AppFactory;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use Slim\Routing\RouteCollectorProxy;


use App\Controllers\HomeController;
use App\Controllers\UsersController;
use App\Controllers\RolesController;
use App\Controllers\CategoriesController;
use App\Controllers\ProductsController;
use App\Controllers\SellsController;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$twig = Twig::create('../src/views', ['cache' => false]);

$app->add(TwigMiddleware::create($app, $twig));

$app->get("/", [HomeController::class, 'index'])->setName('home');


$app->group('/user', function (RouteCollectorProxy $group) {
    $group->get("", [UsersController::class, 'index'])->setName('users');

    $group->get("/create", [UsersController::class, 'create'])->setName('create_user'); //create

    $group->get("/{id}", [UsersController::class, 'show'])->setName('show_user'); //show

    $group->get("/edit/{id}", [UsersController::class, 'edit'])->setName('edit_user'); //edit
    
    $group->post("/store", [UsersController::class, 'store'])->setName('store_user'); //store

    $group->post("/update/{id}", [UsersController::class, 'update'])->setName('update_user'); //update

    $group->post("/delete", [UsersController::class, 'destroy'])->setName('delete_user'); //destroy
});


$app->group('/roles', function (RouteCollectorProxy $group) {
    $group->get("", [RolesController::class, 'index'])->setName('roles');

    $group->get("/create", [RolesController::class, 'create'])->setName('create_rol'); //create

    $group->get("/edit/{id}", [RolesController::class, 'edit'])->setName('edit_rol'); //edit
    
    $group->post("/store", [RolesController::class, 'store'])->setName('store_rol'); //store

    $group->post("/update/{id}", [RolesController::class, 'update'])->setName('update_rol'); //update

    $group->post("/delete", [RolesController::class, 'destroy'])->setName('delete_rol'); //destroy
});

$app->group('/categories', function (RouteCollectorProxy $group) {
    $group->get("", [CategoriesController::class, 'index'])->setName('categories');

    $group->get("/create", [CategoriesController::class, 'create'])->setName('create_category'); //create

    $group->get("/edit/{id}", [CategoriesController::class, 'edit'])->setName('edit_category'); //edit
    
    $group->post("/store", [CategoriesController::class, 'store'])->setName('store_category'); //store

    $group->post("/update/{id}", [CategoriesController::class, 'update'])->setName('update_category'); //update

    $group->post("/delete", [CategoriesController::class, 'destroy'])->setName('delete_category'); //destroy
});

$app->group('/products', function (RouteCollectorProxy $group) {
    $group->get("", [ProductsController::class, 'index'])->setName('products');

    $group->get("/create", [ProductsController::class, 'create'])->setName('create_product'); //create

    $group->get("/{id}", [ProductsController::class, 'show'])->setName('show_product'); //show

    $group->get("/edit/{id}", [ProductsController::class, 'edit'])->setName('edit_product'); //edit
    
    $group->post("/store", [ProductsController::class, 'store'])->setName('store_product'); //store

    $group->post("/update/{id}", [ProductsController::class, 'update'])->setName('update_product'); //update

    $group->post("/delete", [ProductsController::class, 'destroy'])->setName('delete_product'); //destroy
});

$app->get("/sells", [SellsController::class, 'index'])->setName('sells');


$app->run();