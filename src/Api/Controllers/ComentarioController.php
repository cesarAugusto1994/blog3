<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 17/10/16
 * Time: 16:22
 */

namespace Api\Controllers;

use Api\Entities\Comentarios;
use Symfony\Component\Console\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ComentarioController
 * @package Api\Controllers
 */
class ComentarioController
{
    /**
     * @param Request $request
     * @param \Silex\Application $app
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function criar(Request $request, \Silex\Application $app)
    {
        $musica = $app['musica.repository']->find($request->get('id'));

        $user = $app['session']->get('user');
        $usuario = $app['usuarios.repository']->find($user->getId());
        
        $comentario = new Comentarios();
        $comentario->setComentario($request->get('comentario'));
        $comentario->setMusica($musica);
        $comentario->setUsuario($usuario);
        $comentario->setCadastro(new \DateTime('now'));
        $comentario->setAtivo(true);
        
        $app['db']->beginTransaction();
        $app['comentario.repository']->save($comentario);
        $app['db']->commit();
    
        $app['log.controller']->criar('Comentou o hino '.$musica->getNome());
        $app['session']->getFlashBag()->add('mensagem', 'Comentário enviado com sucesso.');
    
        return $app->json(
            [
                'class' => 'success',
                'message' => 'Comentário enviado com sucesso.'
            ]
        );
    }
}