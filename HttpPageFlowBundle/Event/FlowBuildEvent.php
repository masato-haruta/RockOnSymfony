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
// @namespace
namespace Rock\OnSymfony\HttpPageFlowBundle\Event;
// @extend
use Symfony\Component\EventDispatcher\Event;
// @use
use Rock\Component\Flow\Builder\IFlowBuilder;

/** 
 *
 */
class FlowBuildEvent extends Event
  implements
    IConstructEvent
{
	/**
	 *
	 */
	protected $builder;

	/**
	 *
	 */
	public function __construct(IFlowBuilder $builder)
	{
		$this->builder  = $builder;
	}
	/**
	 *
	 */
	public function getBuilder()
	{
		return $this->builder;
	}
}
