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


$api->get('login/{email}/{password}', function($email, $password) use($app) {

    $user = $app['usuarios.repository']->findOneBy(['email' => $email]);

    $encoder = $app['security.encoder.digest'];
    $password = $encoder->encodePassword($password, '');

    if (!$user) {
        return $app->json([
            'classe' => "Erro",
            "msg" => utf8_encode("Usuário não Encontrado."),
            "data" => null
        ]);
    }

    if ($password != $user->getPassword()) {
        return $app->json([
            'classe' => "Erro",
            "msg" => utf8_encode("Senha Incorreta."),
            "data" => null
        ]);
    }

    return new \Symfony\Component\HttpFoundation\JsonResponse([
        'classe' => "Sucesso",
        "msg" => utf8_encode("Usuário Encontrado."),
        "data" => $user
    ]);

})->bind('api_login_user');

return $api;