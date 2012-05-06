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
namespace Rock\OnSymfony\HttpPageFlowBundle\Event;
// @use
use Rock\OnSymfony\HttpPageFlowBundle\Event\HandleStateEvent;

/**
 *
 */
class PageFlowOutputFilterEvent extends HandleStateEvent 
{

	public function getOutput()
	{
		return $this->getFlow()->getOutput();
	}
}
