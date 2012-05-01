<?php

$_SERVER['SYMFONY'] = '/var/www/html/projects/dev/symfony/2.0/Rock/vendor/symfony/src';
$_SERVER['APP']     = '/var/www/html/projects/dev/symfony/2.0/Rock/app';

//
require_once $_SERVER['SYMFONY'].'/Symfony/Component/ClassLoader/UniversalClassLoader.php';

require_once $_SERVER['APP'].'/autoload.php';

//spl_autoload_register(function($class)
//{
//    if (0 === strpos($class, 'Rock\\OnSymfony\\') &&
//        file_exists($file = __DIR__.'/../../'.implode('/', array_slice(explode('\\', $class), 3)).'.php')) {
//        require_once $file;
//    }
//});

require_once __DIR__.'/../../../Component/autoload.php';
