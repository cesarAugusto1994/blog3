<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 18/04/17
 * Time: 08:17
 */
use Silex\Controller;
use Symfony\Component\HttpFoundation\Request;

$blog = $app['controllers_factory'];

$blog->get('/', function ($page = 1) use ($app) {
    return $app['post.controller']->posts($page, $app);
})->bind('palavra');

$blog->get('/listagem', function() use ($app) {
    return $app['twig']->render('/blog/listagem.html.twig', [
        'posts' => $app['posts.repository']->findBy([], ['cadastro' => 'DESC'])
    ]);
})->bind('listagem_posts');

$blog->get('/page/{page}', function($page, $userPage = false) use($app) {

        return $app['post.controller']->posts($page, $app);

    //return $app['index.controller']->index($page, $app);
})->bind('palavra_page');

$blog->get('/{postId}-{postTitulo}', function ($postId, $postTitulo) use ($app){
    return $app['post.controller']->post($postId, $app);
})->bind('palavra_post');

$blog->post('/criar', function (Request $request) use ($app) {
    return $app['post.controller']->criar($request, $app);
})->bind('criarPost');

$blog->get('/{id}/{name}/editar', function($id, $name) use ($app) {
    return $app['post.controller']->editarPost($id, $app);
})->bind('editar_post');

$blog->post('/salvar-edicao', function(Request $request) use ($app) {
    return $app['post.controller']->editar($request, $app);
})->bind('salvar_post')->method('PUT|POST');

$blog->get('/{id}/status', function($id) use ($app) {
    return $app['post.controller']->alterarStatus((int)$id, $app);
})->bind('set_status_post');

$blog->get('/tag/{id}/{tag}', function($id, $tag) use ($app) {
    return $app['post.controller']->postsByTags($tag, $app);
})->bind('palavra_tag');


return $blog;