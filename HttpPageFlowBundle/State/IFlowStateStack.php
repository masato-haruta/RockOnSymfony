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
// <Use> : Flow State
use Rock\Components\Flow\State\IFlowState;
/**
 *
 */
interface IFlowStateStack
{
	public function top();

	public function push(IFlowState $state);

	public function pop();
}
