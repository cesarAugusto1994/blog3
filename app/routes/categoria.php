<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 05/09/16
 * Time: 09:31
 */

$app->get('/categorias/{colecaoId}/{nome}', function($colecaoId, $nome) use ($app){
    return $app['categoria.controller']->index($colecaoId, $app);
})->bind('categorias');

$app->get('admin/categorias_grid', function() use ($app){
    return $app['categoria.controller']->categoriasGrid($app);
})->bind('categorias_grid');

$app->get('admin/categorias/grid/{colecaoId}/{nome}', function($colecaoId, $nome) use ($app){
    return $app['categoria.controller']->getCategoriasByColecao($colecaoId, $app);
})->bind('colecao_categorias_grid');

$app->post('admin/nova_categoria', function(\Symfony\Component\HttpFoundation\Request $request) use ($app){
    return $app['categoria.controller']->novo($request, $app);
})->bind('nova_categoria');

$app->post('admin/save_categoria', function (\Symfony\Component\HttpFoundation\Request $request) use ($app) {
    
    if ($request->get('id')) {
        return $app['categoria.controller']->editar($request, $app);
    }
    
    return $app['categoria.controller']->novo($request, $app);
    
})->bind('save_categoria');