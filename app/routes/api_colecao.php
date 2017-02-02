<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 26/01/17
 * Time: 11:55
 */

$colecao = $app['controllers_factory'];

$colecao->get('colecoes', function() use ($app){
    $colecoes = $app['colecao.repository']->findBy([], ['nome' => 'ASC']);
    return new \Symfony\Component\HttpFoundation\JsonResponse($colecoes);
})->bind('api_colecoes');


$colecao->get('collection/{id}-{nome}/categories', function($id, $nome) use ($app){

    $colecao = $app['colecao.repository']->find($id);

    $paremetros = [
        'colecao' => $colecao,
        'ativo' => true
    ];

    $categorias = $app['categoria.repository']->findBy($paremetros, ['nome' => 'ASC']);
    return new \Symfony\Component\HttpFoundation\JsonResponse($categorias);

})->bind('api_categorias');

return $colecao;