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
namespace Rock\OnSymfony\HttpPageFlowBundle\Flow\Template;
// <Base>
use Rock\OnSymfony\HttpPageFlowBundle\Flow\PageFlow;

// <Use> : Event
use Rock\OnSymfony\HttpPageFlowBundle\Event\IPageEvent;
use Rock\Component\Flow\Input\IInput;

class FormFlow extends PageFlow
{
	/**
	 *
	 */
	public function doInput(IInput $input)
	{
		$this->set('state', 'input');
	}
	/**
	 *
	 */
	public function doComplete(IInput $event)
	{
		$this->set('state', 'complete');
	}
}
