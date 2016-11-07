<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 18/08/16
 * Time: 16:38
 */

namespace Api\Controllers;


use Api\Entities\Usuarios;
use App\Controllers\UploadImages;
use Security\UserProvider;
use Silex\Application;
use Silex\Provider\FormServiceProvider;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

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
       
    }
    
    /**
     * @param Application $app
     * @return mixed
     */
    public function getUsuarios(Application $app)
    {
        $usuarios = $app['usuarios.repository']->findAll();
    
        return $app['twig']->render('/admin/usuarios.html.twig', ['usuarios' => $usuarios]);
    }
    
    /**
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @throws \Exception
     */
    public function editar(Request $request, Application $app)
    {
        if (empty($request->get('id'))) {
            throw new \Exception('Usuario não informado.');
        }

        /**
         * @var Usuarios $usuario
         */
        $usuario = $app['usuarios.repository']->find($request->get('id'));

        if ($request->get('nome') != $usuario->getNome()) {
            $usuario->setNome($request->get('nome'));
        }

        if ($request->get('email') != $usuario->getEmail()) {
            $usuario->setEmail($request->get('email'));
        }

        if (!empty($_FILES['background']['size'])) {
            $usuario->setAvatar($app['upload.service']->upload($_FILES['background'], 'avatar', $usuario->getAvatar()));
        }

        $app['db']->beginTransaction();
        $app['usuarios.repository']->save($usuario);
        $app['db']->commit();

        return $app->redirect('/user/perfil/'.$usuario->getId());
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

    /**
     * @param int $id
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function alteraStatus($id, Application $app)
    {
        /**
         * @var Usuarios $usuario
         */
        $usuario = $app['usuarios.repository']->find($id);
        $usuario->setAtivo(!$usuario->isAtivo());

        $app['db']->beginTransaction();
        $app['usuarios.repository']->save($usuario);
        $app['db']->commit();

        return $app->redirect('/admin/usuarios/list');
    }
    
    /**
     * @param int $user
     * @param Application $app
     * @return mixed
     */
    public function getAtividadesUsuario($user, Application $app)
    {
        $logs = $app['log.repository']->findBy(['usuario' => $user], ['cadastro' => 'DESC']);
        $musicas = $app['musica.repository']->findBy(['usuario' => $user], ['cadastro' => 'DESC']);
        $musicaAnexos = $app['musica.anexos.repository']->findBy(['usuario' => $user], ['cadastro' => 'DESC']);
        $posts = $app['posts.repository']->findBy(['usuario' => $user], ['cadastro' => 'DESC']);
    
        return $app['twig']->render('/user/atividade.html.twig', 
            [
                'logs' => $logs, 
                'musicas' => $musicas, 
                'musica_anexos' => $musicaAnexos, 
                'posts' => $posts
            ]
        );
    }
}