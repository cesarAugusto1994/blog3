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
            "msg" => utf8_encode("Usuario nao Encontrado."),
            "acerto" => false
        ]);
    }

    if ($password != $user->getPassword()) {
        return $app->json([
            'classe' => "Erro",
            "msg" => utf8_encode("Senha Incorreta."),
            "acerto" => false
        ]);
    }

    $sessao = null;

    if ($app['session']->getId()) {
        $sessao = $app['session']->getId();
    }

    $login = new \Api\Entities\Login();
    $login->setUsuario($user);
    $login->setSessao($sessao);
    $login->setDataLogin(new DateTime('now'));

    $app['db']->beginTransaction();
    $app['login.repository']->save($login);
    $app['db']->commit();

    return new \Symfony\Component\HttpFoundation\JsonResponse([
        'classe' => "Sucesso",
        "msg" => utf8_encode("Usuario Encontrado."),
        "acerto" => true
    ]);

})->bind('api_login_user');

$api->get('user/{email}/data', function($email) use($app) {

    $user = $app['usuarios.repository']->findOneBy(['email' => $email]);

    return new \Symfony\Component\HttpFoundation\JsonResponse($user);

});

return $api;