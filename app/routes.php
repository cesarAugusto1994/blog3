<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 30/07/16
 * Time: 10:02
 */

$app->get('/', 'index.controller:index')->bind('home');
$app->get('/user/about', 'index.controller:about')->bind('about');
$app->get('/user/contact', 'index.controller:contact')->bind('contact');
$app->get('/user/', 'index.controller:userIndex')->bind('user_index');
$app->get('/events')->bind('events');

include __DIR__.'/routes/menu.php';
include __DIR__.'/routes/post.php';
include __DIR__.'/routes/musica.php';
$app->mount('/user', include __DIR__ . '/routes/musica_anexos.php');
$app->mount('/user', include __DIR__ . '/routes/categoria.php');
$app->mount('/user', include __DIR__ . '/routes/colecao.php');
$app->mount('/user', include __DIR__ . '/routes/user.php');
include __DIR__.'/routes/access.php';

$app->error(function (\Exception $e, \Symfony\Component\HttpFoundation\Request $request, $code) use ($app) {
    switch ($code) {
        case 400 :
            $message = 'Ocorreu um erro no m&aacute;quina local.';
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