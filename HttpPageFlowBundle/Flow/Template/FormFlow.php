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
use Rock\Components\Flow\Input\IInput;

class FormFlow extends PageFlow
{
	/**
	 *
	 */
	protected function doInit()
	{
		parent::doInit();

		$this
			->setEntryPage('input', array($this, 'doInput'))
			->addPostValidation(array($this, 'doInputValidation'))
			->addNext('complete', array($this, 'doComplete'))
		;
	}

	/**
	 *
	 */
	public function doInput(IInput $input)
	{
		$this->set('state', 'first');
	}
	/**
	 *
	 */
	public function doComplete(IInput $event)
	{
	}
}
