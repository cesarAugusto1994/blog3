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
    /**
     * @param Application $app
     * @return mixed
     */
    public function index(Application $app)
    {
        return $app['twig']->render('admin/blog_menus.html.twig', ['menus' => $app['menu.repository']->findAll()]);
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
        $menu->setIcon($request->get('icon'));
        $menu->setCadastro(new \DateTime('now'));
        $menu->setAtivo(true);
        
        $app['menu.repository']->save($menu);
        
        return $app->redirect('menu');
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
    
        return $app->redirect('/menu');
    }
    
    /**
     * @param Request $request
     * @param Application $app
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function editar(Request $request, Application $app)
    {
        $menu = $app['menu.repository']->find($request->get('id'));

        $menu->setNome($request->get('nome'));
        $menu->setDescricao($request->get('descricao'));
        $menu->setUrl($request->get('url'));
        $menu->setIcon($request->get('icone'));

        $app['menu.repository']->save($menu);
    
       return $app->redirect('menu');
    }
}