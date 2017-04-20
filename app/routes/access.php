<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 22/08/16
 * Time: 09:33
 */

use Api\Entities\EmailConfirmacao;
use Api\Entities\EmailEnviado;
use Api\Entities\Login;
use Api\Entities\Usuarios;
use Api\Services\Email;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

$app->get('/login', function (\Symfony\Component\HttpFoundation\Request $request) use ($app) {
    return $app['twig']->render('login-new.html.twig',
        array(
            'error' => $app['security.last_error']($request),
            'last_username' => $app['session']->get('_security.last_username'),
        )
    );
})->bind('login');

$app->get('/user/', function () use ($app) {
    return $app['twig']->render('/user/index.html.twig');
})->bind('user');

$app->post('/admin/login_check', function (\Symfony\Component\HttpFoundation\Request $request) use ($app) {

})->bind('login_check')->after(function () use ($app) {

    if ($app['security.token_storage']->getToken()) {

        $sessao = null;

        if ($app['session']->getId()) {
            $sessao = $app['session']->getId();
        }

        $token = $app['security.token_storage']->getToken();

        if ($token->getUser()) {
            $usuario = $app['usuarios.repository']->find($token->getUser()->getId());
            $login = new Login();
            $login->setUsuario($usuario);
            $login->setSessao($sessao);
            $login->setDataLogin(new DateTime('now'));

            $app['db']->beginTransaction();
            $app['login.repository']->save($login);
            $app['db']->commit();

            $app['session']->set('sessao', $sessao);
        }
    }

});

$app->get('/admin/logout', function () use ($app) {

})->bind('logout')->after(function () use ($app) {
    $app['session']->clear();
    return $app->redirect('/login');
});

$app->get('/redirect', function () use ($app) {
    return $app->redirect('/user/');
})->bind('redirect')->before(function () use ($app) {
    if (isset($app['user'])) {
        $app['session']->set('user', $app['user']);
        $app['session']->save();
    }
});

$app->get('/admin/', function () use ($app) {
    return $app->redirect('/user/');
})->bind('admin')->before(
    function () use ($app) {
        if (isset($app['user'])) {
            $app['session']->set('user', $app['user']);
            $app['session']->save();
        }
    }
);

$app->get('register', function () use ($app) {
    return $app['twig']->render('register.html.twig');
})->bind('register');

$app->get('i-forgot-my-password', function () use ($app) {
    return $app['twig']->render('password.html.twig');
})->bind('password');

$app->get('/user/email-send-all', function () use ($app) {

    $assunto = 'Lembrete';

    $config = $app['config'];
    $mensagem = "Estamos precisando de sua ajuda para divulgar este projeto, nos ajude a divulgar nas redes socias <a
                href='https://coletaneaicm.com'>Coletânea ICM</a>;
        Obrigado :).";

    /**
     * @var Usuarios $usuario
     */
    $usuarios = $app['usuarios.repository']->findBy([], [], 200, 30);

    foreach ($usuarios as $usuario) {

        $array = [
            'mensagem' => $mensagem,
            'site' => $config->getNome(),
            'lema' => $config->getSubtitulo(),
            'nome' => $usuario->getNome()
        ];

        $body = $app['twig']->render('user/email_user.html.twig', $array);

        $email = new Email($assunto, $app['email.padrao'], $body);
        $email->send($usuario->getEmail(), $app);

        $emailEnviado = new EmailEnviado();
        $emailEnviado->setUsuario($usuario);
        $emailEnviado->setTipo($assunto);
        $emailEnviado->setMensagem($mensagem);
        $emailEnviado->setDataHora(new DateTime('now'));

        $app['db']->beginTransaction();
        $app['email.enviado.repository']->save($emailEnviado);
        $app['db']->commit();

    }

    return $app->json([
        "classe" => "sucesso",
        "mensagem" => "E-mail enviado.",
    ], 201);
});

