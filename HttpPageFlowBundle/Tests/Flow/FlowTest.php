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
namespace Rock\OnSymfony\HttpPageFlowBundle\Tests\Flow;

// <Use> : PHPUnit Test
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
// @use
use Rock\OnSymfony\HttpPageFlowBundle\Definition\Container as FlowContainer;

class FlowTest extends WebTestCase
{
	public function testFlow()
	{
		$client    = static::createClient();
		$container = $client->getContainer();

		$flowContainer = $this->getFlowContainer($container);

		$flow = $flowContainer->getByAlias('Default');
		// Instance should be always created, so diff 
		$flow2 = $flowContainer->getByAlias('Default');
		$this->assertTrue($flow !== $flow2, 'Assert Instance Dif');

		// count $flow pages
		$this->assertTrue($flow->count() === 0, 'Assert Flow Size');
	}
	protected function getFlowContainer($container)
	{
		$builder = $container->get('rock.page_flow.component_builder');
		$builder->setEventDispatcher($container->get('rock.page_flow.event_dispatcher'));
		$flowContainer = $container->get('rock.page_flow.container');
		$this->assertTrue($flowContainer instanceof FlowContainer, 'Assert FlowContainer');

		return $flowContainer;
	}
}
