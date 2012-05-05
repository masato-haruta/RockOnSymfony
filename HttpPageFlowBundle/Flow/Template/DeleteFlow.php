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
namespace Rock\OnSymfony\HttpPageFlowBundle\Flow\Template;
// @extends
use Rock\OnSymfony\HttpPageFlowBundle\Flow\PageFlow;
// @use Event
use Rock\OnSymfony\HttpPageFlowBundle\Event\IPageEvent;
use Rock\Component\Flow\Input\IInput;

/**
 *
 */
class DeleteFlow extends PageFlow 
{
	/**
	 *
	 */
	public function doInitializeData(IInput $input)
	{
		// Do your initialization on Controller or here
	}
	/**
	 *
	 */
	public function doConfirm(IInput $input)
	{
	}

	/**
	 *
	 */
	public function doDelete(IInput $input)
	{
		throw new \Exception('Not Implemented');
	}

	/**
	 *
	 */
	public function doComplete(IInput $event)
	{
	}
}


