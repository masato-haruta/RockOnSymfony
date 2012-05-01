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
		$this->registRockComponent($this->container);
	}
	protected function registRockComponent(ContainerInterface $container)
	{
		$loaderFile  = $container->getParameter('rock.packages.loader.location');
		if(!file_exists($loaderFile))
		{
			throw new \Exception(sprintf('File "%s" is not exist or unreadable.', $loaderFile));
		}
		require_once($loaderFile);

		$loader  = new \Rock\Component\Core\Loader\PackageLoader();

		$loader->setNamespacePrefix('Rock\\Component');
		$loader->loadPackageFile($container->getParameter('rock.packages.defaults'));

		$loader->register();


		if(!class_exists('\\Rock\\Component\\Core\\Rock'))
			throw new \Exception('Failed to regist');
	}
}
