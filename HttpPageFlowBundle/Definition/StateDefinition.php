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

// @namesapce
namespace Rock\OnSymfony\HttpPageFlowBundle\Definition;
// @extends
use Rock\Component\Flow\Definition\StateDefinition as BaseDefinition;
/**
 *
 */
class StateDefinition extends BaseDefinition
{
	public function __construct($id)
	{
		parent::__construct($id);

		$this->class = '\\Rock\\OnSymfony\\HttpPageFlowBundle\\Flow\\LogicState';
	}
}
