<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 27/10/16
 * Time: 09:54
 */

$app->get('admin/musicas/add', function() use ($app){
    
    $categorias = $app['categoria.repository']->findBy(['ativo' => true], ['nome' => 'ASC']);
    return $app['twig']->render('/admin/musica_add.html.twig', ['categorias' => $categorias]);
    
})->bind('musicas_add');

$app->get('admin/musicas/edit/{id}', function($id) use ($app){
    
    $musica = $app['musica.repository']->find($id);
    $categorias = $app['categoria.repository']->findBy(['ativo' => true], ['nome' => 'ASC']);
    return $app['twig']->render('/admin/musica_editar.html.twig', ['musica' => $musica, 'categorias' => $categorias]);
    
})->bind('musicas_edit');

$app->get('admin/musicas/grid', function() use ($app){
    
    $categoria = $app['categoria.repository']->findAll();
    $musicas = $app['musica.repository']->findBy(['categoria' => $categoria], ['numero' => 'ASC']);
    
    return $app['twig']->render('/admin/musicas.html.twig', ['musicas' => $musicas, 'categorias' => $categoria]);
    
})->bind('musicas_grid');

$app->get('admin/musicas/grid/{categoriaId}/{nome}', function($categoriaId, $nome) use ($app){
    
    $categoria = $app['categoria.repository']->find($categoriaId);
    $categorias = $app['categoria.repository']->findBy([], ['nome' => 'ASC']);
    $musicas = $app['musica.repository']->findBy(['categoria' => $categoria, 'ativo' => true]);
    
    return $app['twig']->render('/admin/musicas.html.twig', ['musicas' => $musicas, 'categorias' => $categorias]);
    
})->bind('categoria_musicas_grid');

$app->post('admin/musica/letra/editar', function(\Symfony\Component\HttpFoundation\Request $request) use ($app) {
    
    /**
     * @var \Api\Entities\Musica $musica
     */
    $musica = $app['musica.repository']->find($request->get('id'));
    
    $musica->setLetra(strip_tags($request->get('letra')));
    $musica->setLetraOriginal($request->get('letra'));
    
    $app['musica.repository']->save($musica);
    
    $app['log.controller']->criar('editou musica '.$musica->getNome());
    
    $app['session']->getFlashBag()->add('mensagem', 'Musica editada com sucesso.');
    
    if ($request->get('rota') == 'edicao_usuario') {
        return $app->redirect('/user/musicas/' . $musica->getCategoria()->getId());
    }
    
    if ($request->get('rota') == 'edicao_letra') {
        return $app->redirect('/user/musica/anexos/' . $musica->getId());
    }
    
    if ($app['security.authorization_checker']->isGranted('ROLE_USER')) {
        return $app->redirect('/user/musica/anexos/' . $musica->getId());
    }
    
    return $app->redirect('/admin/musicas/grid');
    
})->bind('musica_letra_editar');

$app->post('admin/musica/save', function(\Symfony\Component\HttpFoundation\Request $request) use ($app) {
    
    if ($request->get('id')) {
        /**
         * @var \Api\Entities\Musica $musica
         */
        $musica = $app['musica.repository']->find($request->get('id'));
        
        if ($request->get('nome')) {
            $musica->setNome($request->get('nome'));
            $musica->setNumero($request->get('numero'));
            $musica->setTom($request->get('tonalidade'));
        }
        
        if ($request->get('letra')) {
            $musica->setLetra(strip_tags($request->get('letra')));
            $musica->setLetraOriginal($request->get('letra'));
        }
        
        if ($request->get('categoria')) {
            /**
             * @var \Api\Entities\Categoria $categoria
             */
            $categoria = $app['categoria.repository']->find($request->get('categoria'));
            $musica->setCategoria($categoria);
        }
        
        $app['musica.repository']->save($musica);
        
        $app['log.controller']->criar('editou musica '.$musica->getNome());
        
        $app['session']->getFlashBag()->add('mensagem', 'Musica editada com sucesso.');
        
        if ($request->get('rota') == 'edicao_usuario') {
            return $app->redirect('/user/musica/anexos/' . $musica->getId());
        }
        
        if ($request->get('rota') == 'edicao_letra') {
            return $app->redirect('/user/musica/anexos/' . $musica->getId());
        }
        
        return $app->redirect('/admin/musicas/grid');
    }
    
    $musica = new \Api\Entities\Musica();
    /**
     * @var \Api\Entities\Categoria $categoria
     */
    $categoria = $app['categoria.repository']->find($request->get('categoria'));
    $user = $app['session']->get('user');
    /**
     * @var \Api\Entities\Usuarios $usuario
     */
    $usuario = $app['usuarios.repository']->find($user->getId());
    
    $musica->setNome($request->get('nome'));
    $musica->setNumero($request->get('numero') ?: null);
    $musica->setTom($request->get('tonalidade'));
    
    if ($request->get('letra')) {
        $musica->setLetra(strip_tags($request->get('letra')));
        $musica->setLetraOriginal($request->get('letra'));
    }
    $musica->setCategoria($categoria);
    $musica->setUsuario($usuario);
    $musica->setCadastro(new \DateTime('now'));
    $musica->setNovo(false);
    if ($request->get('novo')) {
        $musica->setNovo($request->get('novo'));
    }
    $musica->setAtivo(true);
    
    $app['musica.repository']->save($musica);
    
    $app['log.controller']->criar('adicionou nova musica '.$musica->getNome());
    
    $app['session']->getFlashBag()->add('mensagem', 'Musica adicionada com sucesso.');
    
    if ($app['security.authorization_checker']->isGranted('ROLE_USER')) {
        return $app->redirect('/user/musicas/'.$categoria->getId());
    }
    
    return $app->redirect('/admin/musicas/anexos/grid/'.$musica->getId().'/'.$musica->getNome());
    
})->bind('save_musica');
