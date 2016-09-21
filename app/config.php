<?php
/**
 * Created by PhpStorm.
 * User: cesar
 * Date: 21/09/16
 * Time: 09:24
 */

#if (getenv('REMOTE_ADDR') == '127.0.0.1') {
    define('DB_DRIVER', 'pdo_mysql');
    define('DB_HOST', '127.0.0.1');
    define('DB_USER', 'root');
    define('DB_PASSWORD', 'mestre');
    define('DB_NAME', 'blog');
#}

/*
define('DB_DRIVER', getenv('DB_DRIVER') ?: 'pdo_mysql');
define('DB_HOST', getenv('DB_HOST') ?: '127.0.0.1');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASSWORD', getenv('DB_PASSWORD') ?: 'mestre');
define('DB_NAME', getenv('DB_NAME') ?: 'blog');
*/