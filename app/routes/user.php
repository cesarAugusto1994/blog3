<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 22/08/16
 * Time: 09:32
 */

$app->get('/user/perfil/{user}', function($user) use($app) {
    return $app['usuarios.controller']->getUser($user, $app);
})->bind('perfil')->value('user', 1);

$app->get('/user/{user}/atividades', function($user) use($app) {
    return $app['usuarios.controller']->getAtividadesUsuario($user, $app);
})->bind('usuario_atividades')->value('user', 1);

$app->get('/admin/usuarios/list', function () use ($app) {
    return $app['usuarios.controller']->getUsuarios($app);
})->bind('usuarios');

$app->post('/user/perfil/editar', function(\Symfony\Component\HttpFoundation\Request $request) use ($app) {
    return $app['usuarios.controller']->editar($request, $app);
})->bind('usuario_editar')->method('POST');

$app->get('/admin/usuario/{id}/status', function($id) use ($app) {
    return $app['usuarios.controller']->alteraStatus($id, $app);
})->bind('usuario_status');