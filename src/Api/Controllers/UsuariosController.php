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

    public function editar(Request $request, Application $app)
    {
        if (empty($request->get('id'))) {
            throw new \Exception('Usuario n� informado.');
        }

        $usuario = $app['usuarios.repository']->find($request->get('id'));

        $usuario->setNome($request->get('nome'));
        $usuario->setEmail($request->get('email'));

        var_dump($request->get('id'));

        exit;

        $app['usuarios.repository']->save($usuario);

        $app->redirect('perfil');
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
            ])->add('email', EmailType::class, [
                'required' => true,
                'constraints' => [new Assert\Email(), new Assert\Length(['min' => 6])],
                'attr' => array('class' => 'form-control', 'placeholder' => 'E-mail')
            ])->add('password', PasswordType::class, [
                'required' => true,
                'constraints' => [new Assert\NotBlank(), new Assert\Length([
                    'min' => 6, 'minMessage' => 'Sua Senha deve possuir mais de {{ limit }} caracteres.',])],
                'attr' => array('class' => 'form-control', 'placeholder' => 'Senha')
            ])->add('salvar', SubmitType::class, [
                    'attr' => ['class' => 'btn btn-primary btn-block btn-flat', 'value' => 1]
                ]
            )->getForm();

        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
        
            $email = $app['usuarios.repository']->findBy(['email' => $request->get('form')['email']]);
    
            if ($email) {
                return $app['twig']->render(
                    'register.html.twig',
                    ['error' => 'O E-mail ja esta cadastrado.', 'form' => $form->createView()]
                );
            }
    
            $encoder = $app['security.encoder.digest'];
            $password = $encoder->encodePassword($request->get('form')['password'], '');
    
            $usuario = new Usuarios();
            $usuario->setNome($request->get('form')['nome']);
            $usuario->setEmail($request->get('form')['email']);
            $usuario->setPassword($password);
            $usuario->setCadastro(new \DateTime('now'));
            $usuario->setRoles('ROLE_USER');
            $usuario->setAtivo(true);
            $app['usuarios.repository']->save($usuario);

            //$app['email.confirmacao.controller']->criar($usuario, $app);

            if ($app['envia.email']) {
                //$app['usuario.email.service']->send($usuario->getEmail(), $app);
            }
        
            return $app['twig']->render('login.html.twig', ['sucesso' => 'Cadastro Efetivado.']);
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
}