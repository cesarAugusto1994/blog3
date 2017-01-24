<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 19/09/16
 * Time: 16:57
 */

include __DIR__ . '/../app/bootstrap.php';
include __DIR__ . '/../app/cli-config.php';

use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use App\Model\Fixtures\Config as FixtureConfig;
use App\Model\Fixtures\Menu as FixtureMenu;
use App\Model\Fixtures\Usuarios as FixtureUser;
use App\Model\Fixtures\Tipos as FixtureTipo;

$loader = new Loader();
//também podemos carregar todos os fixtures do diretório indicado
// $loader->loadFromDirectory(__DIR__ . '/src/DoctrineNaPratica/Model/Fixture');
$loader->addFixture(new FixtureConfig());
$loader->addFixture(new FixtureMenu());
$loader->addFixture(new FixtureUser());
$loader->addFixture(new FixtureTipo());
$purger = new ORMPurger();
$executor = new ORMExecutor($entityManager, $purger);
$executor->execute($loader->getFixtures(), false);