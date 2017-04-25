<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 25/04/17
 * Time: 16:28
 */

use Api\Entities\Grupo;
use Api\Entities\Usuarios;
use Symfony\Component\HttpFoundation\Request;

$grupo = $app['controllers_factory'];

$grupo->get('/', function () use ($app) {

    $grupos = $app['grupo.repository']->findAll();
    return $app['twig']->render('grupo/index.html.twig', ['grupos' => $grupos]);

})->bind('grupo');

$grupo->get('/new', function () use ($app) {

    return $app['twig']->render('grupo/novo.html.twig', ['usuario' => $app['usuario']]);

})->bind('gl_add');


$grupo->post('/new-save', function (Request $request) use ($app) {

    $grupo = new Grupo();

    $nome = $request->request->get('grupo') . ' - ' . $request->request->get('cidade') . ' - ' . $request->request->get('estado');

    $grupo->setNome($nome);
    $grupo->setCidade($request->request->get('cidade'));
    $grupo->setUf($request->request->get('estado'));

    $app['db']->beginTransaction();
    $app['grupo.repository']->save($grupo);
    $app['db']->commit();

    /**
     * @var Usuarios $usuario
     */
    $usuario = $app['usuario'];
    $usuario->setGrupo($grupo);

    $app['db']->beginTransaction();
    $app['usuarios.repository']->save($usuario);
    $app['db']->commit();

    return $app->redirect('/user/'.$usuario->getId() .'-'. (strtolower($usuario->getNome())));

})->bind('gl_save');


return $grupo;