<?php

$_SERVER['SYMFONY'] = '/var/www/html/projects/dev/symfony/2.0/Rock/vendor/symfony/src';
require_once $_SERVER['SYMFONY'].'/Symfony/Component/ClassLoader/UniversalClassLoader.php';

$loader = new Symfony\Component\ClassLoader\UniversalClassLoader();
$loader->registerNamespace('Symfony', $_SERVER['SYMFONY']);
$loader->registerNamespace('Rock\\OnSymfony', __DIR__.'/../../../');
$loader->register();

//spl_autoload_register(function($class)
//{
//    if (0 === strpos($class, 'Rock\\OnSymfony\\') &&
//        file_exists($file = __DIR__.'/../../'.implode('/', array_slice(explode('\\', $class), 3)).'.php')) {
//        require_once $file;
//    }
//});

require_once __DIR__.'/../../../Components/Core/Loader/PackageLoader.php';
$loader = new Rock\Components\Core\Loader\PackageLoader();
$loader->loadPackageFile('.package');
