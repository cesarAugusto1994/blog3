<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 25/04/17
 * Time: 17:32
 */

$grupoMusicas = $app['controllers_factory'];;

$grupoMusicas->get('{id}-{nome}', function ($id, $nome) use ($app) {

    $grupoMusicas = $app['grupo.musicas.repository']->findBy(['grupo' => $id]);

    $musicas = array_map(function ($grupoMusica) {
        return $grupoMusica->getMusica();
    }, $grupoMusicas);

    return $app['twig']->render('/grupo/lista.html.twig', ['musicas' => $musicas]);
});

return $grupoMusicas;