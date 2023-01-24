<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
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

$app->get("/user", [UsersController::class, 'index'])->setName('users');

$app->get("/roles", [RolesController::class, 'index'])->setName('roles');

$app->get("/categories", [CategoriesController::class, 'index'])->setName('categories');

$app->get("/products", [ProductsController::class, 'index'])->setName('products');

$app->get("/sells", [SellsController::class, 'index'])->setName('sells');


$app->run();