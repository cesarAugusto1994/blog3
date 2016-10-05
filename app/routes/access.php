<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 22/08/16
 * Time: 09:33
 */

$app->get('/login', function(\Symfony\Component\HttpFoundation\Request $request) use ($app) {
    return $app['index.controller']->login($request, $app);
})->bind('login');

$app->before(function (Symfony\Component\HttpFoundation\Request $request) use ($app) {
    if (isset($app['security.token_storage'])) {
        $token = $app['security.token_storage']->getToken();
    } else {
        $token = $app['security']->getToken();
    }

    $app['user'] = null;
    $user = null;

    if ($token && !$app['security.trust_resolver']->isAnonymous($token)) {
        $app['user'] = $token->getUser();
        $app['session']->set('user', $app['user']);
        $app['session']->save();
        $user = $app['session']->get('user');
    }

    if(empty($user)) {
        $app->redirect('logout');
    }
});
/*
$app->get('/login', function (Symfony\Component\HttpFoundation\Request $request) use ($app) {
    $services = array_keys($app['oauth.services']);

    return $app['twig']->render('login.html.twig', array(
        'login_paths' => $app['oauth.login_paths'],
        'logout_path' => $app['url_generator']->generate('logout', array(
            '_csrf_token' => $app['oauth.csrf_token']('logout')
        )),
        'error' => $app['security.last_error']($request)
    ));
})->bind('login');

$app->get('/auth/', function(\Symfony\Component\HttpFoundation\Request $request) use($app) {
    
})->bind('auth');

$app->get('/auth/google/check', function(\Symfony\Component\HttpFoundation\Request $request) use($app) {

})->bind('check');

$app->get('/auth/google/callback', function(\Symfony\Component\HttpFoundation\Request $request) use($app) {

})->bind('check');
*/

$app->post('/admin/login_check', function(\Symfony\Component\HttpFoundation\Request $request) use($app) {
    
})->bind('login_check');

$app->get('/admin/logout', function() use($app){

})->bind('logout')->after(function () use ($app){
    $app['session']->clear();
    return $app->redirect('/login');
});

$app->get('/redirect', function() use ($app) {
    return $app->redirect('/user/');
})->bind('redirect')->before(function () use ($app) {
    if(isset($app['user'])) {
        $app['session']->set('user', $app['user']);
        $app['session']->save();
    }
});

$app->get('/admin/', function() use ($app) {
    return $app->redirect('/user/');
})->bind('admin')->before(function () use ($app) {
    if(isset($app['user'])) {
        $app['session']->set('user', $app['user']);
        $app['session']->save();
    }
});
$app->match('/register', function (\Symfony\Component\HttpFoundation\Request $request) use ($app){
    return $app['usuarios.controller']->novo($request, $app);
})->bind('register');

$app->get('confirmar_email/{uuid}', function ($uuid) use ($app) {
    return $app['email.confirmacao.controller']->confirmarEmail($uuid, $app);
})->bind('confirmar_email');