<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 30/07/16
 * Time: 10:02
 */

use Symfony\Component\HttpFoundation\JsonResponse;

$app->get('/', 'index.controller:index')->bind('home');
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

$app->get('/pesquisar', function (\Symfony\Component\HttpFoundation\Request $request) use ($app) {
    return $app['search.controller']->searchPublic($request->get('q'), $app);
})->bind('pesquisar_home');

$app->get('/admin/usuarios/list', function () use ($app) {
    return $app['usuarios.controller']->getUsuarios($app);
})->bind('usuarios');

$app->get('/admin/usuario/{id}/status', function($id) use ($app) {
    return $app['usuarios.controller']->alteraStatus($id, $app);
})->bind('usuario_status');

$app->get('/user/mail', function() use ($app) {
    return $app['usuario.email.service'];
});

$app->mount('/api', include __DIR__ . '/routes/api_categoria.php');
$app->mount('/api', include __DIR__ . '/routes/api_musica.php');
$app->mount('/api', include __DIR__ . '/routes/api_colecao.php');
$app->mount('/api', include __DIR__ . '/routes/api_menu.php');
$app->mount('/api', include __DIR__ . '/routes/api_users.php');
$app->mount('/api', include __DIR__ . '/routes/api_anexos.php');

$app->mount('/user', include __DIR__ . '/routes/musica.php');
$app->mount('/user', include __DIR__ . '/routes/album.php');
$app->mount('/user', include __DIR__ . '/routes/musica_anexos.php');
$app->mount('/user', include __DIR__ . '/routes/categoria.php');
$app->mount('/user', include __DIR__ . '/routes/colecao.php');
$app->mount('/user', include __DIR__ . '/routes/user.php');
$app->mount('/user', include __DIR__ . '/routes/tipos_anexos.php');

$app->mount('/admin', include __DIR__ . '/routes/menu.php');

include __DIR__.'/routes/post.php';
include __DIR__.'/routes/musica_admin.php';
include __DIR__.'/routes/access.php';

$app->error(function (\Exception $e, \Symfony\Component\HttpFoundation\Request $request, $code) use ($app) {
    switch ($code) {
        case 400 :
            $message = 'Ocorreu um erro no m&aacute;quina local.';
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
