<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 30/07/16
 * Time: 09:20
 */

$app['index.controller'] = function() use ($app) {
  return new \Api\Controllers\IndexController();
};

$app['post.controller'] = function() use ($app) {
  return new \Api\Controllers\PostController();
};

$app['tag.controller'] = function() use ($app) {
  return new \Api\Controllers\TagsController();
};

$app['menu.controller'] = function () use($app) {
  return new \App\Controllers\MenuController();
};

$app['usuarios.controller'] = function() use ($app) {
  return new \Api\Controllers\UsuariosController();
};

$app['config.controller'] = function () use($app) {
  return new \App\Controllers\ConfigController();
};

$app['categoria.controller'] = function () use($app) {
  return new \Api\Controllers\CategoriaController();
};

$app['colecao.controller'] = function () use($app) {
  return new \Api\Controllers\ColecaoController();
};

$app['musica.controller'] = function () use($app) {
  return new \Api\Controllers\MusicaController();
};

$app['musica.anexos.controller'] = function () use($app) {
  return new \Api\Controllers\MusicaAnexosController();
};

$app['tipo.anexo.controller'] = function () use($app) {
  return new \Api\Controllers\MusicaAnexosController();
};

$app['pager.Controller'] = function () {
  return new \App\Controllers\PagerController();
};

/**
 * Repository
 */

$app['menu.repository'] = function () use($app) {
  return $app['orm.em']->getRepository(\App\Entities\Menu::class);
};

$app['config.repository'] = function () use($app) {
  return $app['orm.em']->getRepository(\App\Entities\Config::class);
};

$app['menus'] = function () use ($app) {
  return $app['menu.repository']->findAll();
};

$app['config'] = function () use ($app) {
  return $app['config.controller']->index($app);
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


$app['nome.blog'] = function() use ($app){
  
  $blog = $app['config.repository']->find(1);
  
  if ($blog) {
    return $blog->getNome();
  }
  return 'Blog';
};

$app['about'] = function () {
  return 'Aenean placerat. In vulputate urna eu arcu. Aliquam erat volutpat. Suspendisse potenti. Morbi mattis felis at nunc. Duis viverra diam non justo. In nisl.';
};

$app['tonalidades'] = function () {
  return [
      'C',
      'C#',
      'Db',
      'D',
      'D#',
      'Eb',
      'E',
      'F',
      'F#',
      'Gb',
      'G',
      'G#',
      'Ab',
      'A',
      'A#',
      'Bb',
      'B',
  ];
};

$app['label.sorted'] = function () {
  $colors = ['danger', 'primary', 'default', 'warning', 'success'];
  shuffle($colors);
  foreach ($colors as $key => $color) {
    return $colors[$key];
  }
};

$app['default.card'] = function() use ($app) {
  $default = $app['config.repository']->find(1);
  if (!empty($default->getBackground())) {
    return 'assets/blog/img/config/'.$default->getBackground();
  }
  return 'assets/blog/img/wallpaper.jpg';
};


$app['background.default'] = 'assets/blog/img/wallpaper.jpg';
$app['background.post.default'] = 'assets/blog/img/wallpaper.jpg';

$app['background'] = function() {
  return [
    'Background-4.jpg',
    'Background-5.jpg',
    'background-1247931_960_720.jpg',
    'html-color-codes-color-tutorials-hero-00e10b1f.jpg',
    'prism.jpg',
    'White-Background-BD1.png',
  ];
};

/**
 * @return \Symfony\Component\HttpFoundation\Response|static
 */
$app['recents.posts'] = function() use ($app) {
    return \Symfony\Component\HttpFoundation\JsonResponse::create($app['posts.repository']->getMostRecents());
};

/**
 * @return mixed
 */
$app['categories'] = function() use ($app) {
  return $app['tags.repository']->findAll();
};

/***********************************************
 *  API
 **********************************************/

/**
 * @return mixed
 */
$app['posts.repository'] = function () use ($app) {
  return $app['orm.em']->getRepository(\Api\Entities\Posts::class);
};

/**
 * @return mixed
 */
$app['tags.repository'] = function () use ($app) {
  return $app['orm.em']->getRepository(\Api\Entities\Tags::class);
};

/**
 * @return mixed
 */
$app['posts.links.repository'] = function () use ($app) {
  return $app['orm.em']->getRepository(\Api\Entities\LinksPosts::class);
};

/**
 * @return mixed
 */
$app['musica.repository'] = function () use ($app) {
  return $app['orm.em']->getRepository(\Api\Entities\Musica::class);
};

/**
 * @return mixed
 */
$app['musica.anexos.repository'] = function () use ($app) {
  return $app['orm.em']->getRepository(\Api\Entities\MusicaAnexos::class);
};

$app['musica.tags.repository'] = function () use ($app) {
  return $app['orm.em']->getRepository(\Api\Entities\MusicaTags::class);
};

$app['musica.anexo.tags.repository'] = function () use ($app) {
  return $app['orm.em']->getRepository(\Api\Entities\AnexoTags::class);
};

$app['tag.repository'] = function () use ($app) {
  return $app['orm.em']->getRepository(\Api\Entities\Tag::class);
};

/**
 * @return mixed
 */
$app['tipo.anexo.repository'] = function () use ($app) {
  return $app['orm.em']->getRepository(\Api\Entities\Tipo::class);
};

/**
 * @return array
 */
$app['posts.history'] = function () use ($app) {
  return array_map(function($archive){
     $archive['month'] = DateTime::createFromFormat('m', $archive['month']);
    return $archive;
  }, $app['posts.repository']->getMonthHistory());
};

/**
 * @return mixed
 */
$app['usuarios.repository'] = function () use ($app) {
  return $app['orm.em']->getRepository(\Api\Entities\Usuarios::class);
};

/**
 * @return mixed
 */
$app['colecao.repository'] = function () use ($app) {
  return $app['orm.em']->getRepository(\Api\Entities\Colecao::class);
};

/**
 * @return mixed
 */
$app['categoria.repository'] = function () use ($app) {
  return $app['orm.em']->getRepository(\Api\Entities\Categoria::class);
};

/**
 * @return mixed
 */
$app['widgets.repository'] = function () use ($app) {
  return $app['orm.em']->getRepository(\App\Entities\Widgets::class);
};

/**
 * @return \App\Controllers\WidgetsController
 */
$app['widgets.controller'] = function () use($app) {
  return new \App\Controllers\WidgetsController();
};

/**
 * @return mixed
 */
$app['widgets'] = function () use($app) {
  return $app['widgets.controller']->getAll($app);
};

