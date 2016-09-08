<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 18/08/16
 * Time: 16:38
 */

namespace Api\Controllers;


use Api\Entities\Usuarios;
use Silex\Application;

/**
 * Class UsuariosController
 * @package Api\Controllers
 */
class UsuariosController
{
    /**
     * @param int $id
     * @param Application $app
     * @return mixed
     */
    public function getUser($id, Application $app)
    {
        $user = $app['usuarios.repository']->find($id);

        return $app['twig']->render('admin/profile.html.twig', ['user' => $user]);
    }
    
    /**
     * @param int $id
     * @param Application $app
     * @return mixed
     */
    public function getPostsByUser($id, Application $app)
    {
        $user = $app['usuarios.repository']->find($id);

        return $app['twig']->render('index.html.twig', [
            'posts' => $user->getPosts(),
            'author_message' => 'Posts criados por: '.$user->getNome()
        ]);

    }
}