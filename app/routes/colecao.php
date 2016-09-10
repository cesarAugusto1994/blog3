<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 05/09/16
 * Time: 09:31
 */

$app->get('/colecoes', function() use ($app){
    return $app['colecao.controller']->index($app);
})->bind('colecoes');

$app->get('/colecoes_grid', function() use ($app){
    return $app['colecao.controller']->colecoesGrid($app);
})->bind('colecoes_grid');

$app->post('save_colecao', function (\Symfony\Component\HttpFoundation\Request $request) use ($app) {
    
    if ($request->get('id')) {
        return $app['colecao.controller']->editar($request, $app);
    }
    
    return $app['colecao.controller']->novo($request, $app);
    
})->bind('save_colecao');