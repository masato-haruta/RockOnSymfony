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
namespace Rock\OnSymfony\HttpPageFlowBundle\Type;
// @extends
use Rock\OnSymfony\HttpPageFlowBundle\Type\AbstractFormType;


abstract class AbstractFormConfirmType extends AbstractFormType
{
	public function __construct($id)
	{
		parent::__construct($id);

		$this->class  = '\\Rock\OnSymfony\\HttpPageFlowBundle\\Flow\\Template\\FormConfirmFlow';
	}

	protected function configure()
	{
		// Definine Page Flow
		$this
			->addPage('input', array($this->getReference()))
			->addCondition(array($this->getReference(), 'onValidateInput'))
			->addPage('confirm', array($this->getReference()))
			->addCondition(array($this->getReference(), 'onValidateSession'))
			->addState('save', array($this->getReference(), 'doSave'))
			->addPage('complete', array($this->getReference(), 'doComplete'));
			
	}
}
