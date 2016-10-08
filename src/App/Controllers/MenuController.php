<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 20/08/16
 * Time: 11:00
 */

namespace App\Controllers;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use App\Entities\Menu;

/**
 * Class MenuController
 * @package App\Controllers
 */
class MenuController
{
    use UploadImages;
    /**
     * @param Application $app
     * @return mixed
     */
    public function index(Application $app)
    {
        return $app->redirect('/admin/blog');
    }
    
    /**
     * @param Request $request
     * @param Application $app
     * @return mixed
     */
    public function criar(Request $request, Application $app)
    {
        $menu = new Menu();
        
        $menu->setNome($request->get('nome'));
        $menu->setDescricao($request->get('descricao'));
        $menu->setUrl($request->get('url'));
        $menu->setIcon($request->get('icone'));
        $menu->setCadastro(new \DateTime('now'));
        $menu->setPrevilegioRequerido(false);
        $menu->setAtivo(true);
        
        $app['menu.repository']->save($menu);
        
        return $app->redirect('/admin/menu#menu');
    }
    
    /**
     * @param $id
     * @param $app
     * @return mixed
     */
    public function alterarStatus($id, $app)
    {
        $menu = $app['menu.repository']->find($id);
    
        if ($menu->isAtivo()) {
            $menu->setAtivo(false);
        } else {
            $menu->setAtivo(true);
        }

        $app['menu.repository']->save($menu);
    
        return $app->redirect('/admin/menu#menu');
    }
    
    /**
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editar(Request $request, Application $app)
    {
        /**
         * @var Menu $menu
         */
        $menu = $app['menu.repository']->find($request->get('id'));

        $menu->setNome($request->get('nome'));
        
        if(!empty($request->get('descricao'))) {
            $menu->setDescricao($request->get('descricao'));
        }

        if(!empty($request->get('url'))) {
            $menu->setUrl($request->get('url'));
        }

        if (!empty($_FILES['icone']['size'])) {
            $menu->setIcon($this->upload($_FILES['icone'], 'menu', $menu->getIcon()));
        }
        
        $app['menu.repository']->save($menu);

        $app['session']->getFlashBag()->add('mensagem', 'Menu alterado com sucesso.');
    
       return $app->redirect('/admin/blog');
    }
}