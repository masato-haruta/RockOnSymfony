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
use Rock\OnSymfony\HttpPageFlowBundle\Event\IPageEvent;

// <Use>
use Rock\Component\Flow\IFlow;
use Rock\Component\Http\Flow\IPage;

/**
 *
 */
class HandlePageEvent extends HandleFlowEvent
  implements
    IPageEvent
{
	protected $page;
	/**
	 *
	 */
	public function __construct(IFlow $flow, IPage $page)
	{
		parent::__construct($flow);

		$this->page  = $page;
	}

	/**
	 *
	 */
	public function getPage()
	{
		return $this->page;
	}
}
