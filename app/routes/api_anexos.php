<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 02/02/17
 * Time: 13:41
 */

$anexos = $app['controllers_factory'];

$anexos->get('/praise/{id}-{nome}', function($id, $nome) use ($app) {

    $musica = $app['musica.repository']->find($id);
    $anexos = $app['musica.anexos.repository']->findBy(['musica' => $musica, 'ativo' => true]);

    return new \Symfony\Component\HttpFoundation\JsonResponse($anexos);

})->bind('api_attachments_from_praise');

return $anexos;