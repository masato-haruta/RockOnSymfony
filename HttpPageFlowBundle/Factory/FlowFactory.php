<?php
/****
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
 ****/
namespace Rock\OnSymfony\HttpPageFlowBundle\Factory;
// <Base>
use Rock\Components\Http\Flow\Factory\Factory;

// <Use>
use Symfony\Component\DependencyInjection\ContainerInterface;


class FlowFactory extends Factory
{
	protected $container;
	//public function __construct(ISessionManager $manager = null)
	public function __construct(ContainerInterface $container)
	{
		//parent::__construct($manager);
		parent::__construct($container->get('rock.page_flow.session_manager'));
		
		$this->container = $container;
	}

	public function getEventDispatcher()
	{
		$class= $this->container->getParameter('rock.page_flow.event_dispatcher.class');

		return new $class();
	}
	public function create($name)
	{
		$flow = parent::create($name);

		$flow->setEventDispatcher($this->getEventDispatcher());

		return $flow;
	}
}

