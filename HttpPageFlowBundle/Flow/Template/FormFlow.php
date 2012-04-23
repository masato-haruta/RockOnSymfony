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
use Rock\Components\Automaton\Input\IInput as IAutomatonInput;

class FormFlow extends PageFlow
{
	/**
	 *
	 */
	protected function doInit()
	{
		parent::doInit();

		$this
			->setEntryPoint('input', array($this, 'doPageInput'))
			->addNext('complete', array($this, 'doPageComplete'))
		;
	}

	/**
	 *
	 */
	public function doPageInput(IAutomatonInput $event)
	{
			throw new \Exception('Input');
	}
	/**
	 *
	 */
	public function doPageComplete(IAutomatonInput $event)
	{
	}
}
