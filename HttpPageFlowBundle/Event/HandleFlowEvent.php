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

// <Use> :Flow 
use Rock\Components\Flow\IFlow;
/**
 *
 */
class HandleFlowEvent extends Event
  implements
    IPageFlowEvent
{
	/**
	 *
	 */
	protected $flow;

	/**
	 *
	 */
	public function __construct(IFlow $flow)
	{
		$this->flow  = $flow;
	}
	/**
	 *
	 */
	public function getFlow()
	{
		return $this->flow;
	}
}
