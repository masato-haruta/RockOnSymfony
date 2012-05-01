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

// 
use Rock\Component\Flow\Input\IInput;

/**
 * Type of Default Flow on Symfony.
 * Extends Base Flow Type, and Flow Definition, which containes the logic of initialize Default flow 
 * 
 */
class DemoType extends BaseType
{
	/**
	 *
	 */
	public function __construct()
	{
		parent::__construct('rock.flow.template.demo');
		
		$this->setAttribute('alias', 'Demo');
	}

	protected function configure()
	{
		// Set Sub Definitions
		$this
			->addPage('first', array($this, 'doFirst'))
			->addPage('second', array($this, 'doSecond'))
			->addPage('third', array($this, 'doThird'))
		;
	}

	public function doFirst(IInput $input)
	{
		//$input->getFlow()->set('state', 'first');
	}
	public function doSecond(IInput $input)
	{
		//$input->getFlow()->set('state', 'second');
	}
	public function doThird(IInput $input)
	{
		//$input->getFlow()->set('state', 'third');
	}
}

