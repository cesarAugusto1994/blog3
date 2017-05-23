<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 22/05/17
 * Time: 17:24
 */

use Api\Entities\Notificacao;
use Symfony\Component\HttpFoundation\Request;

$notificacao = $app['controllers_factory'];

$notificacao->get('/', function () use ($app) {
    $notificacoes = $app['notificacao.repository']->findBy(['usuario' => $app['usuario']], ['id' => 'DESC']);
    return $app['twig']->render('/notificacao/index.html.twig', ['notificacoes' => $notificacoes, 'usuario' => $app['usuario']]);
})->bind('notificaoes_user');

$notificacao->post('/visualizada', function (Request $request) use ($app) {

    $notificacoes = $app['notificacao.repository']->findBy(['usuario' => $app['usuario'], 'visualizada' => false]);

    $app['db']->beginTransaction();

    /**
     * @var Notificacao $notificacao
     */
    foreach ($notificacoes as $notificacao) {
        $notificacao->setVisualizada(true);
        $app['notificacao.repository']->save($notificacao);
    }

    $app['db']->commit();

    $app['notificacoes'] = 0;

    return $app->json([
       'classe' => 'sucesso',
       'mensagem' => 'Marcada com visualizada.',
    ]);

});


return $notificacao;