$app->get('/user/email-send', function (\Symfony\Component\HttpFoundation\Request $request) use ($app) {

    $assunto = 'Lembrete';

    $config = $app['config'];
    $mensagem = "Estamos precisando de sua ajuda para divulgar este projeto, nos ajude a divulgar nas redes socias <a
                href='https://coletaneaicm.com'>Coletânea ICM</a>;
        Obrigado :).";

    /**
     * @var Usuarios $usuario
     */
    $usuario = $app['usuarios.repository']->find($request->get('id'));

    $array = [
        'mensagem' => $mensagem,
        'site' => $config->getNome(),
        'lema' => $config->getSubtitulo(),
        'nome' => $usuario->getNome()
    ];

    $body = $app['twig']->render('user/email_user.html.twig', $array);

    $email = new Email($assunto, $app['email.padrao'], $body);
    $email->send($usuario->getEmail(), $app);

    $emailEnviado = new EmailEnviado();
    $emailEnviado->setUsuario($usuario);
    $emailEnviado->setTipo($assunto);
    $emailEnviado->setMensagem($mensagem);
    $emailEnviado->setDataHora(new DateTime('now'));

    $app['db']->beginTransaction();
    $app['email.enviado.repository']->save($emailEnviado);
    $app['db']->commit();

    return $app->json([
        "classe" => "sucesso",
        "message" => "E-mail enviado.",
    ], 201);
});

$app->get('forgotten-passord/token/{token}', function ($token) use ($app) {

    /**
     * @var EmailConfirmacao $emailConfirmacao
     */
    $emailConfirmacao = $app['email.confirmacao.repository']->findOneBy(['token' => $token]);

    if (!$emailConfirmacao) {
        return $app['twig']->render('token_invalido.html.twig', ['mensagem' => 'Código de autorização inválido!']);
    }

    $dataAtual = new DateTime('now');

    if ($dataAtual > $emailConfirmacao->getValidade()) {
        return $app['twig']->render('token_invalido.html.twig', ['mensagem' => 'Token Expirado!']);
    }

    $emailConfirmacao->setAtivoEm(new DateTime('now'));
    $app['email.confirmacao.repository']->save($emailConfirmacao);

    return $app['twig']->render('forgotten_password.html.twig', ['email' => $emailConfirmacao->getUsuario()->getEmail()]);

});

$app->post('forgot-password', function (\Symfony\Component\HttpFoundation\Request $request) use ($app) {

    if (0 == $request->request->count()) {
        return $app->json([
            "classe" => "error",
            "mensagem" => "Nada Enviado.",
        ], 500);
    }

    if ($request->request->get('email')) {

        $assunto = 'Redefinição de Senha';

        $config = $app['config'];

        /**
         * @var Usuarios $usuario
         */
        $usuario = $app['usuarios.repository']->findOneBy(['email' => $request->request->get('email')]);

        if (!$usuario) {
            return $app->json([
                'classe' => 'error',
                'mensagem' => "Não existe nenhum cadastro com esse e-mail."
            ], 403);
        }

        $uuid = $app['uuid.service'];

        $link = "https://coletaneaicm.com/forgotten-passord/token/" . $uuid;
        
        $dateTime = new DateTime('now');
        $dataLimite = new DateTime('now');
        $dataLimite->modify('+1 day');

        $statusEmail = $app['status.email.repository']->find(1);

        $emailConfirmacao = new EmailConfirmacao();
        $emailConfirmacao->setUsuario($usuario);
        $emailConfirmacao->setToken($uuid);
        $emailConfirmacao->setGeradoEm($dateTime);
        $emailConfirmacao->setValidade($dataLimite);
        $emailConfirmacao->setStatus($statusEmail);

        $app['email.confirmacao.repository']->save($emailConfirmacao);

        $array = [
            'nome' => $usuario->getNome(),
            'link' => $link,
            'site' => $config->getNome(),
            'lema' => $config->getSubtitulo()
        ];

        $body = $app['twig']->render('user/email_forgotten_password.html.twig', $array);

        $email = new Email($assunto, $app['email.padrao'], $body);
        $email->send($request->request->get('email'), $app);

        $emailEnviado = new EmailEnviado();
        $emailEnviado->setUsuario($usuario);
        $emailEnviado->setTipo($assunto);
        $emailEnviado->setMensagem($assunto);
        $emailEnviado->setDataHora(new DateTime('now'));

        $app['db']->beginTransaction();
        $app['email.enviado.repository']->save($emailEnviado);
        $app['db']->commit();
    }

    return $app->json([
        "classe" => "sucesso",
        "mensagem" => "Um Email para a redefinição de senha foi enviado para " . $request->request->get('email') . "",
    ], 201);

});

