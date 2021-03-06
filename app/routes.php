<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 30/07/16
 * Time: 10:02
 */

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;

$app->get('/', function () use ($app) {

    if (!empty($app['session']->get('user'))) {
        return $app->redirect('/user/');
    }

    return $app->redirect('login');

})->bind('home');

$app->get('/user/about', 'index.controller:about')->bind('about');
$app->get('/user/contact', 'index.controller:contact')->bind('contact');

$app->get('search', function (\Symfony\Component\HttpFoundation\Request $request) use ($app) {
    return $app['post.controller']->search($request->get('q'), $app);
})->bind('search');

$app->get('usuario', function (\Symfony\Component\HttpFoundation\Request $request) use ($app) {
    return new JsonResponse($app['musica.repository']->find(3));
});

$app->get('/user/pesquisar', function (\Symfony\Component\HttpFoundation\Request $request) use ($app) {
    return $app['search.controller']->search($request->get('q'), $app);
})->bind('pesquisar');


$app->get('/user/search', function (\Symfony\Component\HttpFoundation\Request $request) use ($app) {

    $musicas = [];
    $musicaAnexos = [];
    $posts = [];

    $qRequest = "";
    $tomRequest = "";
    $categoriaRequest = "";
    $colecaoRequest = "";

    if ($request->get('go')) {

        $musicas = $app['musica.repository']->search(
            $request->get('q'),
            $request->get('categoria'),
            $request->get('colecao'),
            $request->get('tom'));

        if ($request->get('q')) {
            $musicaAnexos = $app['musica.anexos.repository']->search($request->get('q'));
            $posts = $app['posts.repository']->search($request->get('q'));
        }

        $qRequest = $request->get('q');
        $tomRequest = $request->get('tom');
        $categoriaRequest = $request->get('categoria');
        $colecaoRequest = $request->get('colecao');

    }

    $colecoes = $app['colecao.repository']->findBy(['ativo' => true]);
    $categorias = $app['categorias'];
    $tons = $app['tonalidades'];

    return $app['twig']->render(
        'user/pesquisar.html.twig',
        [
            'musicas' => $musicas,
            'musica_anexos' => $musicaAnexos,
            'posts' => $posts,
            'tons' => $tons,
            'colecoes' => $colecoes,
            'categoriasColecoes' => $categorias,
            'qRequest' => $qRequest,
            'tomRequest' => $tomRequest,
            'categoriaRequest' => $categoriaRequest,
            'colecaoRequest' => $colecaoRequest,
        ]
    );

})->bind('pesquisar_3');

$app->get('/pesquisar', function (\Symfony\Component\HttpFoundation\Request $request) use ($app) {
    return $app['search.controller']->searchPublic($request->get('q'), $app);
})->bind('pesquisar_home');

$app->get('/admin/usuarios/list', function () use ($app) {
    return $app['usuarios.controller']->getUsuarios($app);
})->bind('usuarios');

$app->get('/admin/usuario/{id}/status', function ($id) use ($app) {
    return $app['usuarios.controller']->alteraStatus($id, $app);
})->bind('usuario_status');

$app->get('public/{id}/{nome}', function ($id, $nome) use ($app) {

    $musica = $app['musica.repository']->find($id);
    $tipo = $app['tipo.anexo.repository']->find(1);
    $musicas = $app['musica.anexos.repository']->findBy(['musica' => $musica, 'tipo' => $tipo, 'ativo' => true], ['nome' => 'ASC']);
    $anexos = $app['musica.anexos.repository']->findBy(['musica' => $musica, 'ativo' => true]);

   return $app['twig']->render('index.twig', ['musica' => $musica, 'musicas' => $musicas, 'anexos' => $anexos]);

})->bind('public_praise');

$app->get('public/group/{id}-{nome}', function ($id, $nome) use ($app) {

    $grupo = $app['grupo.repository']->find($id);
    $grupoMusicas = $app['grupo.musicas.repository']->findBy(['grupo' => $id], ['musica' => "DESC"]);

    $musicas = array_map(function ($grupoMusica) {
        return $grupoMusica->getMusica();
    }, $grupoMusicas);

    $grupoMusicas = $app['grupo.musicas.repository']->findBy(['grupo' => $grupo]);

    $musicasGrupo = array_map(function ($grupoMusica) {
        return $grupoMusica->getMusica()->getId();
    }, $grupoMusicas);

    return $app['twig']->render('grupo.html.twig',
        [
            'grupoMusicas' => $grupoMusicas,
            'musicas' => $musicas,
            'grupo' => $grupo,
            'musicasGrupo' => $musicasGrupo
        ]);
});

