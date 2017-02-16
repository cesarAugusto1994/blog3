<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 22/08/16
 * Time: 09:31
 */

$menu = $app['controllers_factory'];

$menu->get('menus', function () use ($app) {

    if (!empty($app['session']->get('menus'))) {
        return new \Symfony\Component\HttpFoundation\JsonResponse($app['session']->get('menus'));
    }

    $menu = $app['menu.repository']->findBy(['ativo' => true]);
    $app['session']->set('menus', $menu);

    return new \Symfony\Component\HttpFoundation\JsonResponse($menu);

})->bind('api_menu');

$menu->get('blog', function () use ($app) {
    return $app['twig']->render('admin/blog_config.html.twig');
})->bind('blog');

$menu->post('blog', function (\Symfony\Component\HttpFoundation\Request $request) use ($app) {
    
    if ($request->get('id')) {

        /**
         * @var \App\Entities\Config $config
         */
        $config = $app['config.repository']->find($request->get('id'));

        if  (!empty($request->get('nome'))) {
            $config->setNome($request->get('nome'));
        }

        $config->setSubtitulo($request->get('subtitulo'));

        if (!empty($_FILES['background']['size'])) {
            $config->setBackground($app['upload.service']->upload($_FILES['background'], 'config', $config->getBackground()));
        }

        $app['config.repository']->save($config);

        return $app->redirect('/admin/blog');
    }
    
    $config = new \App\Entities\Config();

    $config->setNome($request->get('nome'));
    $config->setSubtitulo($request->get('subtitulo'));

    if (!empty($_FILES['background']['size'])) {
        $config->setBackground($app['upload.service']->upload($_FILES['background'], 'config', $config->getBackground()));
    }

    $config->setEnviaEmail(false);
    $app['config.repository']->save($config);

    return $app->redirect('/admin/blog');
    
})->bind('blog_settings_save');

$menu->get('menu', function() use ($app) {

    return $app->redirect('/admin/blog');

})->bind('menu');

$menu->post('admin/menu/save', function(\Symfony\Component\HttpFoundation\Request $request) use ($app) {
    
    if($request->get('id')) {
        /**
         * @var \App\Entities\Menu $menu
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
            $menu->setIcon($app['upload.service']->upload($_FILES['icone'], 'menu', $menu->getIcon()));
        }

        $app['db']->beginTransaction();
        $app['menu.repository']->save($menu);
        $app['db']->commit();

        $app['session']->getFlashBag()->add('mensagem', 'Menu alterado com sucesso.');

        return $app->redirect('/admin/blog');
    }

    $menu = new \App\Entities\Menu();

    $menu->setNome($request->get('nome'));
    $menu->setDescricao($request->get('descricao'));
    $menu->setUrl($request->get('url'));

    if (!empty($_FILES['icone']['size'])) {
        $menu->setIcon($app['upload.service']->upload($_FILES['icone'], 'menu', $menu->getIcon()));
    }

    $menu->setCadastro(new \DateTime('now'));
    $menu->setPrevilegioRequerido(false);
    $menu->setAtivo(true);

    $app['menu.repository']->save($menu);

    return $app->redirect('/admin/menu#menu');
    
})->bind('save_menu');

$menu->get('menu/status/{id}', function($id) use ($app) {

    $menu = $app['menu.repository']->find($id);

    if ($menu->isAtivo()) {
        $menu->setAtivo(false);
    } else {
        $menu->setAtivo(true);
    }

    $app['menu.repository']->save($menu);

    return $app->redirect('/admin/menu#menu');

})->bind('alterar_suatus_menu');

return $menu;