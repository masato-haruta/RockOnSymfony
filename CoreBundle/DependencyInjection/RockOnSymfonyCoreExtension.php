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


		$dir = $config['directory'];
		$container->setParameter('rock.core.dir', $dir);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

		
		$container->compile();	
		// Autoload Rock\Components
		$this->registRockComponents($container);
    }

	protected function registRockComponents(ContainerBuilder $container)
	{
		$loaderFile  = $container->getParameter('rock.packages.loader.location');
		if(!file_exists($loaderFile))
		{
			throw new \Exception(sprintf('File "%s" is not exist or unreadable.', $loaderFile));
		}
		require_once($loaderFile);

		$loader  = new \Rock\Components\Core\Loader\PackageLoader();

		$loader->setNamespacePrefix('Rock\\Components');
		$loader->loadPackageFile($container->getParameter('rock.packages.defaults'));

		$loader->register();


		if(!class_exists('\\Rock\\Components\\Core\\Rock'))
			throw new \Exception('Failed to regist');
	}

}
