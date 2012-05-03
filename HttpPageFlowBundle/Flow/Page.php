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
// @interface
use Rock\Component\Http\Flow\IPage;

// <Use> : EventDispatcher
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
// <Use> : Events
use Rock\OnSymfony\HttpPageFlowBundle\Event\PageFlowEvents;
use Rock\OnSymfony\HttpPageFlowBundle\Event\HandlePageEvent;
// <Use> : Input
use Rock\Component\Flow\Input\IInput;

/**
 *
 */
class Page extends LogicState
  implements
    IPage
{
	/**
	 * @override Rock\Component\Flow\Graph\State\State
	 * @param IInput
	 * @return void
	 */
	public function handle(IInput $input)
	{
		$flow  = $this->getGraph()->getFlow();

		if($input->useRedirection() && ($input->getRequestedDirection() !== null))
		{
			$output  = $flow->getOutput();
			$output->setRedirectTo($this);
		}
		else
		{
			// handle w/ IInput
			parent::handle($input);
			//
			if($flow && ($flow instanceof EventDispatcherInterface))
			{
				$flow->dispatch(PageFlowEvents::onPage($this->getName()), new HandlePageEvent($flow, $this));
			}
		}
	}
}
