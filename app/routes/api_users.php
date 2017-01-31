<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 31/01/17
 * Time: 14:10
 */

$api = $app['controllers_factory'];

$api->get('perfil/{user}', function($user) use($app) {
    $user = $app['usuarios.repository']->find($user);
    return new \Symfony\Component\HttpFoundation\JsonResponse($user);
})->bind('api_user');

return $api;