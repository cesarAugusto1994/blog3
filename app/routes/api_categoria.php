<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 05/09/16
 * Time: 09:31
 */

use Api\Entities\Categoria;
use Api\Entities\Usuarios;
use Symfony\Component\HttpFoundation\Request;

$categorias = $app['controllers_factory'];

$categorias->get('categoria/{categoria}', function($categoria) use ($app){
    $categoria = $app['categoria.repository']->find($categoria);
    return new \Symfony\Component\HttpFoundation\JsonResponse($categoria);
})->bind('api_categoria');

$categorias->post('categoria/adicionar', function (\Symfony\Component\HttpFoundation\Request $request) use ($app) {
    return $app['categoria.controller']->novo($request, $app);
});

$categorias->post('category/edit', function (\Symfony\Component\HttpFoundation\Request $request) use ($app) {
    return $app['categoria.controller']->editar($request, $app);
});

$categorias->get('category/{id}', function($id) use ($app) {

    $categoria = $app['categoria.repository']->find($id);

    $paremetros = [
        'categoria' => $categoria
    ];

    $paremetros['ativo'] = true;

    $musicas = $app['musica.repository']->findBy($paremetros, ['numero' => 'ASC', 'nome' => 'ASC']);

    $musicas = array_map(function($musica){

        /**
         * @var \Api\Entities\Musica $musica
         */

        return [
            'id' => $musica->getId(),
            'nome' => $musica->getNome(),
            'numero' => $musica->getNumero(),
            'categoria' => $musica->getCategoria()->getId(),
        ];

    }, $musicas);

    return new \Symfony\Component\HttpFoundation\JsonResponse($musicas);

})->bind('api_praises_form_category');

$categorias->post('category/{id}-{nome}/change-status', function($id, $nome) use ($app) {

    try {
        return $app['categoria.controller']->alteraStatus($id, $app);
    } catch (Exception $e) {
        return $app->json(
            [
                'class' => 'error',
                'message' => $e->getMessage()
            ]
        );
    }
})->bind('change_category_status');

return $categorias;