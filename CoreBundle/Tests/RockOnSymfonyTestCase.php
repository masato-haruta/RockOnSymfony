<?php
/************************************************************************************
 *
 * Description:
 *      
 * $Id$
 * $Date$
 * $Rev$
 * $Author$
 * 
 *  This file is part of the $Project$ package.
 *
 * $Copyrights$
 *
 ************************************************************************************/
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
