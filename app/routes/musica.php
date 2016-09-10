<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 10/09/16
 * Time: 08:41
 */

$app->get('musicas/{categoriaId}', function($categoriaId) use ($app) {
    return $app['musica.controller']->index($categoriaId, $app);
})->bind('musicas');

$app->get('/musicas_grid', function() use ($app){
    return $app['musica.controller']->musicasGrid($app);
})->bind('musicas_grid');

$app->post('/save_musica', function(\Symfony\Component\HttpFoundation\Request $request) use ($app) {
    
    if ($request->get('id')) {
        return $app['musica.controller']->editar($request, $app);
    }
    return $app['musica.controller']->novo($request, $app);
    
})->bind('save_musica');
