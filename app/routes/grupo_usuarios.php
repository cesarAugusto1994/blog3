<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 25/04/17
 * Time: 17:32
 */

$grupoUsuarios = $app['controllers_factory'];;

$grupoUsuarios->get('{id}-{nome}', function ($id, $nome) use ($app) {

    $grupo = $app['grupo.repository']->find($id);

    $grupoMusicas = $app['grupo.musicas.repository']->findBy(['grupo' => $id]);

    $musicas = array_map(function ($grupoMusica) {
        return $grupoMusica->getMusica();
    }, $grupoMusicas);

    return $app['twig']->render('/grupo/lista.html.twig', ['musicas' => $musicas, 'grupo' => $grupo]);
});

return $grupoUsuarios;