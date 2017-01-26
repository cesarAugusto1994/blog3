<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 26/01/17
 * Time: 09:50
 */

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RequestContext;

$musica = $app['controllers_factory'];

/**
 *
 */
$musica->post('/musica/adicionar', function (\Symfony\Component\HttpFoundation\Request $request) use ($app) {

    try {

        return $app['musica.controller']->newAction($request);

    } catch (Exception $e) {

        return new JsonResponse([
            "classe" => "error",
            "message" => $e->getMessage(),
        ], 400);
    }
});

return $musica;