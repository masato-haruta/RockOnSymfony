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

namespace Rock\OnSymfony\HttpPageFlowBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

use Rock\Components\Flow\Factory\IFactory;
class DemoControllerTest extends WebTestCase
{
	public function testIndex()
	{
		echo "testIndex \n";
		$client  = static::createClient();
		$crawler = $client->request('GET', '/demo/flow');

		$this->assertTrue($crawler->filter('html:contains("next")')->count() == 0, 'next is not 0');

	}

	public function testContainer()
	{
		$client    = static::createClient();
		$container = $client->getContainer();
		$factory   = $container->get('rock.page_flow.factory');

		$this->assertTrue($factory instanceof IFactory, 'Factory');
	}
}
