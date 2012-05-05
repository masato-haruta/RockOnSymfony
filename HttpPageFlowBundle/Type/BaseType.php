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
// @use
use Rock\Component\Http\Flow\Type\BaseType as BaseTypeBase;

/**
 * Type of Default Flow on Symfony.
 * Extends Base Flow Type, and Flow Definition, which containes the logic of initialize Default flow 
 * 
 */
abstract class BaseType extends BaseTypeBase
{
	/**
	 *
	 */
	public function __construct($id)
	{
		parent::__construct($id);
        $this->class  = '\\Rock\\OnSymfony\\HttpPageFlowBundle\\Flow\PageFlow';

		$this->defaultStateClass = '\\Rock\\OnSymfony\\HttpPageFlowBundle\\Definition\\StateDefinition';
		$this->defaultPageClass  = '\\Rock\\OnSymfony\\HttpPageFlowBundle\\Definition\\PageDefinition';
	}

	protected function configure()
	{
		// Extends and defines any Page and Condition Definition to define Flow Behavior.
	}
}
