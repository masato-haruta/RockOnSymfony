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
// @extends
use Rock\Component\Flow\Graph\State\State;
// <Use> : Events
use Rock\OnSymfony\HttpPageFlowBundle\Event\PageFlowEvents;
use Rock\OnSymfony\HttpPageFlowBundle\Event\HandleStateEvent;
// @use Input
use Rock\Component\Flow\Input\IInput;
// @use EventDispatcher Interface
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * This is a State not Page
 */
class LogicState extends State
{
	/**
	 * @override Rock\Component\Flow\Graph\State\State
	 * @param IInput
	 * @return void
	 */
	public function handle(IInput $input)
	{
		// handle w/ IInput
		parent::handle($input);

		// handle w/ EventDispatcher
		$flow  = $this->getGraph()->getFlow();
		
		if($flow && ($flow instanceof EventDispatcherInterface))
		{
			$flow->dispatch(PageFlowEvents::onState($this->getName()), new HandleStateEvent($flow, $this));
		}
	}
}