$app->get('/public/playlist/{id}-{nome}', function ($id, $nome) use ($app) {

    $playlist = $app['playlist.repository']->find($id);

    $playlistMusicas = $app['playlist.musicas.repository']->findBy(['playlist' => $playlist]);

    $musicas = array_map(function ($playlistMusica) {
        return $playlistMusica->getMusica();
    }, $playlistMusicas);

    return $app['twig']->render('playlist.html.twig', ['playlist' => $playlist, 'musicas' => $musicas]);
});

$app->mount('/api', include __DIR__ . '/routes/api_categoria.php');
$app->mount('/api', include __DIR__ . '/routes/api_musica.php');
$app->mount('/api', include __DIR__ . '/routes/api_colecao.php');
$app->mount('/api', include __DIR__ . '/routes/api_menu.php');
$app->mount('/api', include __DIR__ . '/routes/api_users.php');
$app->mount('/api', include __DIR__ . '/routes/api_anexos.php');
$app->mount('/api', include __DIR__ . '/routes/api_favoritos.php');
$app->mount('/api', include __DIR__ . '/routes/api_access.php');
$app->mount('/api', include __DIR__ . '/routes/api_grupo.php');

$app->mount('/user', include __DIR__ . '/routes/musica.php');
$app->mount('/user', include __DIR__ . '/routes/album.php');
$app->mount('/user', include __DIR__ . '/routes/musica_anexos.php');
$app->mount('/user', include __DIR__ . '/routes/categoria.php');
$app->mount('/user', include __DIR__ . '/routes/colecao.php');
$app->mount('/user', include __DIR__ . '/routes/user.php');
$app->mount('/user', include __DIR__ . '/routes/tipos_anexos.php');
$app->mount('/user', include __DIR__ . '/routes/favoritos.php');
$app->mount('/user', include __DIR__ . '/routes/sugestao.php');

$app->mount('/user/manager/email', include __DIR__ . '/routes/email.php');
$app->mount('/user/manager/acesso', include __DIR__ . '/routes/login.php');
$app->mount('/user/manager/comentarios', include __DIR__ . '/routes/comentarios.php');
$app->mount('/user/manager/logs', include __DIR__ . '/routes/logs.php');
$app->mount('/palavra/', include __DIR__ . '/routes/blog/home.php');

$app->get('/user/palavra/add', function () use ($app) {
    return $app['twig']->render('/blog/criar.html.twig');
})->bind('form_post');

$app->mount('/user/grupos/', include __DIR__ . '/routes/grupo.php');
$app->mount('/user/grupo/', include __DIR__ . '/routes/grupo_musicas.php');

$app->mount('/user/playlists/', include __DIR__ . '/routes/playlist.php');
$app->mount('/user/downloads/', include __DIR__ . '/routes/download.php');
$app->mount('/user/notificacoes/', include __DIR__ . '/routes/notificacao.php');

$app->mount('/admin', include __DIR__ . '/routes/menu.php');
$app->mount('/admin', include __DIR__ . '/routes/admin_musica.php');

include __DIR__ . '/routes/post.php';
include __DIR__ . '/routes/musica_admin.php';
include __DIR__ . '/routes/access.php';

$app->get('/validate/{email}', function ($email) use ($app) {
    $errors = $app['validator']->validate($email, new Assert\Email());

    if (count($errors) > 0) {
        return (string) $errors;
    } else {
        return 'The email is valid';
    }
});
/*
$app->error(function (\Exception $e, \Symfony\Component\HttpFoundation\Request $request, $code) use ($app) {
    switch ($code) {
        case 400 :
            $message = 'Ocorreu um erro na m&aacute;quina local.';
            break;
        case 403 :
            $message = 'Acesso negado, Você não tem permissão para acessar esta página.';
            break;
        case 404 :
            $message = 'Página não encontrada.';
            break;
        case 500 :
            $message = 'Um erro ocorreu no servidor.';
            break;
        case 504 :
            $message = 'Erro interno no servidor.';
            break;
        default :
            $message = 'Um erro ocorreu.';
            break;
    }
    return $app['twig']->render('errors/error.html.twig', ['code' => $code, 'message' => $message, 'erro' => $e->getMessage()]);
});
*/
