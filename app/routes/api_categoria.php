<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 05/09/16
 * Time: 09:31
 */

use Api\Entities\Categoria;
use Symfony\Component\HttpFoundation\Request;

$categorias = $app['controllers_factory'];

$categorias->get('categoria/{categoria}', function($categoria) use ($app){
    $categoria = $app['categoria.repository']->find($categoria);
    return new \Symfony\Component\HttpFoundation\JsonResponse($categoria);
})->bind('api_categoria');

return $categorias;