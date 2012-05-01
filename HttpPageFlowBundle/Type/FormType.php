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
class FormType extends BaseType 
{
	/**
	 *
	 */
	public function __construct()
	{
		parent::__construct('rock.flow.templates.form');

		$this->class = '\\Rock\\OnSymfony\\HttpPageFlowBundle\\Flow\\Template\\FormFlow';
		$this->setAttribute('alias', 'Form');
	}
	/**
	 *
	 */
	protected function configure()
	{
		// Set Sub Definitions
		$this
			->addPage('input', array($this->getReference(), 'doInput'))
			->addCondition(array($this->getReference(),'onValidateInput'))
			->addPage('complete', array($this->getReference(), 'doComplete'))
		;
	}
}
