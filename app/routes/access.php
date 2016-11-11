<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 22/08/16
 * Time: 09:33
 */

$app->get(
    '/login',
    function (\Symfony\Component\HttpFoundation\Request $request) use ($app) {
        
        return $app['twig']->render(
            'login-new.html.twig',
            array(
                'error' => $app['security.last_error']($request),
                'last_username' => $app['session']->get('_security.last_username'),
            )
        );
        
    }
)->bind('login');

$app->get('/user/', function () use ($app) {
    return $app['twig']->render('/user/index.html.twig');
})->bind('user');

$app->post(
    '/admin/login_check',
    function (\Symfony\Component\HttpFoundation\Request $request) use ($app) {
        
    }
)->bind('login_check');

$app->get(
    '/admin/logout',
    function () use ($app) {
        
    }
)->bind('logout')->after(
    function () use ($app) {
        $app['session']->clear();
        return $app->redirect('/login');
    }
);

$app->get(
    '/redirect',
    function () use ($app) {
        return $app->redirect('/user/');
    }
)->bind('redirect')->before(
    function () use ($app) {
        if (isset($app['user'])) {
            $app['session']->set('user', $app['user']);
            $app['session']->save();
        }
    }
);

$app->get(
    '/admin/',
    function () use ($app) {
        return $app->redirect('/user/');
    }
)->bind('admin')->before(
    function () use ($app) {
        if (isset($app['user'])) {
            $app['session']->set('user', $app['user']);
            $app['session']->save();
        }
    }
);

$app->get(
    'register',
    function () use ($app) {
        return $app['twig']->render('register.html.twig');
    }
)->bind('register');

$app->match(
    'register/save',
    function (\Symfony\Component\HttpFoundation\Request $request) use ($app) {
        
        if($app['usuarios.repository']->findBy(['email' => $request->request->get('email')])) {
            return $app->json(
                ['class' => 'error', 'message' => 'Este e-mail já está cadastrado.']
            );
        }
        
        $encoder = $app['security.encoder.digest'];
        $password = $encoder->encodePassword($request->get('password'), '');
        
        $usuario = new \Api\Entities\Usuarios();
        $usuario->setNome($request->request->get('nome'));
        $usuario->setEmail($request->request->get('email'));
        $usuario->setPassword($password);
        $usuario->setAvatar('avatar.png');
        $usuario->setCadastro(new \DateTime('now'));
        $usuario->setRoles('ROLE_USER');
        $usuario->setAtivo(true);

        $app['db']->beginTransaction();
        $app['usuarios.repository']->save($usuario);
        $app['db']->commit();

        return $app->json(
            [
                'class' => 'success',
                'user' => ['username' => $usuario->getEmail(), 'password' => $usuario->getPassword()],
                'message' => 'Usuario Registrado'
            ]
        );
    }
);
