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
namespace Rock\OnSymfony\HttpPageFlowBundle\Flow;
// <Base>
use Rock\Components\Http\Flow\Page as BasePage;

// <Use> : EventDispatcher
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
// <Use> : Events
use Rock\OnSymfony\HttpPageFlowBundle\Event\PageEvents;
use Rock\OnSymfony\HttpPageFlowBundle\Event\HandlePageEvent;
// <Use> : Input
use Rock\Components\Flow\Input\IInput;

/**
 *
 */
class Page extends BasePage
{
	/**
	 *
	 */
	public function handle(IInput $input)
	{
		// handle w/ IInput
		parent::handle($input);

		// handle w/ EventDispatcher
		$flow  = $this->getGraph()->getFlow();
		
		if($flow && ($flow instanceof EventDispatcherInterface))
		{
			$flow->dispatch(PageEvents::page($this->getName()), new HandlePageEvent($flow, $this));
		}
	}
}
