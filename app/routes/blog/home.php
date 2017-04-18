<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 18/04/17
 * Time: 08:17
 */
use Silex\Controller;

$home = $app['controllers_factory'];

$home->get('/', function ($page = 1) use ($app) {

    return $app['post.controller']->posts($page, $app);

})->bind('palavra');

$home->get('/page/{page}', function($page, $userPage = false) use($app) {
    if($userPage){
        return $app['post.controller']->posts($page, $app);
    }
    return $app['index.controller']->index($page, $app);
})->bind('palavra_page');

$home->get('/{postId}-{postTitulo}', function ($postId, $postTitulo) use ($app){
    return $app['post.controller']->post($postId, $app);
})->bind('palavra_post');

return $home;