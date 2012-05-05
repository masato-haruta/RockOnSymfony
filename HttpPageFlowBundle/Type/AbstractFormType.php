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
		    ->addState('init', array($this->getReference(), 'doInitializeForm'))
			->addPage('input', array($this->getReference(), 'doInput'))
			->addCondition(array($this->getReference(),'doValidateInput'))
			->addState('save', array($this->getReference(), 'doSave'))
			->addPage('complete', array($this->getReference(), 'doComplete'))
		;
	}
}
