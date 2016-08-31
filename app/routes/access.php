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

$app->post('/admin/login_check', function(\Symfony\Component\HttpFoundation\Request $request) use($app) {
    
})->bind('login_check');

$app->get('/admin/logout', function() use($app){
    $app['session']->remove('user');
})->bind('logout');

$app->get('/admin/', function() use ($app) {
    if(isset($app['user'])) {
        $app['session']->set('user', $app['user']);
        $app['session']->save();
    }
    return $app->redirect('/');
})->bind('admin');
