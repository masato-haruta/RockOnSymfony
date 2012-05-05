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
 * Type of Default Flow on Symfony.
 * Extends Base Flow Type, and Flow Definition, which containes the logic of initialize Default flow 
 * 
 */
class DefaultType extends BaseType
{
	/**
	 *
	 */
	public function __construct()
	{
		parent::__construct('rock.flow.template.default');
		
		$this->setAttribute('alias', 'Default');
	}
}
