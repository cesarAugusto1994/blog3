<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 05/09/16
 * Time: 09:31
 */

$app->get('/categorias', function() use ($app){
    return $app['categoria.controller']->index($app);
})->bind('categorias');

$app->post('nova_categoria', function(\Symfony\Component\HttpFoundation\Request $request) use ($app){
    return $app['categoria.controller']->novo($request, $app);
})->bind('nova_categoria');