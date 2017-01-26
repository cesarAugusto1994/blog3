<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 22/08/16
 * Time: 09:31
 */

$menu = $app['controllers_factory'];

$menu->get('menus', function () use ($app) {
    $menu = $app['menu.repository']->findBy(['ativo' => true]);
    return new \Symfony\Component\HttpFoundation\JsonResponse($menu);
})->bind('api_menu_2');

return $menu;