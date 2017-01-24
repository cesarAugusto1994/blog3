<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 29/10/16
 * Time: 11:18
 */

$tipos = $app['controllers_factory'];

$tipos->get('tipos/anexos', function() use ($app){
    $tipos = $app['tipo.anexo.repository']->findAll();
    return new \Symfony\Component\HttpFoundation\JsonResponse($tipos);
});

return $tipos;