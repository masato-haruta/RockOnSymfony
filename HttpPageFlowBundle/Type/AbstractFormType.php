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
use Rock\OnSymfony\HttpPageFlowBundle\Type\BaseType;

/**
 *
 */
abstract class AbstractFormType extends BaseType 
{
	/**
	 *
	 */
	public function __construct($id)
	{
		parent::__construct($id);

		$this->class = '\\Rock\\OnSymfony\\HttpPageFlowBundle\\Flow\\Template\\FormFlow';
	}
	/**
	 *
	 */
	protected function configure()
	{
		// Definine Page Flow
		$this
			->addPage('input', array($this->getReference(), 'doInput'))
			->addCondition(array($this->getReference(),'doValidateInput'))
			->addState('save', array($this->getReference(), 'doSave'))
			->addPage('complete', array($this->getReference(), 'doComplete'))
		;
	}
}
