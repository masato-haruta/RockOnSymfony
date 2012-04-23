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
// <Use>
use Rock\Components\Http\Flow\Type\DefaultType as BaseType;
// <Use> : Builder
use Rock\Components\Http\Flow\Builder\Builder;
use Rock\Components\Flow\Factory\IFactory;

/**
 *
 */
class DefaultType extends BaseType
{
	public function getBuilder(IFactory $factory)
	{
		$factory->addTemplate('default', '\\Rock\\OnSymfony\\HttpPageFlowBundle\\Flow\PageFlow');

		return new Builder($factory);
	}
}
