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
