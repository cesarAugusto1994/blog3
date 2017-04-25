<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 30/07/16
 * Time: 10:02
 */

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

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

$app->get('/user/mail', function () use ($app) {
    return $app['usuario.email.service'];
});

$app->get('/user/cache', function () {
    return new Response('Foo', 200, array(
        'Cache-Control' => 's-maxage=5',
    ));
});

$app->mount('/api', include __DIR__ . '/routes/api_categoria.php');
$app->mount('/api', include __DIR__ . '/routes/api_musica.php');
$app->mount('/api', include __DIR__ . '/routes/api_colecao.php');
$app->mount('/api', include __DIR__ . '/routes/api_menu.php');
$app->mount('/api', include __DIR__ . '/routes/api_users.php');
$app->mount('/api', include __DIR__ . '/routes/api_anexos.php');
$app->mount('/api', include __DIR__ . '/routes/api_favoritos.php');

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
$app->mount('/user/palavra/', include __DIR__ . '/routes/blog/home.php');

$app->mount('/admin', include __DIR__ . '/routes/menu.php');
$app->mount('/admin', include __DIR__ . '/routes/admin_musica.php');

include __DIR__ . '/routes/post.php';
include __DIR__ . '/routes/musica_admin.php';
include __DIR__ . '/routes/access.php';
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
});*/