$app->match('register/save', function (\Symfony\Component\HttpFoundation\Request $request) use ($app) {

        if ($app['usuarios.repository']->findBy(['email' => $request->request->get('email')])) {
            return $app->json(
                ['class' => 'error', 'message' => 'Este e-mail já está cadastrado.']
            );
        }

        $encoder = $app['security.encoder.digest'];
        $password = $encoder->encodePassword($request->get('password'), '');

        $usuario = new \Api\Entities\Usuarios();
        $usuario->setNome(ucwords($request->request->get('nome')));
        $usuario->setEmail(strtolower($request->request->get('email')));
        $usuario->setPassword($password);
        $usuario->setAvatar('avatar.png');
        $usuario->setCadastro(new \DateTime('now'));
        $usuario->setRoles('ROLE_USER');
        $usuario->setAtivo(true);

        $app['db']->beginTransaction();
        $app['usuarios.repository']->save($usuario);
        $app['db']->commit();

        $config = $app['config'];
        $assunto = "Confirmação de Cadastro";
        $mensagem = "Seja Bem Vindo(a) ao Coletânea ICM.";

        $array = [
            'mensagem' => $mensagem,
            'nome' => $request->request->get('nome'),
            'site' => $config->getNome(),
            'lema' => $config->getSubtitulo()
        ];

        $body = $app['twig']->render('/user/success.html.twig', $array);
        $email = new Email($assunto, $app['email.padrao'], $body);
        $email->send($request->request->get('email'), $app);

        $emailEnviado = new EmailEnviado();
        $emailEnviado->setUsuario($usuario);
        $emailEnviado->setTipo($assunto);
        $emailEnviado->setMensagem($mensagem);
        $emailEnviado->setDataHora(new DateTime('now'));

        $app['db']->beginTransaction();
        $app['email.enviado.repository']->save($emailEnviado);
        $app['db']->commit();

        return $app->json(
            [
                'class' => 'success',
                'user' => [
                    'username' => $usuario->getEmail(),
                    'password' => $usuario->getPassword(),
                    'id' => $usuario->getId(),
                    'nome' => $usuario->getNome()
                ],
                'message' => 'Usuario Registrado'
            ]
        );
    });

$app->post('forgotten-password/save', function (\Symfony\Component\HttpFoundation\Request $request) use ($app) {

        /**
         * @var Usuarios $user
         */
        $user = $app['usuarios.repository']->findOneBy(['email' => $request->request->get('email')]);

        $encoder = $app['security.encoder.digest'];
        $password = $encoder->encodePassword($request->get('password'), '');

        $user->setPassword($password);

        $app['db']->beginTransaction();
        $app['usuarios.repository']->save($user);
        $app['db']->commit();

        $config = $app['config'];
        $assunto = "Sucesso na redefinição de senha";
        $mensagem = "Sua senha foi redefinida com sucesso!";

        $array = [
            'mensagem' => $mensagem,
            'nome' => $user->getNome(),
            'site' => $config->getNome(),
            'lema' => $config->getSubtitulo()
        ];

        $body = $app['twig']->render('/user/success.html.twig', $array);
        $email = new Email($assunto, $app['email.padrao'], $body);
        $email->send($request->request->get('email'), $app);

        $emailEnviado = new EmailEnviado();
        $emailEnviado->setUsuario($user);
        $emailEnviado->setTipo($assunto);
        $emailEnviado->setMensagem($mensagem);
        $emailEnviado->setDataHora(new DateTime('now'));

        $app['db']->beginTransaction();
        $app['email.enviado.repository']->save($emailEnviado);
        $app['db']->commit();

        return $app->json(
            [
                'class' => 'success',
                'user' => [
                    'username' => $user->getEmail(),
                    'password' => $user->getPassword(),
                    'id' => $user->getId(),
                    'nome' => $user->getNome()
                ],
                'message' => 'Usuario Registrado'
            ]
        );
    });