<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 22/08/16
 * Time: 09:28
 */

$app->post('newPost', function (\Symfony\Component\HttpFoundation\Request $request) use ($app) {
    return $app['post.controller']->criar($request, $app);
})->bind('newPost');

$app->get('/post/{postId}/{postTitulo}', function ($postId, $postTitulo) use ($app){
    return $app['post.controller']->post($postId, $app);
})->bind('post');

$app->get('grid_posts/', function() use ($app) {

    return $app['twig']->render('posts_grid.html.twig', [
        'posts' => $app['posts.repository']->findBy([], ['cadastro' => 'DESC'])
    ]);

})->bind('grid_posts');

$app->get('postForm', function () use ($app) {
    return $app['twig']->render('admin/newpost.html.twig');
})->bind('postForm');

$app->get('edit_post/{id}/{name}', function($id, $name) use ($app) {
    return $app['post.controller']->editarPost($id, $app);
})->bind('edit_post');

$app->post('save_edit_post', function(\Symfony\Component\HttpFoundation\Request $request) use ($app) {
    return $app['post.controller']->editar($request, $app);
})->bind('save_edit_post');

$app->get('status_post/{id}', function($id) use ($app) {
    return $app['post.controller']->alterarStatus((int)$id, $app);
})->bind('status_post');

$app->get('tag/{id}/{tag}', function($id, $tag) use ($app) {
    return $app['post.controller']->postsByTags($tag, $app);
})->bind('tag');

$app->get('/archives/{year}', function($year) use ($app){
    return $app['post.controller']->postsByYear($year, $app);
})->bind('archives')->value('year', 2016);

$app->get('/author/{author}/{name}', function($author, $name) use ($app){
    return $app['post.controller']->postsByAuthor($author, $app);
})->bind('author')->value('name', 'Usuario');

$app->get('/archives/{year}/{month}', function($year, $month) use ($app){
    return $app['post.controller']->postsByYearAndMonth($year, $month, $app);
})->bind('archives_by_year_month')->value('year', 2016);

$app->get('page/{page}', function($page) use($app) {
    return $app['index.controller']->index($page, $app);
})->bind('page');