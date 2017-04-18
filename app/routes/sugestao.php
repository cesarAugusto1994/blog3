<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 11/04/17
 * Time: 09:27
 */

use Api\Entities\EmailEnviado;
use Api\Entities\Sugestao;
use Api\Entities\SugestaoResposta;
use Api\Entities\Usuarios;
use Api\Services\Email;
use Symfony\Component\HttpFoundation\Request;

$sugestao = $app['controllers_factory'];

$sugestao->get('/sugestao', function () use ($app){
    return $app['twig']->render('/user/sugestao.html.twig');
});

$sugestao->get('/sugestoes', function () use ($app){
    $sugestoes = $app['sugestao.repository']->findBy([], ['id' => 'DESC']);
    return $app['twig']->render('/user/sugestoes.html.twig', ['sugestoes' => $sugestoes]);
});

$sugestao->get('/sugestao/responder', function (Request $request) use ($app){
    $userID = $request->get('user');
    $sugestaoID = $request->get('sugestaoId');
    $sugestao = $app['sugestao.repository']->find($sugestaoID);
    $user = $app['usuarios.repository']->find($userID);
    return $app['twig']->render('/user/sugestoes_responder.html.twig', ['usuario' => $user, 'sugestao' => $sugestao]);
})->bind('sugestao_responder');

$sugestao->post('/sugestao/responder', function (Request $request) use ($app){

    $userID = $request->get('user');
    $mensagem = $request->get('mensagem');
    $sugestaoId = $request->get('sugestaoId');

    /**
     * @var Usuarios $usuario
     */
    $usuario = $app['usuarios.repository']->find($userID);

    $config = $app['config'];
    $assunto = "Resposta de Sugestão";
    $array = [
        'mensagem' => $mensagem,
        'nome' => $usuario->getNome(),
        'site' => $config->getNome(),
        'lema' => $config->getSubtitulo()
    ];

    $body = $app['twig']->render('/user/success.html.twig', $array);
    $email = new Email($assunto, $app['email.padrao'], $body);
    $email->send($usuario->getEmail(), $app);

    /**
     * @var Sugestao $sugestao
     */
    $sugestao = $app['sugestao.repository']->find($sugestaoId);
    $sugestao->setRespondida(true);

    $sugestaoResposta = new SugestaoResposta();
    $sugestaoResposta->setSugestao($sugestao);
    $sugestaoResposta->setUsuario($usuario);
    $sugestaoResposta->setMensagem($mensagem);
    $sugestaoResposta->setEnviadaEm(new DateTime('now'));

    $emailEnviado = new EmailEnviado();
    $emailEnviado->setUsuario($usuario);
    $emailEnviado->setTipo($assunto);
    $emailEnviado->setMensagem($mensagem);
    $emailEnviado->setDataHora(new DateTime('now'));

    $app['db']->beginTransaction();
    $app['sugestao.repository']->save($sugestao);
    $app['sugestao.resposta.repository']->save($sugestaoResposta);
    $app['email.enviado.repository']->save($emailEnviado);
    $app['db']->commit();

    return $app['twig']->render('/user/sugestoes_responder.html.twig', ['usuario' => $usuario, 'sugestao' => $sugestao, 'mensagem' => 'Mensagem Enviada.']);

})->bind('form_sugestao_responder');

$sugestao->post('/sugestao/form', function (Request $request) use ($app){

    $sugestao = new Sugestao();
    $sugestao->setUsuario($app['usuario']);
    $sugestao->setMensagem($request->request->get('mensagem'));
    $sugestao->setEnviadaEm(new DateTime('now'));
    $sugestao->setRespondida(false);

    $app['db']->beginTransaction();
    $app['sugestao.repository']->save($sugestao);
    $app['db']->commit();

    return $app['twig']->render('/user/sugestao.html.twig', ['user' => $app['usuario'], 'mensagem' => 'Sugestão enviada ao Administrador.']);

})->bind('form_sugestao');

return $sugestao;