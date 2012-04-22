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

// <Use> : Events
use Rock\OnSymfony\HttpPageFlowBundle\Event\PageEvents;
use Rock\OnSymfony\HttpPageFlowBundle\Event\HandlePageEvent;

class Page extends BasePage
{
	public function handle(IInput $input)
	{
		// handle w/ IInput
		parent::handle($input);

		// handle w/ EventDispatcher
		$flow  = $this->getFlow();
		if($flow instanceof IEventDispatcherAware)
		{
			$flow->dispatch(PageEvents::page($this->getName()), new HandlePageEvent());
		}
	}
}
