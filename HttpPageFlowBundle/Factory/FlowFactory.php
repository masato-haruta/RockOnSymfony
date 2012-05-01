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
use Rock\Component\Http\Flow\Factory\Factory;

// <Use>
use Symfony\Component\DependencyInjection\ContainerInterface;
// <Use> : Type
use Rock\OnSymfony\HttpPageFlowBundle\Type\DefaultType;
// <Use> : EventDispatcherInterface
use Symfony\Component\EventDispatcher\EventDispatcherInterface;


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
		
		$this->container    = $container;

		$this->builderClass = $container->hasParameter('rock.page_flow.defaults.builder.class') ? 
			$container->getParameter('rock.page_flow.defaults.builder.class') :
			'\\Rock\\OnSymfony\\HttpPageFlowBundle\\Builder\\Builder';
	}

	/**
	 *
	 */
	protected function init()
	{
		$this->defaultTypeClass  = '\\Rock\\OnSymfony\\HttpPageFlowBundle\\Type\\DefaultType'; 
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
		
		if($flow instanceof EventDispatcherInterface)
		{
			$flow->setEventDispatcher($this->getEventDispatcher());
		}

		return $flow;
	}

	/** 
	 *
	 */
	public function createBuilder($type = null)
	{
		$builder = parent::createBuilder($type);

		if($builder instanceof EventDispatcherInterface)
		{
			$builder->setEventDispatcher($this->getEventDispatcher());
		}
		return $builder;
	}
}

