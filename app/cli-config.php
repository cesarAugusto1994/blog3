<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 19/09/16
 * Time: 13:57
 */

require_once 'bootstrap.php';

$helperSet = new \Symfony\Component\Console\Helper\HelperSet(array(
    'db' => new \Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($entityManager->getConnection()),
    'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($entityManager)
));
return $helperSet;