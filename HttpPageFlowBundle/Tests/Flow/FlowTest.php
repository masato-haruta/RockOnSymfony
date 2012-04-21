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
namespace Rock\OnSymfony\HttpPageFlowBundle\Test\Flow;

// <Use> : PHPUnit Test
use \PHPUnit_Framework_TestCase as TestCase;

class FlowTest extends TestCase
{
	public function testRegist()
	{
		printf('Test : testRegist');
		$this->assertTrue(class_exists('Rock\\Components\Flow\Flow'), 'Rock Flow class is not registed.');
	}
}
