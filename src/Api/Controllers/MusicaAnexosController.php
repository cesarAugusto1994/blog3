<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 10/09/16
 * Time: 11:54
 */

namespace Api\Controllers;

use Api\Entities\AnexoTags;
use Api\Entities\Musica;
use Api\Entities\MusicaAnexos;
use Api\Entities\MusicaTags;
use Api\Entities\Tag;
use Api\Entities\Tipo;
use App\Controllers\Downloader;
use App\Controllers\MediaFormat;
use App\Controllers\Uploader;
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

    }
    
    /**
     * @param $musicaId
     * @param Application $app
     * @return mixed
     */
    public function musicasAnexosGrid($musicaId, Application $app)
    {

    }

    /**
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function upload($musicaId, Request $request, Application $app)
    {
        
    }

    /**
     * @param $musicaId
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function novo($musicaId, Request $request, Application $app)
    {
        /**
         * @var Musica $musica
         */
        $musica = $app['musica.repository']->find($musicaId);
        $user = $app['session']->get('user');
        $usuario = $app['usuarios.repository']->find($user->getId());

        /**
         * @var Tipo $tipo
         */
        $tipo = $app['tipo.anexo.repository']->find($request->get('tipo'));

        $link = $request->get('link');

        if ($tipo->getNome() == 'Video') {
            preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+(?=\?)|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $request->get('link'), $matches);
            $link = $matches[0];
        }

        $musicaAnexo = new MusicaAnexos();
        $musicaAnexo->setNome($musica->getNome());
        $musicaAnexo->setMusica($musica);
        $musicaAnexo->setTipo($tipo);
        $musicaAnexo->setLinkExterno(true);
        $musicaAnexo->setLink($link);
        $musicaAnexo->setUsuario($usuario);
        $musicaAnexo->setCadastro(new \DateTime('now'));
        $musicaAnexo->setAtivo(true);

        $app['db']->beginTransaction();
        $app['musica.anexos.repository']->save($musicaAnexo);
        $app['db']->commit();

        $mensagem = 'Adicionou o arquivo '.$musicaAnexo->getNome();
    
        $app['log.controller']->criar($mensagem);
        $app['session']->getFlashBag()->add('mensagem', $mensagem);

        if ($app['security.authorization_checker']->isGranted('ROLE_USER')) {
            return $app->redirect('/user/musica/anexos/' . $musica->getId());
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
         * @var MusicaAnexos $musicaAnexo
         */
        $musicaAnexo = $app['musica.anexos.repository']->find($request->get('id'));
        /**
         * @var Musica $musica
         */
        $musica = $app['musica.repository']->find($request->get('musica'));
        $tipo = $app['tipo.anexo.repository']->find($request->get('tipo'));

        $musicaAnexo->setNome($request->get('nome'));
        $musicaAnexo->setMusica($musica);
        $musicaAnexo->setTipo($tipo);
        $musicaAnexo->setLink($request->get('link'));

        $app['musica.anexos.repository']->save($musicaAnexo);
    
        $app['log.controller']->criar('editou o arquivo '.$musicaAnexo->getNome());

        $app['session']->getFlashBag()->add('mensagem', 'Arquivo editado com sucesso.');

        if ($app['security.authorization_checker']->isGranted('ROLE_USER')) {
            return $app->redirect('/user/musica/anexos/' . $musica->getId());
        }

        return $app->redirect('/admin/musicas/anexos/grid/'.$musica->getId().'/'.$musica->getNome());
    }
    
    /**
     * @param $id
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function remover($id, Application $app)
    {
       
    }

    /**
     * @param $tipo
     * @param Application $app
     * @return mixed
     */
    public function getByTipo($tipo, Application $app)
    {
       

    }

}