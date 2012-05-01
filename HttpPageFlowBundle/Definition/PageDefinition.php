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
namespace Rock\OnSymfony\HttpPageFlowBundle\Definition;
// @extends
use Rock\Component\Http\Flow\Definition\PageDefinition as BaseDefinition;
/**
 *
 */
class PageDefinition extends BaseDefinition
{
	public function __construct($id)
	{
		parent::__construct($id);

		$this->class = '\\Rock\\OnSymfony\\HttpPageFlowBundle\\Flow\\Page';
	}
}
