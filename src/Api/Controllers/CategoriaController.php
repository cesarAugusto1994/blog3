<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 05/09/16
 * Time: 09:28
 */

namespace Api\Controllers;


use Silex\Application;

class CategoriaController
{
    public function index(Application $app)
    {
        return $app['twig']->render('admin/categorias.html.twig', ['categorias' => $app['categoria.repository']->findAll()]);
    }
    
    public function novo()
    {
        
    }
    
    public function editar()
    {
        
    }
    
    public function alteraStatus()
    {
        
    }
}