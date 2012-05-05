<?php
/****
 *
 * Description:
 *      
 * 
 * $Date$
 * Rev    : see git
 * Author : Yoshi Aoki <yoshi@44services.jp>
 * 
 *  This file is part of the Rock package.
 *
 * For the full copyright and license information, 
 * please read the LICENSE file that is distributed with the source code.
 *
 ****/

namespace Rock\OnSymfony\CoreBundle\Tests;

// <Use> : PHPUnit Test
use \PHPUnit_Framework_TestCase as TestCase;

class RockOnSymfonyTestCase extends TestCase
{

	protected function loadComponent()
	{
		$rockBaseDir  = __DIR__.'/../../../Component/src';
		$loaderFile   = $rockBaseDir.'/Core/Loader/PackageLoader.php';
		if(!file_exists($loaderFile))
		{
			throw new \Exception(sprintf('File "%s" is not exist or unreadable.', $loaderFile));
		}
		require_once($loaderFile);

		$loader  = new Rock\Component\Core\Loader\PackageLoader();

		$loader->setNamespacePrefix('Rock\\Component');
		$loader->loadPackageFile($rockBaseDir.'/all.packages');

		$loader->register();

		$this->assertTrue(class_exists('Rock\\Component\\Flow\\GraphFlow'), 'Loaded Component Flow');
	}
}
