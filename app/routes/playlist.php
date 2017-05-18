<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 04/05/17
 * Time: 16:41
 */

use Api\Entities\Playlist;
use Api\Entities\PlaylistMusicas;
use Symfony\Component\HttpFoundation\Request;

$playlist = $app['controllers_factory'];


$playlist->get('/', function () use ($app) {

    $playlists = $app['playlist.repository']->findBy(['usuario' => $app['usuario']]);

    return $app['twig']->render('/playlist/index.html.twig', ['playlists' => $playlists]);

})->bind('playlist');

$playlist->get('/{id}-{nome}', function ($id, $nome) use ($app) {

    $playlist = $app['playlist.repository']->find($id);

    $playlistMusicas = $app['playlist.musicas.repository']->findBy(['playlist' => $playlist]);

    $musicas = array_map(function ($playlistMusica) {
        return $playlistMusica->getMusica();
    }, $playlistMusicas);

    return $app['twig']->render('/playlist/lista.html.twig', ['playlist' => $playlist, 'musicas' => $musicas]);

})->bind('playlist_musicas');


$playlist->get('/add-repertorio/playlist/{id}-{nome}', function ($id, $nome, Request $request) use ($app) {

    $musicas = [];
    $musicaAnexos = [];
    $qRequest = "";

    if ($request->get('go')) {

        if ($request->get('q')) {
            $musicaAnexos = $app['musica.anexos.repository']->search($request->get('q'));
        }

        $qRequest = $request->get('q');
    }

    $playlist = $app['playlist.repository']->find($id);

    $playlistMusicas = $app['playlist.musicas.repository']->findBy(['playlist' => $playlist]);

    $musicasPlaylist = array_map(function ($grupoMusica) {
        return $grupoMusica->getMusica()->getId();
    }, $playlistMusicas);

    return $app['twig']->render(
        'playlist/lista-musicas.html.twig',
        [
            'musicas' => $musicas,
            'musica_anexos' => $musicaAnexos,
            'qRequest' => $qRequest,
            'playlist' => $playlist,
            'musicasPlaylist' => $musicasPlaylist
        ]
    );

})->bind('playlist_add_repertorio');



$playlist->get('/new', function () use ($app) {

    return $app['twig']->render('/playlist/novo.html.twig', ['usuario' => $app['usuario']]);

})->bind('playlist_create');



$playlist->post('/create-new-plalist', function (Request $request) use ($app) {

    $playlistFind = $app['playlist.repository']->findOneBy(
        [
            'nome' => $request->request->get('playlist'),
            'usuario' => $app['usuario']
        ]);

    if ($playlistFind) {
        $app['session']->getFlashBag()->add('mensagem', 'Já existe uma playlist com este nome.');
        return $app->redirect('/user/playlists/');
    }

    $usuario = $app['usuarios.repository']->find($request->request->get('usuario'));

    $playlist = new Playlist();
    $playlist->setNome($request->request->get('playlist'));
    $playlist->setUsuario($usuario);
    $playlist->setCadastro(new DateTime('now'));

    $app['db']->beginTransaction();
    $app['playlist.repository']->save($playlist);
    $app['db']->commit();

    $app['session']->getFlashBag()->add('mensagem', 'Playlist Criada.');
    return $app->redirect('/user/playlists');

})->bind('playlist_create_save');

$playlist->post('/remove/{id}', function ($id) use ($app) {

    $playlist = $app['playlist.repository']->find($id);
    $playlistMusicas = $app['playlist.musicas.repository']->findBy(['playlist' => $playlist]);

    $app['db']->beginTransaction();
    foreach ($playlistMusicas as $play) {
        $app['playlist.musicas.repository']->remove($play);
    }
    $app['playlist.repository']->remove($playlist);
    $app['db']->commit();

    return $app->json([
        'classe' => 'acerto',
        'bln' => 'remove',
        'message' => 'Playlist removida.'
    ]);

});


$playlist->post('/add-playlist', function (Request $request) use ($app) {

    try {

        if (!$request->request->get('musica')) {
            return;
        }

        if (!$request->request->get('playlist')) {
            return;
        }

        $playlist = $app['playlist.repository']->find($request->request->get('playlist'));
        $musica = $app['musica.anexos.repository']->find($request->request->get('musica'));
        $playlistMusicas = $app['playlist.musicas.repository']->findOneBy(['playlist' => $playlist, 'musica' => $musica]);

        if ($playlistMusicas) {

            $playlistMusicas = $app['playlist.musicas.repository']->findOneBy(['playlist' => $playlist, 'musica' => $musica]);

            $app['db']->beginTransaction();
            $app['playlist.musicas.repository']->remove($playlistMusicas);
            $app['db']->commit();

            return $app->json([
                'classe' => 'acerto',
                'bln' => 'remove',
                'mensagem' => 'Musica removida da playlist.'
            ]);
        }

        $playlistMusicas = new PlaylistMusicas();
        $playlistMusicas->setPlaylist($playlist);
        $playlistMusicas->setMusica($musica);
        $playlistMusicas->setCadastro(new DateTime());
        $playlistMusicas->setUsuario($app['usuario']);

        $app['db']->beginTransaction();
        $app['playlist.musicas.repository']->save($playlistMusicas);
        $app['db']->commit();

        return $app->json([
            'classe' => 'acerto',
            'bln' => 'add',
            'mensagem' => 'Musica adicionada à playlist.'
        ]);

    } catch (Exception $e) {

        return $app->json([
            'classe' => 'erro',
            'bln' => 'remove',
            'mensagem' => $e->getMessage()
        ]);

    }

})->bind('play_musica_add');

$playlist->get('{id}-{nome}/play', function ($id, $nome) use ($app) {

    $playlist = $app['playlist.repository']->find($id);

    $playlistMusicas = $app['playlist.musicas.repository']->findBy(['playlist' => $playlist]);

    $musicas = array_map(function ($playlistMusica) {
        return $playlistMusica->getMusica();
    }, $playlistMusicas);

    return $app['twig']->render('/playlist/play.html.twig', ['playlist' => $playlist, 'musicas' => $musicas]);

})->bind('playlist_play');

return $playlist;
