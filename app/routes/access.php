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

})->bind('logout')->after(function () use ($app){
    $app['session']->clear();
    return $app->redirect('/login');
});

$app->get('/admin/', function() use ($app) {
    return $app->redirect('/');
})->bind('admin')->before(function () use ($app) {
    if(isset($app['user'])) {
        $app['session']->set('User', $app['user']);
        $app['session']->save();
    }
});

$app->match('/register', function (\Symfony\Component\HttpFoundation\Request $request) use ($app){
    return $app['usuarios.controller']->novo($request, $app);
})->bind('register');
