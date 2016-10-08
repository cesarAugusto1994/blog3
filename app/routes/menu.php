<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 22/08/16
 * Time: 09:31
 */

$app->get('search', function (\Symfony\Component\HttpFoundation\Request $request) use ($app) {
    return $app['post.controller']->search($request->get('q'), $app);
})->bind('search');

$app->get('/user/pesquisar', function (\Symfony\Component\HttpFoundation\Request $request) use ($app) {
    return $app['search.controller']->search($request->get('q'), $app);
})->bind('pesquisar');

$app->get('/pesquisar', function (\Symfony\Component\HttpFoundation\Request $request) use ($app) {
    return $app['search.controller']->search($request->get('q'), $app);
})->bind('pesquisar_home');

$app->get('admin/blog', function () use ($app) {
    return $app['twig']->render('admin/blog_config.html.twig');
})->bind('blog');

$app->post('admin/blog', function (\Symfony\Component\HttpFoundation\Request $request) use ($app) {
    
    if ($request->get('id')) {
        return $app['config.controller']->editar($request, $app);
    }
    
    return $app['config.controller']->novo($request, $app);
    
})->bind('blog_settings_save');

$app->get('admin/menu', function() use ($app) {
    return $app['menu.controller']->index($app);
})->bind('menu');

$app->post('admin/menu/novo', function(\Symfony\Component\HttpFoundation\Request $request) use ($app) {
    return $app['menu.controller']->criar($request, $app);
})->bind('novo_menu');

$app->post('admin/menu/edit', function(\Symfony\Component\HttpFoundation\Request $request) use ($app) {
    return $app['menu.controller']->editar($request, $app);
})->bind('novo_menu');

$app->get('admin/edit_menu/{id}', function($id) use ($app) {
    return $app['twig']->render('admin/edit_blog_menu.html.twig', ['menu' => $app['menu.repository']->find($id)]);
})->bind('edit_menu');

$app->post('admin/menu/save', function(\Symfony\Component\HttpFoundation\Request $request) use ($app) {
    
    if($request->get('id')) {
        return $app['menu.controller']->editar($request, $app);
    }
    return $app['menu.controller']->criar($request, $app);
    
})->bind('save_menu');

$app->get('admin/menu/status/{id}', function($id) use ($app) {
    return $app['menu.controller']->alterarStatus((int)$id, $app);
})->bind('alterar_suatus_menu');