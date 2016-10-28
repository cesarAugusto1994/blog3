<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 10/09/16
 * Time: 08:41
 */

$musica = $app['controllers_factory']; ini_set('display_errors', E_ALL);

$musica->get('musicas/{categoria}/data', function($categoria) use ($app) {
    $categoria = $app['categoria.repository']->find($categoria);
    $musicas = $app['musica.repository']->findBy(['categoria' => $categoria], ['numero' => 'ASC', 'nome' => 'ASC']);
    return new \Symfony\Component\HttpFoundation\JsonResponse($musicas);
})->bind('api_musicas');

$musica->get('musicas/{categoriaId}/{nome}', function($categoriaId, $nome) use ($app) {

    $categoria = $app['categoria.repository']->find($categoriaId);

    return $app['twig']->render(
        '/user/musicas.html.twig',
        [
            'musicas' => $app['musica.repository']->findBy(
                ['categoria' => $categoria, 'ativo' => true],
                ['numero' => 'ASC', 'nome' => 'ASC']
            ),
            'categoria' => $categoria
        ]
    );

})->bind('view_musicas');

$musica->get('musicas/nova/{categoria}', function($categoria) use ($app){

    $categorias = $app['categoria.repository']->findBy(['ativo' => true], ['nome' => 'ASC']);
    return $app['twig']->render(
        '/user/musica_nova.html.twig',
        ['categoriaTela' => $categoria, 'categorias' => $categorias]
    );

})->bind('view_adicionar_musica');

$musica->get('musicas/{id}/{nome}/editar', function($id, $nome) use ($app){

    $musica = $app['musica.repository']->find($id);
    $categorias = $app['categoria.repository']->findBy(['ativo' => true], ['nome' => 'ASC']);
    return $app['twig']->render('/user/musica_editar.html.twig', ['musica' => $musica, 'categorias' => $categorias]);

})->bind('view_editar_musica');

$musica->get('musicas/{id}/letra/editar', function($id) use ($app){

    $musica = $app['musica.repository']->find($id);
    $categorias = $app['categoria.repository']->findBy(['ativo' => true], ['nome' => 'ASC']);
    return $app['twig']->render(
        '/user/musica_editar_letra.html.twig',
        ['musica' => $musica, 'categorias' => $categorias]
    );

})->bind('view_editar_letra_musica');

$musica->post('musicas/{id}/status', function($id) use ($app){

    /**
     * @var \Api\Entities\Musica $musica
     */
    $musica = $app['musica.repository']->find($id);
    $musica->setAtivo(!$musica->isAtivo());

    $app['db']->beginTransaction();
    $app['musica.repository']->save($musica);
    $app['db']->commit();

    return $app->json([
        'class' => 'success',
        'message' => 'O item foi '. ($musica->isAtivo() ? 'ativado' : 'inativado') . ' com sucesso'
    ]);
    
})->bind('api_musica_status');

return $musica;