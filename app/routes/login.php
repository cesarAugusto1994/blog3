<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 24/04/17
 * Time: 11:38
 */

$login = $app['controllers_factory'];

$login->get('/', function () use ($app) {

    $logins = $app['login.repository']->findBy([], ['id' => 'DESC'], 70);
    return $app['twig']->render('login/index.html.twig', ['logins' => $logins]);

});


return $login;