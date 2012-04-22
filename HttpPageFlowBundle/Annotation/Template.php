<?php
/************************************************************************************
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
 ************************************************************************************/
// <Interface>
namespace Rock\OnSymfony\HttpPageFlowBundle\Annotation;

// <Base>
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template as Configuration;

/**
 * @Annotation
 */
class Template extends Configuration
{
	public function setVar($name, $value)
	{
		$this->vars[$name] = $value;
	}
}
