<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 10/09/16
 * Time: 08:41
 */

$app->get('/user/musicas/{categoriaId}', function($categoriaId) use ($app) {
    return $app['musica.controller']->index($categoriaId, $app);
})->bind('musicas');

$app->get('admin/musicas/add', function() use ($app){
    return $app['musica.controller']->novaMusica($app);
})->bind('musicas_add');

$app->get('user/musicas/nova/{categoria}', function($categoria) use ($app){
    return $app['musica.controller']->novaMusica($categoria, $app, true);
})->bind('nova_musica');

$app->get('admin/musicas/edit/{id}', function($id) use ($app){
    return $app['musica.controller']->editarMusica($id, $app);
})->bind('musicas_edit');

$app->get('user/musicas/{id}/editar', function($id) use ($app){
    return $app['musica.controller']->editarMusica($id, $app, true);
})->bind('musicas_editar');

$app->get('user/musicas/{id}/letra/editar', function($id) use ($app){
    return $app['musica.controller']->editarMusica($id, $app, false, true);
})->bind('musicas_letra_editar');

$app->get('admin/musicas/grid', function() use ($app){
    return $app['musica.controller']->musicasGrid($app);
})->bind('musicas_grid');

$app->get('admin/musicas/grid/{categoriaId}/{nome}', function($categoriaId, $nome) use ($app){
    return $app['musica.controller']->categoriaMusicasGrid($categoriaId, $app);
})->bind('categoria_musicas_grid');

$app->post('admin/musica/save', function(\Symfony\Component\HttpFoundation\Request $request) use ($app) {
    
    if ($request->get('id')) {
        return $app['musica.controller']->editar($request, $app);
    }
    return $app['musica.controller']->novo($request, $app);
    
})->bind('save_musica');

$app->get('admin/musicas/status/{id}', function($id) use ($app){
    return $app['musica.controller']->alteraStatus($id, $app);
})->bind('musicas_status');