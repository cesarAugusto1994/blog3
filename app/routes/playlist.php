<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 04/05/17
 * Time: 16:41
 */

use Api\Entities\Playlist;
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



$playlist->get('/new', function () use ($app) {

    return $app['twig']->render('/playlist/novo.html.twig', ['usuario' => $app['usuario']]);

})->bind('playlist_create');



$playlist->post('/create-new-plalist', function (Request $request) use ($app) {

    $playlists = $app['playlist.repository']->findAll();

    $playlistFind = $app['playlist.repository']->findOneBy(['nome' => $request->request->get('playlist')]);

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


    return $app['twig']->render('/playlist/index.html.twig', ['playlists' => $playlists]);

})->bind('playlist_create_save');



return $playlist;
