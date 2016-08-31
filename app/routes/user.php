<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 22/08/16
 * Time: 09:32
 */

$app->get('profile/{user}', function($user) use($app) {
    return $app['usuarios.controller']->getUser(1, $app);
})->bind('profile')->value('user', 1);