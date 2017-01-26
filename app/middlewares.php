<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 05/09/16
 * Time: 10:53
 */

use Symfony\Component\HttpFoundation\Request;

$app->before(function (\Symfony\Component\HttpFoundation\Request $request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);

        if (empty($data)) {
            throw new \Exception(json_last_error_msg());
        }

        $request->request->replace(is_array($data) ? $data : []);
    }
});

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