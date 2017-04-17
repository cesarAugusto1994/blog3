<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 10/09/16
 * Time: 08:41
 */

use Api\Entities\Categoria;

$musica = $app['controllers_factory'];

$musica->get('musicas/{id}', function($id) use ($app) {
    $musica = $app['musica.repository']->find($id);
    return new \Symfony\Component\HttpFoundation\JsonResponse($musica);
})->bind('api_musica');

$musica->get('praise-success', function() use ($app) {
    return $app['twig']->render('/user/musica-sucesso.html.twig');;
})->bind('praise_success');

$musica->get('view/{id}', function($id) use ($app) {
    $musica = $app['musica.repository']->find($id);
    return $app['twig']->render('/user/view.html.twig', ['musica' => $musica]);
})->bind('musica_view');


$musica->get('musicas/adicionadas/recentemente', function() use ($app) {

    if (!empty($app['session']->get('musicas_adicionadas'))) {
        return new \Symfony\Component\HttpFoundation\JsonResponse($app['session']->get('musicas_adicionadas'));
    }

    $musicas = $app['musica.repository']->findBy(['ativo' => true], ['cadastro' => 'DESC'], 10);
    $app['session']->set('musicas_adicionadas', $musicas);

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

    $categoria = ["id" => 0, "nome" => "categoria"];

    if ($request->get('category_id')) {
        $categoria = $app['categoria.repository']->find($request->get('category_id'));
    }

    if ($request->get('same_category')) {
        return $app['twig']->render('/user/musica-adicionar-mesma-categoria.html.twig', ['categoria' => $categoria]);
    }

    if ($request->get('various')) {
        return $app['twig']->render('/user/musica-adicionar-2.html.twig', ['categoria' => $categoria]);
    }

    return $app['twig']->render('/user/musica-adicionar.html.twig', ['categoria' => $categoria]);

});

$musica->get('musicas/adicionar/{categoria}/1', function($categoria) use ($app){

    $categorias = $app['categoria.repository']->findBy(['ativo' => true], ['nome' => 'ASC']);
    return $app['twig']->render(
        '/user/musica_nova.html.twig',
        ['categoriaTela' => $categoria, 'categorias' => $categorias]
    );

})->bind('view_adicionar_musica');

$musica->get('praises/{id}-{nome}/edit', function($id, $nome) use ($app){

    $musica = $app['musica.repository']->find($id);
    $categorias = $app['categoria.repository']->findBy(['ativo' => true], ['nome' => 'ASC']);

    $array = [];
    /**
     * @var Categoria $categoria
     */
    foreach ($categorias as $categoria) {

        $key = $categoria->getColecao()->getId();

        if (!isset($array[$key]['nome'])) {
            $array[$key]['nome'] = $categoria->getColecao()->getNome();
        }

        if ($categoria->getColecao()->getNome() == $array[$key]['nome']) {

            $array[$key]['nome'] = $categoria->getColecao()->getNome();

            $array[$key]['categorias'][] = [
                "id" => $categoria->getId(),
                "nome" => $categoria->getNome()
            ];
        }
    }

    return $app['twig']->render('/user/musica_editar.html.twig', ['musica' => $musica, 'categorias' => array_merge($array)]);

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

    $encontrarVirgula = [
        'Ab,', 'Abm,', 'A,', 'Am,', 'A#,', 'A#m,',
        'Ab7,', 'Abm7,', 'A7,', 'Am7,', 'A#7,', 'A#m7,',
        'Bb,', 'Bbm,', 'B,', 'Bm,',
        'Bb7,', 'Bbm7,', 'B7,', 'Bm7,',
        'C,', 'Cm,', 'C#,', 'C#m,',
        'C7,', 'Cm7,', 'C#7,', 'C#m7,',
        'C9,', 'Cm9,', 'C#9,', 'C#m9,',
        'Db,', 'Dbm,', 'D,', 'Dm,', 'D#,', 'D#m,',
        'Db7,', 'Dbm7,', 'D7,', 'Dm7,', 'D#7,', 'D#m7,',
        'Eb,', 'Ebm,', 'E,', 'Em,',
        'Eb7,', 'Ebm7,', 'E7,', 'Em7,',
        'F,', 'Fm,', 'F#,', 'F#m,',
        'F7,', 'Fm7,', 'F#7,', 'F#m7,',
        'Gb,', 'Gbm,', 'G,', 'Gm,', 'G#,', 'G#m,',
        'Gb7,', 'Gbm7,', 'G7,', 'Gm7,', 'G#7,', 'G#m7,'
    ];

    $removerVirgulas = [
        'Ab ', 'Abm ', 'A ', 'Am ', 'A# ', 'A#m ',
        'Ab7 ', 'Abm7 ', 'A7 ', 'Am7 ', 'A#7 ', 'A#m7 ',
        'Bb ', 'Bbm ', 'B ', 'Bm ',
        'Bb7 ', 'Bbm7 ', 'B7 ', 'Bm7 ',
        'C ', 'Cm ', 'C# ', 'C#m ',
        'C7 ', 'Cm7 ', 'C#7 ', 'C#m7 ',
        'C9 ', 'Cm9 ', 'C#9 ', 'C#m9 ',
        'Db ', 'Dbm ', 'D ', 'Dm ', 'D# ', 'D#m ',
        'Db7 ', 'Dbm7 ', 'D7 ', 'Dm7 ', 'D#7 ', 'D#m7 ',
        'Eb ', 'Ebm ', 'E ', 'Em ',
        'Eb7 ', 'Ebm7 ', 'E7 ', 'Em7 ',
        'F ', 'Fm ', 'F# ', 'F#m ',
        'F7 ', 'Fm7 ', 'F#7 ', 'F#m7 ',
        'Gb ', 'Gbm ', 'G ', 'Gm ', 'G# ', 'G#m ',
        'Gb7 ', 'Gbm7 ', 'G7 ', 'Gm7 ', 'G#7 ', 'G#m7 '
    ];

    $search = ['7M', '4', '(4)', '(sus)', '(9)', '(b9)', 'º', '(#5)', 'Introdução: ', 'Instrumentos '];
    $replace = ['maj7', 'sus', 'sus', 'sus', '9', 'b9', 'dim', '#5', "Introdução: \n", "Instrumentos \n"];

    $search = array_merge($search, $encontrarVirgula);
    $replace = array_merge($replace, $removerVirgulas);

    $letra = str_replace($search, $replace, $request->get('letra'));
    $musica->setLetra(strip_tags($letra));
    $musica->setLetraOriginal($letra);
    
    $app['db']->beginTransaction();
    $app['musica.repository']->save($musica);
    $app['db']->commit();
    
    return $app->redirect('/user/praise/'.$musica->getId().'-'.$musica->getId());
    
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

    return $app->redirect('/user/praise/'.$musica->getId().'-'.$musica->getId());

})->bind('save_musica');

return $musica;