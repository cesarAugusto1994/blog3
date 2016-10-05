<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 10/09/16
 * Time: 11:54
 */

namespace Api\Controllers;

use Api\Entities\AnexoTags;
use Api\Entities\MusicaAnexos;
use Api\Entities\MusicaTags;
use Api\Entities\Tag;
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
        
        return $app['twig']->render('/user/musica_anexos.html.twig', 
            [
                'anexos' => $app['musica.anexos.repository']->findBy(['musica' => $musica, 'ativo' => true]),
                'musica' => $musica
            ]);
    }
    
    /**
     * @param $musicaId
     * @param Application $app
     * @return mixed
     */
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
    public function upload($musicaId, Request $request, Application $app)
    {
        $musica = $app['musica.repository']->find($musicaId);
        $user = $app['session']->get('user');
        $usuario = $app['usuarios.repository']->find($user->getId());

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

            $tipo = $app['tipo.anexo.repository']->find($this->getFormatTipo($_FILES['files']['type'][$key]));

            $musicaAnexo = new MusicaAnexos();
            $musicaAnexo->setNome($request->get('nome') ? $request->get('nome') : $name);
            $musicaAnexo->setMusica($musica);
            $musicaAnexo->setTipo($tipo);
            $musicaAnexo->setLinkExterno(false);
            $musicaAnexo->setLink($request->get('link') ? $request->get('link') : $name);
            $musicaAnexo->setUsuario($usuario);
            $musicaAnexo->setCadastro(new \DateTime('now'));
            $musicaAnexo->setAtivo(true);

            $app['musica.anexos.repository']->save($musicaAnexo);
    
            $app['log.controller']->criar('adicionou o arquivo '.$musicaAnexo->getNome());
        }

        if ($request->get('user_anexos')) {
           return $app->redirect('/user/musica/anexos/'.$musica->getId().'#menu'); 
        }
        
        return $app->redirect('/admin/musicas/anexos/grid/'.$musica->getId().'/'.$musica->getNome());
    }

    /**
     * @param $musicaId
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function novo($musicaId, Request $request, Application $app)
    {
        $musica = $app['musica.repository']->find($musicaId);
        $user = $app['session']->get('user');
        $usuario = $app['usuarios.repository']->find($user->getId());

        $tipo = $app['tipo.anexo.repository']->find($request->get('tipo'));

        $musicaAnexo = new MusicaAnexos();
        $musicaAnexo->setNome($request->get('nome'));
        $musicaAnexo->setMusica($musica);
        $musicaAnexo->setTipo($tipo);
        $musicaAnexo->setLinkExterno(true);
        $musicaAnexo->setLink($request->get('link'));
        $musicaAnexo->setUsuario($usuario);
        $musicaAnexo->setCadastro(new \DateTime('now'));
        $musicaAnexo->setAtivo(true);

        $app['musica.anexos.repository']->save($musicaAnexo);
    
        $app['log.controller']->criar('adicionou o arquivo '.$musicaAnexo->getNome());

        $accept = ['vozes', 'tenor', 'soprano', 'contralto'];
        $tags = explode(' ', $request->get('nome'));

        foreach ($tags as $tag) {

            if (in_array(strtolower($tag), $accept)) {

                $existeTag = $app['tag.repository']->findBy(['nome' => strtolower($tag)]);

                if(!$existeTag) {
                    $tagC = new Tag();
                    $tagC->setNome(strtolower($tag));
                    $tagC->setAtivo(true);
                    $app['tag.repository']->save($tagC);
                } else {
                    $tagC = $existeTag[0];
                }

                $existeAnexoTag = $app['musica.anexo.tags.repository']->findBy(['anexo' => $musicaAnexo, 'tag' => $tagC]);

                if (!$existeAnexoTag ) {
                    $anexoTags = new AnexoTags();
                    $anexoTags->setAnexo($musicaAnexo);
                    $anexoTags->setTag($tagC);
                    $app['musica.anexo.tags.repository']->save($anexoTags);
                }
            }
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
        $musica = $app['musica.repository']->find($request->get('musica'));
        $tipo = $app['tipo.anexo.repository']->find($request->get('tipo'));

        $musicaAnexo->setNome($request->get('nome'));
        $musicaAnexo->setMusica($musica);
        $musicaAnexo->setTipo($tipo);
        $musicaAnexo->setLink($request->get('link'));

        $app['musica.anexos.repository']->save($musicaAnexo);
    
        $app['log.controller']->criar('editou o arquivo '.$musicaAnexo->getNome());

        return $app->redirect('/admin/musicas/anexos/grid/'.$musica->getId().'/'.$musica->getNome());
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
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function remover($id, Application $app)
    {
        /**
         * @var MusicaAnexos $anexo
         */
        $anexo = $app['musica.anexos.repository']->find($id);

        $directory = __DIR__.'/../../../web/assets/blog/musicas/'.$anexo->getLink();

        if(file_exists($directory)) {
            unlink($directory);
        }
        
        $app['musica.anexos.repository']->remove($anexo);
    
        $app['log.controller']->criar('removeu o arquivo '.$anexo->getNome());
    
        if ($app['security.authorization_checker']->isGranted('ROLE_ADMIN')) {
            return $app->redirect('/user/musica/anexos/'.$anexo->getMusica()->getId().'#menu');
        }

        return $app->redirect('/admin/musicas/anexos/grid/'.$anexo->getMusica()->getId().'/'.$anexo->getMusica()->getNome());
    }
}