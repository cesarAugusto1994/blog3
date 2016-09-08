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

$app['pager.Controller'] = function () {
  return new \App\Controllers\PagerController();
};

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

$app['about'] = function () {
  return 'Aenean placerat. In vulputate urna eu arcu. Aliquam erat volutpat. Suspendisse potenti. Morbi mattis felis at nunc. Duis viverra diam non justo. In nisl.';
};

$app['label.sorted'] = function () {
  $colors = ['danger', 'primary', 'default', 'warning', 'success'];
  shuffle($colors);
  foreach ($colors as $key => $color) {
    return $colors[$key];
  }
};

$app['background.default'] = 'assets/blog/img/wallpaper.jpg';
$app['background.post.default'] = 'assets/blog/img/wallpaper.jpg';

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

