<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 19/09/16
 * Time: 13:51
 */

use Symfony\Component\Console;
use Doctrine\DBAL\Migrations\MigrationsVersion;
use Doctrine\DBAL\Migrations\Tools\Console\Command as MigrationsCommand;

require __DIR__ . '/../vendor/autoload.php';

chdir(__DIR__ . '/../bin');

$cli = new Console\Application('Doctrine Migrations', MigrationsVersion::VERSION());
$cli->setCatchExceptions(true);

$helperSet = require __DIR__ . '/../app/cli-config.php';
$helperSet->set(new Console\Helper\DescriptorHelper(), 'dialog');
$cli->setHelperSet($helperSet);

// Adiciona
$commands = [];
$commands[] = new MigrationsCommand\ExecuteCommand();
$commands[] = new MigrationsCommand\GenerateCommand();
$commands[] = new MigrationsCommand\LatestCommand();
$commands[] = new MigrationsCommand\MigrateCommand();
$commands[] = new MigrationsCommand\StatusCommand();
$commands[] = new MigrationsCommand\VersionCommand();
$commands[] = new MigrationsCommand\DiffCommand();
$cli->addCommands($commands);
// Run!
$cli->run();