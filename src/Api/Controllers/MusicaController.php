<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 10/09/16
 * Time: 10:41
 */

namespace Api\Controllers;

use Api\Entities\Categoria;
use Api\Entities\Musica;
use Api\Entities\Usuarios;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class MusicaController
 * @package Api\Controllers
 */
class MusicaController
{
    /**
     * @param Application $app
     * @return mixed
     */
    public function index($categoriaId, Application $app)
    {
        $categoria = $app['categoria.repository']->find($categoriaId);

        return $app['twig']->render('/user/musicas.html.twig',
            ['musicas' => $app['musica.repository']->findBy(['categoria' => $categoria, 'ativo' => true], ['numero' => 'ASC']),
             'categoria' => $categoria
            ]);
    }
    
    /**
     * @param int $categoria
     * @param Application $app
     * @param bool $roleUser
     * @return mixed
     */
    public function novaMusica($categoria, Application $app, $roleUser = false)
    {
        $categorias = $app['categoria.repository']->findBy(['ativo' => true], ['nome' => 'ASC']);
        
        if ($roleUser) {
            return $app['twig']->render('/user/musica_nova.html.twig', ['categoriaTela' => $categoria,'categorias' => $categorias]);
        }
        
        return $app['twig']->render('/admin/musica_add.html.twig', ['categorias' => $categorias]);
    }
    
    /**
     * @param $id
     * @param Application $app
     * @return mixed
     */
    public function editarMusica($id, Application $app, $edicaoUsuario = false, $editarLetra = false)
    {
        $musica = $app['musica.repository']->find($id);
        $categorias = $app['categoria.repository']->findBy(['ativo' => true], ['nome' => 'ASC']);
        
        if ($edicaoUsuario) {
            return $app['twig']->render('/user/musica_editar.html.twig', ['musica' => $musica, 'categorias' => $categorias]);
        }
    
        if ($editarLetra) {
            return $app['twig']->render('/user/musica_editar_letra.html.twig', ['musica' => $musica, 'categorias' => $categorias]);
        }
        
        return $app['twig']->render('/admin/musica_editar.html.twig', ['musica' => $musica, 'categorias' => $categorias]);
    }

    /**
     * @param Application $app
     * @return mixed
     */
    public function musicasGrid(Application $app)
    {
        $categoria = $app['categoria.repository']->findAll();
        $musicas = $app['musica.repository']->findBy(['categoria' => $categoria], ['numero' => 'ASC']);
        
        return $app['twig']->render('/admin/musicas.html.twig', ['musicas' => $musicas, 'categorias' => $categoria]);
    }
    
    /**
     * @param $categoriaId
     * @param Application $app
     * @return mixed
     */
    public function categoriaMusicasGrid($categoriaId, Application $app)
    {
        $categoria = $app['categoria.repository']->find($categoriaId);
        $categorias = $app['categoria.repository']->findBy([], ['nome' => 'ASC']);
        $musicas = $app['musica.repository']->findBy(['categoria' => $categoria, 'ativo' => true]);
        
        return $app['twig']->render('/admin/musicas.html.twig', ['musicas' => $musicas, 'categorias' => $categorias]);
    }
    
    /**
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function novo(Request $request, Application $app)
    {
        $musica = new Musica();
        /**
         * @var Categoria $categoria
         */
        $categoria = $app['categoria.repository']->find($request->get('categoria'));
        $user = $app['session']->get('user');
        /**
         * @var Usuarios $usuario
         */
        $usuario = $app['usuarios.repository']->find($user->getId());
        
        $musica->setNome($request->get('nome'));
        $musica->setNumero($request->get('numero') ?: null);
        $musica->setTom($request->get('tonalidade'));

        if ($request->get('letra')) {
            $musica->setLetra(strip_tags($request->get('letra')));
            $musica->setLetraOriginal($request->get('letra'));
        }
        $musica->setCategoria($categoria);
        $musica->setUsuario($usuario);
        $musica->setCadastro(new \DateTime('now'));
        $musica->setAtivo(true);

        $app['musica.repository']->save($musica);
    
        $app['log.controller']->criar('adicionou nova musica '.$musica->getNome());

        $app['session']->getFlashBag()->add('mensagem', 'Musica adicionada com sucesso.');

        if ($request->get('role') == 'user') {
            return $app->redirect('/user/musicas/'.$categoria->getId());
        }

        return $app->redirect('/admin/musicas/anexos/grid/'.$musica->getId().'/'.$musica->getNome());
    }
    
    /**
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editar(Request $request, Application $app)
    {
        /**
         * @var Musica $musica
         */
        $musica = $app['musica.repository']->find($request->get('id'));
        
        if ($request->get('nome')) {
            $musica->setNome($request->get('nome'));
            $musica->setNumero($request->get('numero'));
            $musica->setTom($request->get('tonalidade'));
        }
        
        if ($request->get('letra')) {
            $musica->setLetra(strip_tags($request->get('letra')));
            $musica->setLetraOriginal($request->get('letra'));
        }
    
        if ($request->get('categoria')) {
            /**
             * @var Categoria $categoria
             */
            $categoria = $app['categoria.repository']->find($request->get('categoria'));
            $musica->setCategoria($categoria);
        }

        $app['musica.repository']->save($musica);

        $app['log.controller']->criar('editou musica '.$musica->getNome());

        $app['session']->getFlashBag()->add('mensagem', 'Musica editada com sucesso.');
        
        if ($request->get('rota') == 'edicao_usuario') {
            return $app->redirect('/user/musicas/' . $musica->getCategoria()->getId());
        }
    
        if ($request->get('rota') == 'edicao_letra') {
            return $app->redirect('/user/musica/anexos/' . $musica->getId());
        }
        
        return $app->redirect('/admin/musicas/grid');
    }

    /**
     * @param int $id
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function alteraStatus($id, Application $app)
    {
        /**
         * @var Musica $musica
         */
        $musica = $app['musica.repository']->find($id);

        if ($musica->isAtivo()) {
            $musica->setAtivo(false);
        } else {
            $musica->setAtivo(true);
        }

        $app['musica.repository']->save($musica);

        $app['log.controller']->criar('alterou o status da musica '.$musica->getNome());

        $app['session']->getFlashBag()->add('mensagem', 'Musica '.($musica->isAtivo() ? 'ativada' : 'desativada').' com sucesso.');

        return $app->redirect('/admin/musicas/grid');
    }
    
    
}