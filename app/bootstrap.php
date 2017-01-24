<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 19/09/16
 * Time: 14:08
 */

//AutoLoader do Composer
$loader = require __DIR__.'/../vendor/autoload.php';
//vamos adicionar nossas classes ao AutoLoader
$loader->add('blog', __DIR__.'/src');

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
//se for falso usa o APC como cache, se for true usa cache em arrays
$isDevMode = false;
//caminho das entidades
$paths = array(__DIR__ . '/../src/Api/Entities',
    __DIR__ . '/../src/App/Entities');
// configurações do banco de dados
$dbParams = array(
    'driver' => 'pdo_mysql',
    'dbname' => 'blog',
    'user' => 'root',
    'password' => '',
    'host' => 'mysql',
);
$config = Setup::createConfiguration($isDevMode);
//$config->setResultCacheImpl(new \Doctrine\Common\Cache\MemcacheCache());
//$config->setMetadataCacheImpl(new \Doctrine\Common\Cache\MemcacheCache());
//leitor das annotations das entidades
$driver = new AnnotationDriver(new AnnotationReader(), $paths);
$config->setMetadataDriverImpl($driver);
//registra as annotations do Doctrine
AnnotationRegistry::registerFile(__DIR__ . '/../vendor/doctrine/orm/lib/Doctrine/ORM/Mapping/Driver/DoctrineAnnotations.php');

$cache = new \Doctrine\Common\Cache\MemcacheCache();
$cacheRegionConfiguration = new \Doctrine\ORM\Cache\RegionsConfiguration();
$factory = new \Doctrine\ORM\Cache\DefaultCacheFactory($cacheRegionConfiguration, $cache);
$config->setSecondLevelCacheEnabled();
$config->getSecondLevelCacheConfiguration()->setCacheFactory($factory);

//cria o entityManager
$entityManager = EntityManager::create($dbParams, $config);
/*
$evm = $entityManager->getEventManager();
$entitySubscriber = new DoctrineNaPratica\Model\Subscriber\EntitySubscriber;
$evm->addEventSubscriber($entitySubscriber);*/