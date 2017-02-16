<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 26/01/17
 * Time: 11:55
 */

use Api\Entities\Usuarios;

$colecao = $app['controllers_factory'];

$colecao->get('colecoes', function() use ($app){

    if (!empty($app['session']->get('colecoes'))) {
        return new \Symfony\Component\HttpFoundation\JsonResponse($app['session']->get('colecoes'));
    }

    $colecoes = $app['colecao.repository']->findBy([], ['nome' => 'ASC']);
    $app['session']->set('colecoes', $colecoes);

    return new \Symfony\Component\HttpFoundation\JsonResponse($colecoes);

})->bind('api_colecoes');


$colecao->get('collection/{id}-{nome}/categories', function($id, $nome) use ($app){

    $colecao = $app['colecao.repository']->find($id);

    $paremetros['colecao'] = $colecao;

    if (Usuarios::ROLE_ADMIN != $app["usuario"]->getRoles()) {
        $paremetros['ativo'] = true;
    }

    $categorias = $app['categoria.repository']->findBy($paremetros, ['nome' => 'ASC']);
    return new \Symfony\Component\HttpFoundation\JsonResponse($categorias);

})->bind('api_categorias');

return $colecao;