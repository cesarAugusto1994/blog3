<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 22/08/16
 * Time: 09:28
 */

$app->get('user/posts', function ($page = 1) use ($app) {
    return $app['post.controller']->posts($page, $app);
})->bind('posts');

$app->post('/admin/post/new', function (\Symfony\Component\HttpFoundation\Request $request) use ($app) {
    return $app['post.controller']->criar($request, $app);
})->bind('newPost');

$app->get('user/post/{postId}/{postTitulo}', function ($postId, $postTitulo) use ($app){
    return $app['post.controller']->post($postId, $app);
})->bind('post');

$app->get('admin/posts/grid', function() use ($app) {
    return $app['twig']->render('admin/grid_posts.html.twig', [
        'posts' => $app['posts.repository']->findBy([], ['cadastro' => 'DESC'])
    ]);
})->bind('grid_posts');

$app->get('admin/post/form', function () use ($app) {
    return $app['twig']->render('admin/newpost.html.twig');
})->bind('postForm');

$app->get('admin/post/edit/{id}/{name}', function($id, $name) use ($app) {
    return $app['post.controller']->editarPost($id, $app);
})->bind('edit_post');

$app->put('admin/post/edit/save', function(\Symfony\Component\HttpFoundation\Request $request) use ($app) {
    return $app['post.controller']->editar($request, $app);
})->bind('save_edit_post')->method('PUT|POST');

$app->get('admin/post/status/{id}', function($id) use ($app) {
    return $app['post.controller']->alterarStatus((int)$id, $app);
})->bind('status_post');

$app->get('admin/tag/{id}/{tag}', function($id, $tag) use ($app) {
    return $app['post.controller']->postsByTags($tag, $app);
})->bind('tag');

$app->get('/archives/{year}', function($year) use ($app){
    return $app['post.controller']->postsByYear($year, $app);
})->bind('archives')->value('year', 2016);

$app->get('/author/{author}', function($author) use ($app){
    return $app['post.controller']->postsByAuthor($author, $app);
})->bind('author')->value('author', 1);

$app->get('/archives/{year}/{month}', function($year, $month) use ($app){
    return $app['post.controller']->postsByYearAndMonth($year, $month, $app);
})->bind('archives_by_year_month')->value('year', 2016);

$app->get('page/{page}', function($page, $userPage = false) use($app) {
    if($userPage){
        return $app['post.controller']->posts($page, $app);
    }
    return $app['index.controller']->index($page, $app);
})->bind('page');