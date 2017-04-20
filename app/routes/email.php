<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 20/04/17
 * Time: 15:20
 */

use Api\Entities\EmailEnviado;
use Api\Entities\Usuarios;
use Api\Services\Email;

$email = $app['controllers_factory'];

$email->get('/listagem', function () use ($app) {
    $emails = $app['email.enviado.repository']->findBy([], ['id' => 'DESC'], 25);
    return $app['twig']->render('email/emails.html.twig', ['emails' => $emails]);
})->bind('listagem_emails');

$email->get('criar', function () use ($app) {
    $usuarios = $app['usuarios.repository']->findAll();
    return $app['twig']->render('user/email_criar.html.twig', ['usuarios' => $usuarios]);
})->bind('email_criar');

$email->post('enviar', function (\Symfony\Component\HttpFoundation\Request $request) use ($app) {

    $mensagem = $request->request->get('mensagem');
    $assunto = $request->request->get('assunto');
    $config = $app['config'];

    if ($request->request->get('todos')) {

        /**
         * @var Usuarios $usuario
         */
        $usuarios = $app['usuarios.repository']->findAll();

        $app['db']->beginTransaction();

        foreach ($usuarios as $usuario) {

            $array = [
                'mensagem' => $mensagem,
                'site' => $config->getNome(),
                'lema' => $config->getSubtitulo(),
                'nome' => $usuario->getNome()
            ];

            $body = $app['twig']->render('user/success.html.twig', $array);

            $email = new Email($assunto, $app['email.padrao'], $body);
            $email->send($usuario->getEmail(), $app);

            $emailEnviado = new EmailEnviado();
            $emailEnviado->setUsuario($usuario);
            $emailEnviado->setTipo($assunto);
            $emailEnviado->setMensagem($mensagem);
            $emailEnviado->setDataHora(new DateTime('now'));

            $app['email.enviado.repository']->save($emailEnviado);
        }

        $app['db']->commit();

        $app['session']->getFlashBag()->add('mensagem', 'Email enviado para todos usuários.');

        return $app->redirect('listagem');
    }

    /**
     * @var Usuarios $usuario
     */
    $usuario = $app['usuarios.repository']->find($request->request->get('usuario'));

    $array = [
        'mensagem' => $mensagem,
        'site' => $config->getNome(),
        'lema' => $config->getSubtitulo(),
        'nome' => $usuario->getNome()
    ];

    $body = $app['twig']->render('user/success.html.twig', $array);

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

    $app['session']->getFlashBag()->add('mensagem', 'Email enviado para ' . $usuario->getNome());

    return $app->redirect('listagem');

}

)->bind('form_email_criar');

return $email;