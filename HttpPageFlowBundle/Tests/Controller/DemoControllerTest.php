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

class DemoControllerTest extends WebTestCase
{
	public function testIndex()
	{
		$client  = static::createClient();
		$crawler = $client->request('GET', '/demo/flow');

		$this->assertTrue($crawler->filter('html:contains("next")')->count() > 0);
	}
}
