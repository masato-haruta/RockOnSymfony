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
// <Namespace> 
namespace Rock\OnSymfony\HttpPageFlowBundle\Event;

//
use Rock\Components\Flow\IFlow;
use Rock\Components\Flow\State\IFlowState;
/**
 *
 */
class HandleFlowWithStateEvent extends HandleFlowEvent
{
	protected $state;

	public function __construct(IFlow $flow, IFlowState $state)
	{
		parent::__construct($flow);

		$this->state  = $state;
	}

	public function getState()
	{
		return $this->state;
	}
}
