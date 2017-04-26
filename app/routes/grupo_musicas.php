<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 25/04/17
 * Time: 17:32
 */

use Api\Entities\GrupoMusicas;
use Symfony\Component\HttpFoundation\Request;

$grupoMusicas = $app['controllers_factory'];;

$grupoMusicas->get('{id}-{nome}', function ($id, $nome) use ($app) {

    $grupo = $app['grupo.repository']->find($id);
    $grupoMusicas = $app['grupo.musicas.repository']->findBy(['grupo' => $id]);

    $musicas = array_map(function ($grupoMusica) {
        return $grupoMusica->getMusica();
    }, $grupoMusicas);

    return $app['twig']->render('/grupo/lista.html.twig', ['musicas' => $musicas, 'grupo' => $grupo]);
});

$grupoMusicas->post('/add-repertorio', function (Request $request) use ($app) {

    try {

        if (!$request->request->get('musica')) {
            return;
        }

        if (!$request->request->get('grupo')) {
            return;
        }

        $grupo = $app['grupo.repository']->find($request->request->get('grupo'));
        $musica = $app['musica.repository']->find($request->request->get('musica'));
        $grupoMusicas = $app['grupo.musicas.repository']->findOneBy(['grupo' => $grupo, 'musica' => $musica]);

        if ($grupoMusicas) {

            $grupoMusicas = $app['grupo.musicas.repository']->findOneBy(['grupo' => $grupo, 'musica' => $musica]);

            $app['db']->beginTransaction();
            $app['grupo.musicas.repository']->remove($grupoMusicas);
            $app['db']->commit();

            return $app->json([
                'classe' => 'acerto',
                'bln' => 'remove',
                'mensagem' => 'Musica removida do repertório do grupo.'
            ]);
        }

        $grupoMusica = new GrupoMusicas();
        $grupoMusica->setGrupo($grupo);
        $grupoMusica->setMusica($musica);


        $app['db']->beginTransaction();
        $app['grupo.musicas.repository']->save($grupoMusica);
        $app['db']->commit();

        return $app->json([
            'classe' => 'acerto',
            'bln' => 'add',
            'mensagem' => 'Musica adicionada a repertório do grupo.'
        ]);

    } catch (Exception $e) {

        return $app->json([
            'classe' => 'erro',
            'bln' => 'remove',
            'mensagem' => $e->getMessage()
        ]);

    }

})->bind('gl_musica_add');

return $grupoMusicas;