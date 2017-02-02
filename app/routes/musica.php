<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 10/09/16
 * Time: 08:41
 */

$musica = $app['controllers_factory'];

$musica->get('musicas/{id}', function($id) use ($app) {
    $musica = $app['musica.repository']->find($id);
    return new \Symfony\Component\HttpFoundation\JsonResponse($musica);
})->bind('api_musica');

$musica->get('musicas/adicionadas/recentemente', function() use ($app) {
    $musicas = $app['musica.repository']->findBy(['ativo' => true], ['cadastro' => 'DESC'], 6);
    return new \Symfony\Component\HttpFoundation\JsonResponse($musicas);
})->bind('api_musicas_recentes');


$musica->get('musicas/{categoria}/data', function($categoria) use ($app) {
    $categoria = $app['categoria.repository']->find($categoria);

    $paremetros = [
        'categoria' => $categoria,
        'ativo' => true
    ];

    if ("ROLE_ADMIN" == $app["usuario"]->getRoles()) {
        array_pop($paremetros);
    }

    $musicas = $app['musica.repository']->findBy($paremetros, ['numero' => 'ASC', 'nome' => 'ASC']);
    return new \Symfony\Component\HttpFoundation\JsonResponse($musicas);
})->bind('api_musicas');

$musica->get('musicas/{categoriaId}/{nome}', function($categoriaId, $nome) use ($app) {

    $categoria = $app['categoria.repository']->find($categoriaId);
    $musicas = $app['musica.repository']->findBy(['categoria' => $categoria, 'ativo' => true], ['numero' => 'ASC', 'nome' => 'ASC']);

    return $app['twig']->render('/user/musicas.html.twig', ['musicas' => $musicas, 'categoria' => $categoria]);

})->bind('view_musicas');

$musica->get('musica/adicionar/{categoria}', function($categoria) use ($app){

    return $app['twig']->render('/user/musica-adicionar.html.twig', ['categoria' => $categoria]);

})->bind('view_adicionar_musica_');

$musica->get('praise/new', function(\Symfony\Component\HttpFoundation\Request $request) use ($app){

    $categoria = $app['categoria.repository']->find($request->get('category_id'));

    return $app['twig']->render('/user/musica-adicionar.html.twig', ['categoria' => $categoria]);

});

$musica->get('musicas/adicionar/{categoria}/1', function($categoria) use ($app){

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

$musica->get('musicas/{id}/letra/editar/view', function($id) use ($app){

    $musica = $app['musica.repository']->find($id);
    $categorias = $app['categoria.repository']->findBy(['ativo' => true], ['nome' => 'ASC']);
    return $app['twig']->render(
        '/user/musica_editar_letra.html.twig',
        ['musica' => $musica, 'categorias' => $categorias]
    );

})->bind('view_editar_letra_musica');

$musica->get('tonalidades', function () use ($app) {
    return new \Symfony\Component\HttpFoundation\JsonResponse($app['tonalidades']);
});

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

$app->post('musica/{id}/letra/editar', function($id, \Symfony\Component\HttpFoundation\Request $request) use ($app) {
    
    /**
     * @var \Api\Entities\Musica $musica
     */
    $musica = $app['musica.repository']->find($id);
    
    if (!$musica) {
        throw new Exception('Musica não encontrada.');
    }
    
    $musica->setLetra(strip_tags($request->get('letra')));
    $musica->setLetraOriginal($request->get('letra'));
    
    $app['db']->beginTransaction();
    $app['musica.repository']->save($musica);
    $app['db']->commit();
    
    return $app->redirect('/user/musica/'.$musica->getId().'/anexos');
    
})->bind('api_musica_letra_editar');

$musica->post('musica/editar', function(\Symfony\Component\HttpFoundation\Request $request) use ($app) {

    /**
     * @var \Api\Entities\Musica $musica
     */
    $musica = $app['musica.repository']->find($request->get('id'));

    if ($request->get('nome')) {
        $musica->setNome($request->get('nome'));
    }

    $musica->setNumero($request->get('numero') ?: null);

    if ($request->get('tonalidade')) {
        $musica->setTom($request->get('tonalidade'));
    }

    if ($request->get('letra')) {
        $musica->setLetra(strip_tags($request->get('letra')));
        $musica->setLetraOriginal($request->get('letra'));
    }

    if ($request->get('categoria')) {
        /**
         * @var \Api\Entities\Categoria $categoria
         */
        $categoria = $app['categoria.repository']->find($request->get('categoria'));
        $musica->setCategoria($categoria);
    }

    $app['db']->beginTransaction();
    $app['musica.repository']->save($musica);
    $app['db']->commit();

    return $app->json([
        "classe" => "success",
        "data" => "Musica editada com sucesso",
    ]);

})->bind('save_musica');

return $musica;