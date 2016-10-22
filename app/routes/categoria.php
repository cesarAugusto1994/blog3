<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 05/09/16
 * Time: 09:31
 */

$categorias = $app['controllers_factory'];

$categorias->get('categorias/{colecaoId}/{nome}', function($colecaoId, $nome) use ($app) {

    $colecao = $app['colecao.repository']->find($colecaoId);
    $categorias = $app['categoria.repository']->findBy(['colecao' => $colecao, 'ativo' => true], ['nome' => 'ASC']);

    return $app['twig']->render(
        '/user/categorias.html.twig',
        ['categorias' => $categorias, 'colecao' => $colecao]
    );

})->bind('categorias');

$categorias->get('categorias/{colecaoId}', function($colecaoId) use ($app){

    $colecao = $app['colecao.repository']->find($colecaoId);
    $categorias = $app['categoria.repository']->findBy(['colecao' => $colecao], ['nome' => 'ASC']);
    return new \Symfony\Component\HttpFoundation\JsonResponse($categorias);

})->bind('api_categorias');

$categorias->get('admin/categorias/grid', function() use ($app){
    return $app['categoria.controller']->categoriasGrid($app);
})->bind('categorias_grid');

$categorias->get('admin/categorias/grid/{colecaoId}/{nome}', function($colecaoId, $nome) use ($app){
    return $app['categoria.controller']->getCategoriasByColecao($colecaoId, $app);
})->bind('colecao_categorias_grid');

$categorias->post('admin/categoria/nova', function(\Symfony\Component\HttpFoundation\Request $request) use ($app){
    return $app['categoria.controller']->novo($request, $app);
})->bind('nova_categoria');

$categorias->post('categoria/{id}/editar', function (\Symfony\Component\HttpFoundation\Request $request) use ($app) {
    
    if ($request->get('id')) {
        return $app['categoria.controller']->editar($request, $app);
    }
    
    return $app['categoria.controller']->novo($request, $app);
    
})->bind('save_categoria');

$categorias->post('categoria/{id}/status', function($id) use ($app) {
    return $app['categoria.controller']->alteraStatus($id, $app);
})->bind('categoria_status');

return $categorias;