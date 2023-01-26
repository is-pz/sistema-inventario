<?php

namespace App\Controllers;


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\Twig;


class SellsController{
    
    public function index(Request $request, Response $response, $args){
        $view = Twig::fromRequest($request);
        $params = [];
        return $view->render($response, "sells/index.html.twig", $params);   
     }

      /**
     * Muestra un formulario para la creacion de un recurso
     * 
     */
    public function create(Request $request, Response $response, $args)
    {
        
    }

    /**
     * Guarda los datos ingresados del formulario create
     * 
     */
    public function store(Request $request, Response $response, $args)
    {
        
    }

    /**
     * Muestra un recurso en especifico
     *
     */
    public function show(Request $request, Response $response, $args)
    {
        
    }

    /**
     * Muestra un formulario para editar un recurso
     * 
     */
    public function edit(Request $request, Response $response, $args)
    {
        
    }

    /**
     * Actualiza la informacion de un recurso en especifico
     * 
     */
    public function update(Request $request, Response $response, $args)
    {
        
    }

    /**
     * ELimina un recurso en especifico 
     * 
     */
    public function destroy(Request $request, Response $response, $args)
    {
        
    }
}
