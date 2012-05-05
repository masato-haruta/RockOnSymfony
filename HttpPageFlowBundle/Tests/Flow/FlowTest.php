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

namespace Rock\OnSymfony\HttpPageFlowBundle\Tests\Flow;

// <Use> : PHPUnit Test
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
// @use
use Rock\OnSymfony\HttpPageFlowBundle\Definition\Container as FlowContainer;

// @use 
use Rock\Component\Http\Flow\Input\Input;
use Rock\Component\Flow\Output\IOutput;
use Rock\Component\Flow\Directions;

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

	public function testHandle()
	{
		$client    = static::createClient();
		$container = $client->getContainer();

		$flowContainer = $this->getFlowContainer($container);
		$flow      = $flowContainer->getByAlias('Demo');
		$flow->setSessionManager($container->get('rock.page_flow.session_manager'));
		// count $flow pages
		$this->assertTrue($flow->count() === 3, 'Assert Flow Size');

		$output  = $flow->handle(new Input(Directions::NEXT));

		$this->assertTrue($output instanceof IOutput, 'Assert Output Instance');

		$this->assertTrue($output->getTrail()->last()->current()->getName() === 'first', 'Assert State First');

		$output  = $flow->handle(new Input(Directions::NEXT), $output->getTraversal());
		$this->assertTrue($output instanceof IOutput, 'Assert Output Instance');

		$this->assertTrue($output->getTraversal()->getTrail()->count() === 3, sprintf('Assert Traversal Trail count is 3, but %d', $output->getTraversal()->getTrail()->count()));
		$this->assertTrue($output->getTrail()->last()->current()->getName() === 'second', 'Assert State Second');

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
