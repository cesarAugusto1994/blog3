<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 22/08/16
 * Time: 09:33
 */


$api = $app['controllers_factory'];

$api->post('register/user/save', function (\Symfony\Component\HttpFoundation\Request $request) use ($app) {

    # email
    # password
    # nome

    $app['db']->beginTransaction();

    try {

        if (empty($request->request->get('nome'))) {
            throw new Exception('Não foi possivel registrar o usuario: Nome nao informado', 404);
        }

        if (empty($request->request->get('email'))) {
            throw new Exception('Não foi possivel registrar o usuario: Email nao informado', 404);
        }

        if (empty($request->request->get('password'))) {
            throw new Exception('Não foi possivel registrar o usuario: Senha nao informada', 404);
        }

        if ($app['usuarios.repository']->findBy(['email' => $request->request->get('email')])) {
            return $app->json(
                [
                    'classe' => 'Erro',
                    'bln' => false,
                    'mensagem' => 'Este e-mail já está cadastrado.'
                ]
            );
        }

        $encoder = $app['security.encoder.digest'];
        $password = $encoder->encodePassword($request->get('password'), '');
        $grupo = $app['grupo.repository']->find(1);

        $usuario = new \Api\Entities\Usuarios();
        $usuario->setNome(ucwords($request->request->get('nome')));
        $usuario->setEmail(strtolower($request->request->get('email')));
        $usuario->setSenha($request->get('password'));
        $usuario->setPassword($password);
        $usuario->setGrupo($grupo);
        $usuario->setCadastro(new \DateTime('now'));
        $usuario->setRoles(\Api\Entities\Usuarios::ROLE_USER);
        $usuario->setAtivo(true);

        $app['usuarios.repository']->save($usuario);

        $grupoUsuarios = new \Api\Entities\GrupoUsuarios();
        $grupoUsuarios->setGrupo($grupo);
        $grupoUsuarios->setAdministrador(false);
        $grupoUsuarios->setUsuario($usuario);

        $app['db']->beginTransaction();
        $app['grupo.usuarios.repository']->save($grupoUsuarios);
        $app['db']->commit();

        $uuid = $app['uuid.service'];

        $link = "https://coletaneaicm.com/email/confirmation/" . $uuid . "/auth/" . $usuario->getEmail();

        $dateTime = new DateTime('now');
        $dataLimite = new DateTime('now');
        $dataLimite->modify('+8 hours');

        $statusEmail = $app['status.email.repository']->find(1);

        $emailConfirmacao = new \Api\Entities\EmailConfirmacao();
        $emailConfirmacao->setUsuario($usuario);
        $emailConfirmacao->setToken($uuid);
        $emailConfirmacao->setGeradoEm($dateTime);
        $emailConfirmacao->setValidade($dataLimite);
        $emailConfirmacao->setStatus($statusEmail);

        $app['email.confirmacao.repository']->save($emailConfirmacao);

        $config = $app['config'];
        $assunto = "Confirmar E-mail";
        $mensagem = "Seja Bem Vindo(a) ao Coletânea ICM, você está cadastrado, agora só falta confirmar o seu e-mail.";
        $obs = "Este link é válido por 8 horas";

        $array = [
            'mensagem' => $mensagem,
            'link' => $link,
            'confirmarEmail' => 'Ou confirme pelo link abaixo:',
            'nome' => $usuario->getNome(),
            'site' => $config->getNome(),
            'lema' => $config->getSubtitulo(),
            'obs' => $obs,
        ];

        $body = $app['twig']->render('/user/email_confirmation.twig', $array);
        $email = new \Api\Services\Email($assunto, $app['email.padrao'], $body);
        $email->send($request->request->get('email'), $app);

        $emailEnviado = new \Api\Entities\EmailEnviado();
        $emailEnviado->setUsuario($usuario);
        $emailEnviado->setTipo($assunto);
        $emailEnviado->setMensagem($mensagem);
        $emailEnviado->setDataHora(new DateTime('now'));

        $app['email.enviado.repository']->save($emailEnviado);

        $usuarioN = $app['usuarios.repository']->find(1);

        $notificacao = new \Api\Entities\Notificacao();
        $notificacao->setUsuario($usuarioN);
        $notificacao->setMensagem($usuario->getNome() . ' se registrou no site.');
        $notificacao->setVisualizada(false);
        $notificacao->setDataHora(new DateTime('now'));

        $app['notificacao.repository']->save($notificacao);

        $app['db']->commit();

        return $app->json(
            [
                'classe' => 'Sucesso',
                'bln' => true,
                'mensagem' => 'Usuario Registrado com Sucesso'
            ]
        );

    } catch (Exception $e) {

        $app['db']->rollBack();

        return $app->json(
            [
                'classe' => 'Erro',
                'bln' => false,
                'mensagem' => $e->getMessage()
            ]
        );
    }
});

return $api;

