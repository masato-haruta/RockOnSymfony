<?php

namespace Rock\OnSymfony\HttpPageFlowBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class RockOnSymfonyHttpPageFlowExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
        $loader->load('types.xml');
        $loader->load('filters.xml');

		if($container->getParameter('kernel.debug'))
		{
			$loader->load('debug.xml');
		}
    }
	/**
	 *
	 */
	public function getAlias()
	{
		return 'rock_on_symfony_http_page_flow';
	}
}
