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
namespace Rock\OnSymfony\HttpPageFlowBundle\Event;
// <Base>
use Symfony\Component\EventDispatcher\Event;
// <Interface>
use Rock\OnSymfony\HttpPageFlowBundle\Event\IPageEvent

/**
 *
 */
class HandlePageEvent extends Event
  implements
    IPageEvent
{
	protected $page;
	protected $flow;
	public function getPage()
	{
		return $this->page;
	}

	public function getPageFlow()
	{
		return $this->flow;
	}
}
