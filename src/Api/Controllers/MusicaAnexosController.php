<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 10/09/16
 * Time: 11:54
 */

namespace Api\Controllers;

use Api\Entities\MusicaAnexos;
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
    use MediaFormat;
    use Downloader;
    
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
    public function novo(Request $request, Application $app, $musicaId)
    {
        $musica = $app['musica.repository']->find($musicaId);

        $uploader = new Uploader();
        $data = $uploader->upload($_FILES['files'], array(
            'limit' => 100, //Maximum Limit of files. {null, Number}
            'maxSize' => 120, //Maximum Size of files {null, Number(in MB's)}
            'extensions' => null, //Whitelist for file extension. {null, Array(ex: array('jpg', 'png'))}
            'required' => false, //Minimum one file is required for upload {Boolean}
            'title' => array('name'), //New file name {null, String, Array} *please read documentation in README.md
            'removeFiles' => true, //Enable file exclusion {Boolean(extra for jQuery.filer), String($_POST field name containing json data with file names)}
            'replace' => true, //Replace the file if it already exists  {Boolean}
            'perms' => null, //Uploaded file permisions {null, Number}
            'onCheck' => null, //A callback function name to be called by checking a file for errors (must return an array) | ($file) | Callback
            'onError' => null, //A callback function name to be called if an error occured (must return an array) | ($errors, $file) | Callback
            'onSuccess' => null, //A callback function name to be called if all files were successfully uploaded | ($files, $metas) | Callback
            'onUpload' => null, //A callback function name to be called if all files were successfully uploaded (must return an array) | ($file) | Callback
            'onComplete' => true, //A callback function name to be called when upload is complete | ($file) | Callback
            'onRemove' => null //A callback function name to be called by removing files (must return an array) | ($removed_files) | Callback
        ));

        foreach ($_FILES['files']['name'] as $key => $name) {

            if (empty($name)) {
               continue;
            }

            $tipo = $app['tipo.anexo.repository']->find($this->getFormatTipo($_FILES['files']['name'][$key]));

            $musicaAnexo = new MusicaAnexos();
            $musicaAnexo->setNome($request->get('nome') ? $request->get('nome') : $name);
            $musicaAnexo->setMusica($musica);
            $musicaAnexo->setTipo($tipo);
            $musicaAnexo->setLink($request->get('link') ? $request->get('link') : $name);
            $musicaAnexo->setAtivo(true);

            $app['musica.anexos.repository']->save($musicaAnexo);
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
    
    /**
     * @param $id
     * @param Application $app
     * @throws \Exception
     */
    public function download($id, Application $app)
    {
        $anexo = $app['musica.anexos.repository']->find($id);
        
        $this->downloadFile($anexo->getLink());
    }
    
    /**
     * @param $id
     * @param $app
     * @return bool
     */
    public function remover($id, Application $app)
    {
        $anexo = $app['musica.anexos.repository']->find($id);

        $directory = __DIR__.'/../../../web/assets/blog/songs/';
    
        unlink($directory.$anexo->getNome());
        
        $app['musica.anexos.repository']->remove($anexo);

        return $app->redirect('/admin/musicas/anexos/grid/'.$anexo->getMusica()->getId().'/'.$anexo->getMusica()->getNome());
    }
}