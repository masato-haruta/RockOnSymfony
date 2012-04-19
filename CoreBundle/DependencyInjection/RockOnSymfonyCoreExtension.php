<?php

namespace Rock\OnSymfony\CoreBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
// <Use> : Class Loader
use Symfony\Component\ClassLoader\UniversalClassLoader;
/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class RockOnSymfonyCoreExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        //$loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        //$loader->load('services.xml');


		foreach($configs as $sub)
			$config = array_merge($config, $sub);

		// Autoload Rock\Components
		if(array_key_exists('directory', $config))
			$dir = $config['directory'];
		if($dir)
		    $this->registRockComponents($dir);
		else
			throw new \Exception('Rock Components directory is not specified. Plz config "rock_on_symfony_core:directory" on your config.yml.');
    }

	protected function registRockComponents($rockBaseDir)
	{
		$loader = new UniversalClassLoader();
		$loader->registerNamespace('Rock\\Components', $rockBaseDir);

		$loader->register();
	}

}
