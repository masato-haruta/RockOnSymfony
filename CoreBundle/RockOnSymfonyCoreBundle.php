<?php

namespace Rock\OnSymfony\CoreBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
// <Use> : DI Container Builder
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 *
 */
class RockOnSymfonyCoreBundle extends Bundle
{
	public function boot()
	{
		$this->registRockComponents($this->container);
	}
	protected function registRockComponents(ContainerInterface $container)
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
