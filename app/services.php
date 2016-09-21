<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 30/07/16
 * Time: 09:20
 */

#################################################################################################
#################################################################################################
#  Controllers
#################################################################################################
#################################################################################################

$app['index.controller'] = function() use ($app) { return new \Api\Controllers\IndexController();};
$app['post.controller'] = function() use ($app) { return new \Api\Controllers\PostController();};
$app['tag.controller'] = function() use ($app) { return new \Api\Controllers\TagsController();};
$app['menu.controller'] = function () use($app) { return new \App\Controllers\MenuController();};
$app['usuarios.controller'] = function() use ($app) { return new \Api\Controllers\UsuariosController();};
$app['config.controller'] = function () use($app) { return new \App\Controllers\ConfigController();};
$app['categoria.controller'] = function () use($app) { return new \Api\Controllers\CategoriaController();};
$app['colecao.controller'] = function () use($app) { return new \Api\Controllers\ColecaoController();};
$app['musica.controller'] = function () use($app) { return new \Api\Controllers\MusicaController();};
$app['musica.anexos.controller'] = function () use($app) { return new \Api\Controllers\MusicaAnexosController();};
$app['tipo.anexo.controller'] = function () use($app) { return new \Api\Controllers\MusicaAnexosController();};
$app['pager.Controller'] = function () { return new \App\Controllers\PagerController();};
$app['widgets.controller'] = function () use($app) { return new \App\Controllers\WidgetsController();};

#################################################################################################
#################################################################################################
# Repositories
#################################################################################################
#################################################################################################

$app['menu.repository'] = function () use($app) { return $app['orm.em']->getRepository(\App\Entities\Menu::class);};
$app['config.repository'] = function () use($app) { return $app['orm.em']->getRepository(\App\Entities\Config::class);};
$app['posts.repository'] = function () use ($app) { return $app['orm.em']->getRepository(\Api\Entities\Posts::class);};
$app['tags.repository'] = function () use ($app) { return $app['orm.em']->getRepository(\Api\Entities\Tags::class);};
$app['posts.links.repository'] = function () use ($app) { return $app['orm.em']->getRepository(\Api\Entities\LinksPosts::class);};
$app['musica.repository'] = function () use ($app) { return $app['orm.em']->getRepository(\Api\Entities\Musica::class);};
$app['musica.anexos.repository'] = function () use ($app) { return $app['orm.em']->getRepository(\Api\Entities\MusicaAnexos::class);};
$app['musica.tags.repository'] = function () use ($app) { return $app['orm.em']->getRepository(\Api\Entities\MusicaTags::class);};
$app['musica.anexo.tags.repository'] = function () use ($app) { return $app['orm.em']->getRepository(\Api\Entities\AnexoTags::class);};
$app['tag.repository'] = function () use ($app) { return $app['orm.em']->getRepository(\Api\Entities\Tag::class);};
$app['tipo.anexo.repository'] = function () use ($app) { return $app['orm.em']->getRepository(\Api\Entities\Tipo::class);};
$app['usuarios.repository'] = function () use ($app) { return $app['orm.em']->getRepository(\Api\Entities\Usuarios::class);};
$app['colecao.repository'] = function () use ($app) { return $app['orm.em']->getRepository(\Api\Entities\Colecao::class);};
$app['categoria.repository'] = function () use ($app) { return $app['orm.em']->getRepository(\Api\Entities\Categoria::class);};
$app['widgets.repository'] = function () use ($app) { return $app['orm.em']->getRepository(\App\Entities\Widgets::class);};

#################################################################################################
#################################################################################################
# Things
#################################################################################################
#################################################################################################

$app['categories'] = function() use ($app) {return $app['tags.repository']->findAll();};
$app['menus'] = function () use ($app) { return $app['menu.repository']->findAll();};
$app['config'] = function () use ($app) { return $app['config.controller']->index($app);};
$app['widgets'] = function () use($app) { return $app['widgets.controller']->getAll($app); };

$app['nome.blog'] = function() use ($app){ $blog = $app['config.repository']->findAll(); return $blog[0] ? $blog[0]->getNome() : 'Blog'; };

$app['tonalidades'] = function () { return ['C', 'C#', 'Db', 'D', 'D#', 'Eb', 'E', 'F', 'F#', 'Gb', 'G', 'G#', 'Ab', 'A', 'A#', 'Bb', 'B',];};

$app['background.default'] = 'assets/blog/img/wallpaper.jpg';
$app['background.post.default'] = 'assets/blog/img/wallpaper.jpg';

$app['dir.base'] = function () {

  if($_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
    return '';
  }

  return '/web/';
};

$app['dir.img'] = function () use ($app){
  return $app['dir.base'].'assets/blog/img/config/';
};


$app['database.blog'] = function () {

  if ($_SERVER['REMOTE_ADDR'] == '127.0.0.1') {
    return [
        'dbname' => 'blog',
        'user' => 'root',
        'password' => 'mestre',
        'host' => 'localhost',
        'driver' => 'pdo_mysql',
    ];
  }
  return [
      'dbname' => 'bloggrupopolo',
      'user' => 'cezzaar',
      'password' => 'elpro1973',
      'host' => 'mysql796.umbler.com',
      'driver' => 'pdo_mysql',
  ];
};

$app['about'] = function () {
  return 'Aenean placerat. In vulputate urna eu arcu. Aliquam erat volutpat. Suspendisse potenti. Morbi mattis felis at nunc. Duis viverra diam non justo. In nisl.';
};

$app['default.card'] = function() use ($app) {
  $default = $app['config.repository']->findAll();
  if (!empty($default[0]->getBackground())) {
    return 'assets/blog/img/config/'. $default[0]->getBackground();
  }
  return 'assets/blog/img/wallpaper.jpg';
};