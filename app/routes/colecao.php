<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 05/09/16
 * Time: 09:31
 */

$colecao = $app['controllers_factory'];

$colecao->get('colecoes', function() use ($app){
    return $app['colecao.controller']->index($app);
})->bind('colecoes');

$colecao->get('colecoes/all', function() use ($app){
    $colecoes = $app['colecao.repository']->findBy([], ['nome' => 'ASC']);
    return new \Symfony\Component\HttpFoundation\JsonResponse($colecoes);
})->bind('api_colecoes');

$colecao->get('/admin/colecoes/grid', function() use ($app){
    return $app['colecao.controller']->colecoesGrid($app);
})->bind('colecoes_grid');

$colecao->post('/admin/colecao/save', function (\Symfony\Component\HttpFoundation\Request $request) use ($app) {
    
    if ($request->get('id')) {
        return $app['colecao.controller']->editar($request, $app);
    }
    
    return $app['colecao.controller']->novo($request, $app);
    
})->bind('save_colecao');

    $colecao->patch('colecao/{id}', function($id) use ($app) {
    return $app['colecao.controller']->alteraStatus($id, $app);
})->bind('colecao_status');

return $colecao;