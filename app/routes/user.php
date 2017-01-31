<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 22/08/16
 * Time: 09:32
 */

$user = $app['controllers_factory'];

$user->get('/{id}/{nome}/perfil', function($id, $nome) use($app) {

    $user = $app['usuarios.repository']->find($id);

    if(!$user) {
        return $app->redirect('/admin/usuarios/list');
    }

    return $app['twig']->render('/user/perfil.html.twig', ['user' => $user]);

})->bind('perfil');

$user->get('/email/{email}', function($email) use($app) {
    $user = $app['usuarios.repository']->findBy(['email' => $email]);
    return new \Symfony\Component\HttpFoundation\JsonResponse($user);
});

$user->get('/{user}/atividades', function($user) use($app) {
    return $app['usuarios.controller']->getAtividadesUsuario($user, $app);
})->bind('usuario_atividades')->value('user', 1);

$user->post('/user/perfil/editar', function(\Symfony\Component\HttpFoundation\Request $request) use ($app) {
    return $app['usuarios.controller']->editar($request, $app);
})->bind('usuario_editar');


return $user;