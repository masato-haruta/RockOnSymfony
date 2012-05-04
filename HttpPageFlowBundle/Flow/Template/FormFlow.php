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
class FormFlow extends AbstractFormFlow
{
	/**
	 *
	 */
	public function doInput(IInput $input)
	{
		$data = array();
		// Read Session and if has form_data, bind it.
		if($this->getSession()->has('form_data'))
		{
			$data = $this->getSession()->get('form_data');
			// 
			$this->setFormData($data);
		}
		//
		$form = $this->getForm();

		// For error case, bind the data and regenerate CSRF token.
		if($this->getSession()->has('form_success') && !$this->getSession()->get('form_success'))
		{
			// 
			$form->bind($data);
		}

		$this->set('form', $form->createView());
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
		$this->getSession()->set('form_data', $form->getData());
		
		$bValid = $form->isValid();
		$this->getSession()->set('form_success', $bValid);
		// Force save into session
		$this->getSessionManager()->save();
		
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
