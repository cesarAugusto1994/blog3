<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 26/09/16
 * Time: 14:08
 */

namespace Api\Controllers;

use Api\Entities\EmailConfirmacao;
use Api\Entities\Usuarios;
use Silex\Application;

/**
 * Class EmailConfirmacaoController
 * @package Api\Controllers
 */
class EmailConfirmacaoController
{
    /**
     * @param Usuarios $usuario
     * @param Application $app
     * @return EmailConfirmacao
     */
    public function criar(Usuarios $usuario, Application $app)
    {
        $emailConfirmation = new EmailConfirmacao();
        $emailConfirmation->setUser($usuario);
        $emailConfirmation->setEmail($usuario->getEmail());
        $emailConfirmation->setUuid($app['uuid.service']);
        $emailConfirmation->setCreated(new \DateTime('now'));
        $emailConfirmation->setStatus(true);
        
        $app['email.confirmation.repository']->save($emailConfirmation);
        
        return $emailConfirmation;
    }

    /**
     * @param string $uuid
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Exception
     */
    public function confirmarEmail($uuid, Application $app)
    {
        $codigo = $app['email.confirmation.repository']->findBy(['uuid' => $uuid]);

        if (!$codigo) {
            throw new \Exception('Codigo não encontrado.');
        }

        $emailConfirmacao = $app['email.confirmation.repository']->find($codigo[0]->getId());
        $emailConfirmacao->setConfirmed(new \DateTime('now'));
        $emailConfirmacao->setStatus(false);

        $app['email.confirmation.repository']->save($emailConfirmacao);

        return $app->redirect('/login');
    }
}