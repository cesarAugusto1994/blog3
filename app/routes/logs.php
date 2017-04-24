<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 24/04/17
 * Time: 11:38
 */

$logs = $app['controllers_factory'];

$logs->get('/', function () use ($app) {

    $logs = $app['log.repository']->findBy([], ['id' => 'DESC'], 70);
    return $app['twig']->render('log/index.html.twig', ['logs' => $logs]);

});

return $logs;