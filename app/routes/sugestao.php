<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 11/04/17
 * Time: 09:27
 */

use Api\Entities\Sugestao;
use Symfony\Component\HttpFoundation\Request;

$sugestao = $app['controllers_factory'];

$sugestao->get('/sugestao', function () use ($app){
    return $app['twig']->render('/user/sugestao.html.twig');
});

$sugestao->post('/sugestao/form', function (Request $request) use ($app){

    $sugestao = new Sugestao();
    $sugestao->setUsuario($app['usuario']);
    $sugestao->setMensagem($request->request->get('mensagem'));

    $app['db']->beginTransaction();
    $app['sugestao.repository']->save($sugestao);
    $app['db']->commit();

    return $app['twig']->render('/user/sugestao.html.twig', ['user' => $app['usuario'], 'mensagem' => 'Sugestão enviada ao Administrador.']);

})->bind('form_sugestao');

return $sugestao;