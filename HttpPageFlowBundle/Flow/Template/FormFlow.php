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
abstract class FormFlow extends AbstractFormFlow
{
	/**
	 *
	 */
	public function doInput(IInput $input)
	{
		$form = $this->getForm();

		// Read Session and if has form_data, bind it.
		if($this->has('form_data'))
			$form->setData('form_data')
	}

	/**
	 *
	 */
	public function doValidateInput(IInput $input)
	{
		$bValid   = false;
		
		// Validate registed form and save into session
		$form  = $this->getForm();
		$form->bindRequest($input->getHttpRequest());

		// Validate form
		if($bValid = $form->isValid())
		{
			$this->set('form_data', $form->getData());
		}
		
		return $bValid;
	}

	/**
	 * Update or Create Entity or some
	 */
	public function doSave()
	{
	}
	/**
	 *
	 */
	public function doComplete(IInput $event)
	{
	}
}
