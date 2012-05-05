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
