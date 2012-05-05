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
