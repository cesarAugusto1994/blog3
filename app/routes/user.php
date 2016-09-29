<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 22/08/16
 * Time: 09:32
 */

$app->get('/user/perfil/{user}', function($user) use($app) {
    return $app['usuarios.controller']->getUser($user, $app);
})->bind('profile')->value('user', 1);