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

// <Use> : PHPUnit Test
use \PHPUnit_Framework_TestCase as TestCase;

class RockTests extends TestCase
{

	public function testLoader()
	{

		$rockBaseDir  = __DIR__.'/../../../Components';
		$loaderFile   = $rockBaseDir.'/Core/Loader/PackageLoader.php';
		if(!file_exists($loaderFile))
		{
			throw new \Exception(sprintf('File "%s" is not exist or unreadable.', $loaderFile));
		}
		require_once($loaderFile);

		$loader  = new Rock\Components\Core\Loader\PackageLoader();

		$loader->setNamespacePrefix('Rock\\Components');
		$loader->loadPackageFile($rockBaseDir.'/all.packages');

		$loader->register();


		$this->assertTrue(class_exists('Rock\\Components\\Flow\\GraphFlow'), 'Loaded Component Flow');
	}
}
