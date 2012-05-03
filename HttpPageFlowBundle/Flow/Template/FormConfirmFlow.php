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

// <Use> : Event
use Rock\OnSymfony\HttpPageFlowBundle\Event\IPageEvent;
use Rock\Component\Flow\Input\IInput;
/**
 *
 */
class FormConfirmFlow extends FormFlow
{
	public function doConfirm(IInput $input)
	{
		$form = $this->getForm();
		
		// do some

		$this->set('form', $form->createView());
	}

	public function doValidateSession(IInput $input)
	{
		return true;
	}

}
