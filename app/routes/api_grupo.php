<?php

$grupos = $app['controllers_factory'];


$grupos->get('{user}/groups', function ($user) use ($app) {

    $usuario = $app['usuarios.repository']->find($user);

    $grupoUsuarios = $app['grupo.usuarios.repository']->findBy(['usuario' => $usuario]);

    $grupos = array_map(function ($grupoUsuarios) {
        return $grupoUsuarios->getGrupo();
    }, $grupoUsuarios);


    return new \Symfony\Component\HttpFoundation\Response($grupos, \Symfony\Component\HttpFoundation\Response::HTTP_FOUND);
});


return $grupos;