<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 10/09/16
 * Time: 08:41
 */

$app->get('musica/anexos/{musicaId}', function($musicaId) use ($app) {
    return $app['musica.anexos.controller']->index($musicaId, $app);
})->bind('musica_anexos');

$app->get('/musicas_grid', function() use ($app){
    return $app['musica.controller']->musicasGrid($app);
})->bind('musica_anexos_grid');

$app->post('/save_musica', function(\Symfony\Component\HttpFoundation\Request $request) use ($app) {
    
    if ($request->get('id')) {
        return $app['musica.controller']->editar($request, $app);
    }
    return $app['musica.controller']->novo($request, $app);
    
})->bind('save_musica_anexos');
