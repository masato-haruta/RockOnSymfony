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
namespace Rock\OnSymfony\HttpPageFlowBundle\Builder;

// <Use> : Symfony Service Container 
use Symfony\Component\DependencyInjection\ContainerInterface;
// <Use> : PageFlow Component
use Rock\Components\Http\Flow\Builder\Builder as BaseBuilder;
// <Use> : Flow Factory
use Rock\Components\Flow\Factory\IFactory as IFlowFactory;

/**
 *
 */
class FlowBuilder extends BaseBuilder
{
	protected $container;
	public function __construct(IFlowFactory $factory)
	{
		//
		parent::__construct($factory);
	}


	public function build($name)
	{
		$flow  = parent::build($name);

		// Set EventDispatcher
		//if($flow)
		//	$flow->setEventDispatcher(('rock.page_flow.event_dispatcher'));
		return $flow;
	}
}
