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
class FormConfirmFlow extends FormFlow
{
	/**
	 *
	 */
	public function doConfirm(IInput $input)
	{
		$form = $this->getForm();
		
		// do some
		$this->set('form', $form->getData() );
		$this->set('_form', $form);
	}

	/**
	 *
	 */
	public function doValidateSession(IInput $input)
	{
		return true;
	}

}
