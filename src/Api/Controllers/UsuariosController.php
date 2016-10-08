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
    use UploadImages;
    /**
     * @param int $id
     * @param Application $app
     * @return mixed
     */
    public function getUser($id, Application $app)
    {
        $user = $app['usuarios.repository']->find($id);

        return $app['twig']->render('/user/perfil.html.twig', ['user' => $user]);
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
            $app['log.controller']->criar('alterou o nome de usuario no perfil de ' . $usuario->getNome() . ' para ' . $request->get('nome'));
            $usuario->setNome($request->get('nome'));
        }
        
        if ($request->get('nickname') != $usuario->getNickname()) {
            $usuario->setNickname(strtolower($request->get('nickname')));
        }

        if ($request->get('email') != $usuario->getEmail()) {
            $usuario->setEmail($request->get('email'));
            $app['log.controller']->criar('alterou o e-mail no perfil de ' . $usuario->getNome());
        }

        if (!empty($_FILES['background']['size'])) {
            $usuario->setAvatar($this->upload($_FILES['background'], 'avatar', $usuario->getAvatar()));
            $app['log.controller']->criar('alterou a foto do perfil de '.$usuario->getNome());
        }

        $app['usuarios.repository']->save($usuario);

        $app['session']->getFlashBag()->add('mensagem', 'Informações do usuário alteradas com sucesso.');

        return $app->redirect('/user/perfil/'.$usuario->getId());
    }
    
    /**
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function novo(Request $request, Application $app)
    {
        $form = $app['form.factory']->createBuilder(FormType::class)
            ->add('nome', TextType::class, [
                'required' => true,
                'constraints' => [new Assert\NotBlank(), new Assert\Length([
                    'min' => 5, 'minMessage' => 'Seu Nome deve possuir mais de {{ limit }} caracteres.',
                    'max' => 30, 'maxMessage' => 'Seu Nome deve possuir menos de {{ limit }} caracteres.'])],
                'attr' => array('class' => 'form-control', 'placeholder' => 'Nome')
            ])->add('nickname', TextType::class, [
                'required' => true,
                'constraints' => [new Assert\NotBlank(), new Assert\Length([
                    'min' => 5, 'minMessage' => 'Seu Nickname deve possuir mais de {{ limit }} caracteres.',
                    'max' => 30, 'maxMessage' => 'Seu Nickname deve possuir menos de {{ limit }} caracteres.'])],
                'attr' => array('class' => 'form-control', 'placeholder' => 'Usuário ex.: usuario')
            ])->add('email', EmailType::class, [
                'required' => true,
                'constraints' => [new Assert\Email(), new Assert\Length(['min' => 6])],
                'attr' => array('class' => 'form-control', 'placeholder' => 'E-mail')
            ])->add('password', PasswordType::class, [
                'required' => true,
                'constraints' => [new Assert\NotBlank(), new Assert\Length([
                    'min' => 6, 'minMessage' => 'Sua Senha deve possuir mais de {{ limit }} caracteres.',])],
                'attr' => array('class' => 'form-control', 'placeholder' => 'Senha')
            ])->add('password_confirm', PasswordType::class, [
                'required' => true,
                'constraints' => [new Assert\NotBlank(), new Assert\Length([
                    'min' => 6, 'minMessage' => 'Sua Senha deve possuir mais de {{ limit }} caracteres.',])],
                'attr' => array('class' => 'form-control', 'placeholder' => 'Confirme sua Senha')
            ])->add('salvar', SubmitType::class, [
                    'attr' => ['class' => 'btn btn-primary btn-block btn-flat', 'value' => 1]
                ]
            )->getForm();

        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            
            if ($request->get('form')['password'] != $request->get('form')['password_confirm']) {
                return $app['twig']->render(
                    'register.html.twig',
                    ['error' => 'As Senhas não conferem.', 'form' => $form->createView()]
                );
            }
        
            $email = $app['usuarios.repository']->findBy(['email' => $request->get('form')['email']]);
    
            if ($email) {
                return $app['twig']->render(
                    'register.html.twig',
                    ['error' => 'Já existe um cadastro com esse e-mail.', 'form' => $form->createView()]
                );
            }
    
            $encoder = $app['security.encoder.digest'];
            $password = $encoder->encodePassword($request->get('form')['password'], '');
    
            $usuario = new Usuarios();
            $usuario->setNome($request->get('form')['nome']);
            $usuario->setNickname(strtolower($request->get('form')['nickname']));
            $usuario->setEmail($request->get('form')['email']);
            $usuario->setPassword($password);
            $usuario->setCadastro(new \DateTime('now'));
            $usuario->setAvatar($app['avatar.default']);
            $usuario->setRoles('ROLE_USER');
            $usuario->setAtivo(true);
            $app['usuarios.repository']->save($usuario);

            $app['session']->getFlashBag()->add('mensagem', 'Você se cadastrou com sucesso.');

            //$app['email.confirmacao.controller']->criar($usuario, $app);

            if ($app['envia.email']) {
                //$app['usuario.email.service']->send($usuario->getEmail(), $app);
            }
        
            return $app->redirect('login');
        }
    
        return $app['twig']->render('register.html.twig', ['form' => $form->createView()]);
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

        if ($usuario->isAtivo()) {
            $usuario->setAtivo(false);
        } else {
            $usuario->setAtivo(true);
        }

        $app['usuarios.repository']->save($usuario);

        $app['log.controller']->criar(($usuario->isAtivo() ? 'ativou' : 'inativou') . ' o usuário ' . $usuario->getNome());

        $app['session']->getFlashBag()->add('mensagem', 'Usuário '.($usuario->isAtivo() ? 'ativado' : 'inativado').' com sucesso.');

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