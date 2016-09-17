<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 22/08/16
 * Time: 10:20
 */

namespace App\Controllers;

use App\Entities\Config;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class ConfigController
{
    use UploadImages;
    /**
     * @param Application $app
     * @return mixed
     */
    public function index(Application $app)
    {
        return end($app['config.repository']->findAll());
    }
    
    /**
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function novo(Request $request, Application $app) 
    {
        $config = new Config();
        
        $config->setNome($request->get('nome'));
        $config->setSubtitulo($request->get('subtitulo'));
        
        if (!empty($_FILES['background']['size'])) {
            $config->setBackground($this->upload($_FILES['background'], 'config', $config->getBackground()));
        }
    
        $app['config.repository']->save($config);
    
        return $app->redirect('/admin/blog');
    }
    
    /**
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editar(Request $request, Application $app)
    {
        $config = $app['config.repository']->find($request->get('id'));

        if  (!empty($request->get('nome'))) {
            $config->setNome($request->get('nome'));
        }

        $config->setSubtitulo($request->get('subtitulo'));

        if (!empty($_FILES['background']['size'])) {
            $config->setBackground($this->upload($_FILES['background'], 'config', $config->getBackground()));
        }
        
        $app['config.repository']->save($config);

        return $app->redirect('/admin/blog');
    }
}