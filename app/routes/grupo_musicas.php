<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 25/04/17
 * Time: 17:32
 */

use Api\Entities\GrupoMusicas;
use Api\Entities\Notificacao;
use Symfony\Component\HttpFoundation\Request;

$grupoMusicas = $app['controllers_factory'];;

$grupoMusicas->get('{id}-{nome}', function ($id, $nome) use ($app) {

    $grupo = $app['grupo.repository']->find($id);
    $grupoMusicas = $app['grupo.musicas.repository']->findBy(['grupo' => $id], ['musica' => "ASC"]);
    $grupoUsuarios = $app['grupo.usuarios.repository']->findBy(['grupo' => $id]);

    $usuarios = array_map(function ($grupo) {
        if ($grupo->isAdministrador()) {
            return $grupo->getUsuario()->getId();
        }
    }, $grupoUsuarios);

    $isAdm = in_array($app['usuario']->getId(), $usuarios);

    $grupoMusicas = $app['grupo.musicas.repository']->findBy(['grupo' => $grupo]);

    $musicasGrupo = array_map(function ($grupoMusica) {
        return $grupoMusica->getMusica()->getId();
    }, $grupoMusicas);

    return $app['twig']->render('/grupo/lista.html.twig',
        [
            'grupoMusicas' => $grupoMusicas,
            'grupo' => $grupo,
            'musicasGrupo' => $musicasGrupo,
            'adm' => (bool)$isAdm
        ]);
});

$grupoMusicas->post('/add-repertorio', function (Request $request) use ($app) {

    try {

        if (!$request->request->get('musica')) {
            return;
        }

        if (!$request->request->get('grupo')) {
            return;
        }

        $grupo = $app['grupo.repository']->find($request->request->get('grupo'));
        $musica = $app['musica.repository']->find($request->request->get('musica'));
        $grupoMusicas = $app['grupo.musicas.repository']->findOneBy(['grupo' => $grupo, 'musica' => $musica]);

        if ($grupoMusicas) {

            $grupoMusicas = $app['grupo.musicas.repository']->findOneBy(['grupo' => $grupo, 'musica' => $musica]);

            $app['db']->beginTransaction();
            $app['grupo.musicas.repository']->remove($grupoMusicas);
            $app['db']->commit();

            return $app->json([
                'classe' => 'acerto',
                'bln' => 'remove',
                'mensagem' => 'Musica removida do repertório do grupo.'
            ]);
        }


        $situacao = $app['grupo.musicas.situacao.repository']->find(1);

        $grupoMusica = new GrupoMusicas();
        $grupoMusica->setGrupo($grupo);
        $grupoMusica->setMusica($musica);
        $grupoMusica->setSituacao($situacao);

        $app['db']->beginTransaction();
        $app['grupo.musicas.repository']->save($grupoMusica);
        $app['db']->commit();

        $grupoUsuarios = $app['grupo.usuarios.repository']->findBy(['grupo' => $grupo]);

        $app['db']->beginTransaction();

        foreach ($grupoUsuarios as $grupoUsuario) {

            $mensagem = 'O louvor ' . $musica->getNome() . ' foi adicionado ao grupo ' . $grupo->getNome();

            $notificacao = new Notificacao();
            $notificacao->setUsuario($grupoUsuario->getUsuario());
            $notificacao->setMensagem($mensagem);
            $notificacao->setVisualizada(false);
            $notificacao->setDataHora(new DateTime('now'));

            $app['notificacao.repository']->save($notificacao);

            $config = $app['config'];

            $array = [
                'mensagem' => $mensagem,
                'site' => $config->getNome(),
                'lema' => $config->getSubtitulo(),
                'nome' => $grupoUsuario->getUsuario()->getNome()
            ];

            $body = $app['twig']->render('user/email_user.html.twig', $array);

            $assunto = "NOTIFICAÇÂO - " . $grupo->getNome();

            $email = new Email($assunto, $app['email.padrao'], $body);
            $email->send($grupoUsuario->getUsuario()->getEmail(), $app);

            $emailEnviado = new EmailEnviado();
            $emailEnviado->setUsuario($grupoUsuario->getUsuario());
            $emailEnviado->setTipo($assunto);
            $emailEnviado->setMensagem($mensagem);
            $emailEnviado->setDataHora(new DateTime('now'));

            $app['email.enviado.repository']->save($emailEnviado);
        }

        $app['db']->commit();

        return $app->json([
            'classe' => 'acerto',
            'bln' => 'add',
            'mensagem' => 'Musica adicionada a repertório do grupo.'
        ]);

    } catch (Exception $e) {

        return $app->json([
            'classe' => 'erro',
            'bln' => 'remove',
            'mensagem' => $e->getMessage()
        ]);

    }

})->bind('gl_musica_add');

$grupoMusicas->post('situacao', function (Request $request) use ($app) {

    try {

        if (!$request->request->get('grupo')) {
            throw new Exception('Grupo não Informado.');
        }
        if (!$request->request->get('musica')) {
            throw new Exception('Musica não Informada.');
        }
        if (!$request->request->get('situacao')) {
            throw new Exception('Situação não Informada.');
        }

        $grupo = $app['grupo.repository']->find($request->request->get('grupo'));
        $musica = $app['musica.repository']->find($request->request->get('musica'));
        $situacao = $app['grupo.musicas.situacao.repository']->find($request->request->get('situacao'));

        /**
         * @var GrupoMusicas $grupoMusicas
         */
        $grupoMusicas = $app['grupo.musicas.repository']->findOneBy(['grupo' => $grupo, 'musica' => $musica]);

        $grupoMusicas->setSituacao($situacao);

        $app['db']->beginTransaction();
        $app['grupo.musicas.repository']->save($grupoMusicas);
        $app['db']->commit();

        return $app->json([
            'classe' => 'sucesso',
            'mensagem' => 'Situação alterada.'
        ]);
    } catch (Exception $e) {
        return $app->json([
            'classe' => 'erro',
            'mensagem' => $e->getMessage()
        ]);
    }
});

return $grupoMusicas;