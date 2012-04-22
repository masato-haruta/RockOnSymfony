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
// <Namespace> 
namespace Rock\OnSymfony\HttpPageFlowBundle\Type;
// <Base>
use Rock\Components\Flow\Type\Types;

class BuiltinTypes extends Types
{
	protected function init()
	{
		// 
		$this->types  = array(
			'Form' => '\\Rock\\OnSymfony\\HttpPageFlowBundle\\Flow\\PageFlow'
		);
	}
	protected function getBuilderClass()
	{
		return 'Rock\\OnSymfony\\HttpPageFlowBundle\\Builder\\FlowBuilder';
	}
}
