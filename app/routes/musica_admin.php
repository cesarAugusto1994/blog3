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



