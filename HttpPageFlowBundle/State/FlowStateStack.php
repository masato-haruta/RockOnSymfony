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
namespace Rock\OnSymfony\HttpPageFlowBundle\State;
// <Interface>
use Rock\OnSymfony\HttpPageFlowBundle\State\IFlowStateStack;
// <Use> : Flow State
use Rock\Components\Flow\State\IFlowState;
/**
 *
 */
class FlowStateStack
  implements
    IFlowStateStack
{
	protected $states;
	
	public function __construct()
	{
		$this->states  = array();
	}
	public function top()
	{
		return $this->states[count($this->states) - 1];
	}

	public function push(IFlowState $state)
	{
		array_push($this->states, $state);
	}

	public function pop()
	{
		return array_pop($this->states);
	}

	public function count()
	{
		return count($this->states);
	}
}
