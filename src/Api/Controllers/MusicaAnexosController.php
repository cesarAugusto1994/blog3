<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 10/09/16
 * Time: 11:54
 */

namespace Api\Controllers;

use Api\Entities\MusicaAnexos;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class MusicaAnexosController
 * @package Api\Controllers
 */
class MusicaAnexosController
{
    /**
     * @param $musicaId
     * @param Application $app
     * @return mixed
     */
    public function index($musicaId, Application $app)
    {
        $musica = $app['musica.repository']->find($musicaId);
        
        return $app['twig']->render('musica_anexos.html.twig', 
            [
                'anexos' => $app['musica.anexos.repository']->findBy(['musica' => $musica, 'ativo' => true]),
                'musica' => $musica
            ]);
    }
    
    public function musicasAnexosGrid($musicaId, Application $app)
    {
        $musica = $app['musica.repository']->find($musicaId);
        
        $tipos = $app['tipo.anexo.repository']->findBy(['ativo' => true]);
        
        return $app['twig']->render('admin/musica_anexos.html.twig',
            [
                'anexos' => $app['musica.anexos.repository']->findBy(['musica' => $musica, 'ativo' => true]),
                'musica' => $musica,
                'tipos' => $tipos
            ]);
    }

    /**
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function novo(Request $request, Application $app)
    {
        $musicaAnexo = new MusicaAnexos();
        $musica = $app['musica.repository']->find($request->get('musica'));
        $tipo = $app['tipo.anexo.repository']->find($request->get('tipo'));

        $musicaAnexo->setNome($request->get('nome'));
        $musicaAnexo->setMusica($musica);
        $musicaAnexo->setTipo($tipo);
        $musicaAnexo->setLink($request->get('link'));
        $musicaAnexo->setAtivo(true);

        $app['musica.anexos.repository']->save($musicaAnexo);

        return $app->redirect('musicas/anexos/grid/'.$musica->getId().'/'.$musica->getNome());
    }

    /**
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editar(Request $request, Application $app)
    {
        $musicaAnexo = $app['musica.anexos.repository']->find($request->get('id'));
        $musica = $app['musica.repository']->find($request->get('musica'));
        $tipo = $app['tipo.anexo.repository']->find($request->get('tipo'));

        $musicaAnexo->setNome($request->get('nome'));
        $musicaAnexo->setMusica($musica);
        $musicaAnexo->setTipo($tipo);
        $musicaAnexo->setLink($request->get('link'));

        $app['musica.anexos.repository']->save($musicaAnexo);

        return $app->redirect('musicas/anexos/grid/'.$musica->getId().'/'.$musica->getNome());
    }
}