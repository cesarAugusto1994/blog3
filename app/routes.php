<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 30/07/16
 * Time: 10:02
 */

$app->get('/', 'index.controller:index')->bind('home');
$app->get('/about', 'index.controller:about')->bind('about');
$app->get('/contact', 'index.controller:contact')->bind('contact');
$app->get('/events')->bind('events');

include __DIR__.'/routes/post.php';
include __DIR__.'/routes/menu.php';
include __DIR__.'/routes/user.php';
include __DIR__.'/routes/access.php';

$app->error(function (\Exception $e, \Symfony\Component\HttpFoundation\Request $request, $code) use ($app) {
    /*
        if ($app['debug']) {
            return;
        }
    */
    // 404.html, or 40x.html, or 4xx.html, or error.html
    $templates = array(
        'errors/'.$code.'.html.twig',
        'errors/'.substr($code, 0, 2).'x.html.twig',
        'errors/'.substr($code, 0, 1).'xx.html.twig',
        'errors/default.html.twig',
    );

    return new \Symfony\Component\HttpFoundation\Response($app['twig']->resolveTemplate($templates)->render(['code' => $code, 'erro' => $e->getMessage()]), $code);
});