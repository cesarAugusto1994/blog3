<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 10/09/16
 * Time: 10:41
 */

namespace Api\Controllers;

use Api\Entities\Musica;
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
        
        return $app['twig']->render('musicas.html.twig', ['musicas' => $app['musica.repository']->findBy(['categoria' => $categoria, 'ativo' => true])]);
    }

    /**
     * @param Application $app
     * @return mixed
     */
    public function musicasGrid(Application $app)
    {
        $categoria = $app['categoria.repository']->findAll();
        $musicas = $app['musica.repository']->findBy(['categoria' => $categoria, 'ativo' => true]);
        
        return $app['twig']->render('admin/musicas.html.twig', ['musicas' => $musicas, 'categorias' => $categoria]);
    }
    
    /**
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function novo(Request $request, Application $app)
    {
        $musica = new Musica();
        $categoria = $app['categoria.repository']->find($request->get('categoria'));

        $musica->setNumero($request->get('numero'));
        $musica->setNome($request->get('nome'));
        $musica->setCategoria($categoria);
        $musica->setAtivo(true);

        $app['musica.repository']->save($musica);

        return $app->redirect('musicas_grid');
    }
    
    public function editar(Request $request, Application $app)
    {
        $musica = $app['musica.repository']->find($request->get('id'));
        $categoria = $app['categoria.repository']->find($request->get('id'));
        
        $musica->setNumero($request->get('numero'));
        $musica->setNome($request->get('nome'));
        $musica->setCategoria($categoria);

        $app['musica.repository']->save($musica);

        return $app->redirect('musicas_grid');
    }
    
    
}