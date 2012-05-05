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
			->addState('noPage', array($this, 'doNoPage'))
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
	}
	public function doThird(IInput $input)
	{
		//$input->getFlow()->set('state', 'third');
	}

	public function doNoPage(IInput $input)
	{
	}
}

