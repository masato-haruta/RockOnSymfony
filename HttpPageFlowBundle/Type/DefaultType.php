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
