<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 10/09/16
 * Time: 08:41
 */

$app->get('/user/musica/anexos/{musicaId}', function($musicaId) use ($app) {
    return $app['musica.anexos.controller']->index($musicaId, $app);
})->bind('musica_anexos');

$app->get('admin/musicas/anexos/grid/{musicaId}/{nome}', function($musicaId, $nome) use ($app){
    return $app['musica.anexos.controller']->musicasAnexosGrid($musicaId, $app);
})->bind('musica_anexos_grid');

$app->post('/user/musica/anexos/upload/{musicaId}', function($musicaId, \Symfony\Component\HttpFoundation\Request $request) use ($app) {
    return $app['musica.anexos.controller']->upload($musicaId, $request, $app);
})->bind('musica_anexos_upload');

$app->post('admin/musica/anexos/save/{musicaId}', function(\Symfony\Component\HttpFoundation\Request $request, $musicaId) use ($app) {
    if ($request->get('id')) {
        return $app['musica.anexos.controller']->editar($request, $app);
    }
    return $app['musica.anexos.controller']->novo($musicaId, $request, $app);
})->bind('save_musica_anexos');

$app->get('musica/anexos/download/{id}', function($id) use ($app) {
    return $app['musica.anexos.controller']->download($id, $app);
})->bind('musica_anexos_download');

$app->get('admin/musica/anexos/remover/{id}', function($id) use ($app) {
    return $app['musica.anexos.controller']->remover($id, $app);
})->bind('musica_anexos_remover');

$app->get('admin/musica/anexos/videos', function () use ($app) {
    return $app['musica.anexos.controller']->getByTipo(3, $app);
})->bind('videos');
