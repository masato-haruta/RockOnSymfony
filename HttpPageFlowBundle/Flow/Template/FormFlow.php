<?php
/****
 *
 * Description:
 *      
 * 
 * $Date$
 * Rev    : see git
 * Author : Yoshi Aoki <yoshi@44services.jp>
 * 
 *  This file is part of the Rock package.
 *
 * For the full copyright and license information, 
 * please read the LICENSE file that is distributed with the source code.
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
		//
		$form = $this->getForm();

		// For error case, bind the data and regenerate CSRF token.
		if($this->getSession()->has('form_success') && !$this->getSession()->get('form_success'))
		{
			// 
			$data = $this->getFormData();
			$form->bind($data);
		}

		$this->set('form', $form->createView());
		$this->set('_form', $form);
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
		//
		$this->setFormData($form->getData());
		
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
		$form  = $this->getForm();
		$data  = $form->getData();

		// save the data
		//throw new \Exception('You need to override doSave, or use @FlowDelegate("save").');
	}
	/**
	 *
	 */
	public function doComplete(IInput $event)
	{
		$form  = $this->getForm();

		$this->set('form', $form->getData());
		$this->set('_form', $form);
	}
}
