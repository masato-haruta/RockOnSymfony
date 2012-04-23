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
// <Use> : Type
use Rock\OnSymfony\HttpPageFlowBundle\Type\DefaultType;


class FlowFactory extends Factory
{
	/**
	 *
	 */
	protected $container;

	/**
	 *
	 */
	public function __construct(ContainerInterface $container)
	{
		//parent::__construct($manager);
		parent::__construct($container->get('rock.page_flow.session_manager'));
		
		$this->container = $container;
	}

	protected function init()
	{
		$this->defaultType  = new DefaultType();
	}
	/**
	 *
	 */
	public function getEventDispatcher()
	{
		return $this->container->get('rock.page_flow.event_dispatcher');
	}
	/**
	 *
	 */
	public function create($name)
	{
		$flow = parent::create($name);
		
		$flow->setEventDispatcher($this->getEventDispatcher());

		return $flow;
	}
}

