<?php

define('ROOT', dirname(dirname(__FILE__)).'/');
define('CONFIG', ROOT.'config/');
define('INCLUDES', ROOT.'includes/');
define('LIB', ROOT.'lib/');
define('TPL', ROOT.'tpl/');

define('ADMIN_EMAIL', 'philfreo+bitcoin@gmail.com');

require INCLUDES.'funcs.php';

function __autoload($class) {
    require INCLUDES.$class.'.php';
}

$cache = Cache::getInstance();
$cache->setPrefix('Bitcoin::');

date_default_timezone_set('America/Los_Angeles');

