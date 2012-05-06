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
// @use Event
use Rock\OnSymfony\HttpPageFlowBundle\Event\IPageEvent;
use Rock\Component\Flow\Input\IInput;

/**
 *
 */
class DeleteFlow extends AbstractDeleteFlow
{
	/**
	 * State action on init
	 * 
	 * @state Logic init
	 * @param IInput $input FlowInput
	 * @return void
	 */
	public function doInitializeData(IInput $input)
	{
		// Do your initialization on Controller or here
	}
	/**
	 * Page Action on Confirm
	 * 
	 * @state Page confirm
	 * @param IInput $input FlowInput
	 * @return void
	 *
	 */
	public function doConfirm(IInput $input)
	{
	}

	/**
	 * State action on delete
	 * Make sure you have to override this function.
	 *
	 * @state Logic delete
	 * @param IInput $input FlowInput
	 * @return void
	 * @throw Exception 
	 */
	public function doDelete(IInput $input)
	{
		throw new \Exception('Not Implemented');
	}

	/**
	 * Page action on Complete 
	 * 
	 * @state Page complete
	 * @param IInput $input FlowInput
	 * @return void
	 */
	public function doComplete(IInput $event)
	{
	}
}


