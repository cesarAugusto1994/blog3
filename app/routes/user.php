<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 22/08/16
 * Time: 09:32
 */

use Api\Entities\Usuarios;

$user = $app['controllers_factory'];

$user->get('/{id}-{nome}/favorites', function($id, $nome) use ($app) {

    $usuario = $app['usuarios.repository']->find($id);
    $favorito = $app['favoritos.repository']->findBy(['usuario' => $usuario]);

    return $app['twig']->render('/user/favoritos_user.html.twig', ['favoritos' => $favorito]);

})->bind('user_favorites_2');

$user->get('/{id}-{nome}', function($id, $nome) use($app) {

    $userSession = $app['session']->get('user');
    $userS = $app['usuarios.repository']->find($userSession->getId());

    if ('ROLE_ADMIN' != $userS->getRoles()) {
        if ($userSession->getId() != $id) {
            return $app->redirect('/user/' . $userSession->getId() . '-' . $nome);
        }
    }

    /**
     * @var Usuarios $user
     */
    $user = $app['usuarios.repository']->find($id);

    if(!$user) {
        return $app->redirect('/admin/usuarios/list');
    }

    $grupo = $app['grupo.repository']->findAll();

    return $app['twig']->render('/user/perfil.html.twig', ['user' => $user, 'cidades' => $app['cidades'], 'grupos' => $grupo]);

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