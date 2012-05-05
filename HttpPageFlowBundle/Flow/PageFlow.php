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

// <Namespace>
namespace Rock\OnSymfony\HttpPageFlowBundle\Flow;
// <Base> 
use Rock\Component\Http\Flow\PageFlow as BaseFlow;
// <Interface>
use Rock\OnSymfony\HttpPageFlowBundle\Aware\IEventDispatcherAware;
// <Use> : EventDispatcher
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\Event;
// <Use> : Flow Event
use Rock\OnSymfony\HttpPageFlowBundle\Event\PageFlowEvents;
use Rock\OnSymfony\HttpPageFlowBundle\Event\IPageEvent;
use Rock\OnSymfony\HttpPageFlowBundle\Event\HandleFlowEvent;
use Rock\OnSymfony\HttpPageFlowBundle\Event\HandleFlowWithTraversalEvent;

// <Use> : Flow Component
use Rock\Component\Flow\Traversal\ITraversalState;
use Rock\Component\Flow\Output\IOutput;
use Rock\Component\Flow\Directions;
// <Use> : Page
use Rock\OnSymfony\HttpPageFlowBundle\Flow\Page;

/**
 *
 */
class PageFlow extends BaseFlow
  implements
	IEventDispatcherAware,
	EventDispatcherInterface
{
	protected $output     = null;
	protected $dispatcher = null;

	/**
	 *
	 */
	public function __construct()
	{
		parent::__construct();
	}
	/**
	 * 
	 */
	public function dispatch($eventName, Event $event = null)
	{
		$this->getEventDispatcher()->dispatch($eventName, $event);
	}

	/**
	 * 
	 */
    public function addListener($eventName, $listener, $priority = 0)
	{
		$this->getEventDispatcher()->addListener($eventName, $listener, $priority);
	}
	
	/**
	 * 
	 */
	public function addSubscriber(EventSubscriberInterface $subscriber)
	{
		$this->getEventDispatcher()->addSubscriber($subscriber);
	}

	/**
	 * 
	 */
	public function removeListener($eventName, $listener)
	{
		$this->getEventDispatcher()->removeListener($eventName, $listener);
	}
	/**
	 * 
	 */
	public function removeSubscriber(EventSubscriberInterface $subscriber)
	{
		$this->getEventDispatcher()->removeSubscriber($subscriber);
	}
	/**
	 * 
	 */
	public function getListeners($eventName = null)
	{
		return $this->getEventDispatcher()->getListeners($eventName);
	}
	/**
	 * 
	 */
	public function hasListeners($eventName = null)
	{
		return $this->getEventDispatcher()->hasListeners($eventName);
	}

	/**
	 * 
	 */
	public function setEventDispatcher(EventDispatcherInterface $dispatcher)
	{
		$this->dispatcher  = $dispatcher;
	}

	/**
	 * 
	 */
	public function getEventDispatcher()
	{
		if(!$this->dispatcher)
			throw new \Exception('Event Dispatcher is not initialized.');
		return $this->dispatcher;
	}

	//-- doXxx Method
	/**
	 * 
	 */
	protected function doInit(ITraversalState $traversal)
	{
		parent::doInit($traversal);
		$this->dispatch(PageFlowEvents::onFlow('init'), new HandleFlowWithTraversalEvent($this, $traversal));
	}
	
	/**
	 * 
	 */
	protected function doInitPath()
	{
		parent::doInitPath();

		$this->dispatch(PageFlowEvents::onFlow('init_path'), new HandleFlowEvent($this));
	}
	/**
	 * 
	 */
	protected function doShutdown(ITraversalState $traversal)
	{
		parent::doShutdown($traversal);
		//
		$this->dispatch(PageFlowEvents::onFlow('shutdown'), new HandleFlowWithTraversalEvent($this, $traversal));
	}

	/**
	 * 
	 */
	protected function doHandleInput(ITraversalState $traversal)
	{
		$this->dispatch(PageFlowEvents::onFlow('handle_input'), new HandleFlowWithTraversalEvent($this, $traversal));
		// Set traversal output as this output
		$bAllocated = false;

		try
		{
			if(!$this->output)
			{
				$bAllocated = true;
				$this->allocateOutput($traversal->getOutput());
			}
			parent::doHandleInput($traversal);

			// Release Output
			if($bAllocated)
			{
				$this->releaseOutput();
				$bAllocated = false;
			}
		}
		catch(\Exception $ex)
		{
			// release Output
			if($bAllocated)
				$this->releaseOutput();
			throw $ex;
		}
	}

	/**
	 * 
	 */
	protected function doHandleState(ITraversalState $traversal)
	{
		parent::doHandleState($traversal);
		//
	}

	/**
	 * 
	 */
	protected function doRecoverTraversal(ITraversalState $traversal)
	{
		parent::doRecoverTraversal($traversal);

		$this->dispatch(PageFlowEvents::onFlow('recover_traversal'), new HandleFlowWithTraversalEvent($this, $traversal));
	}

	/**
	 * 
	 */
	public function getOutput()
	{
		if(!$this->output)
			throw new \RuntimeException('$output is not allocated on this timing.');
		//
		return $this->output;
	}

	/**
	 *
	 */
	protected function allocateOutput(IOutput $output)
	{
		$this->output = $output;
	}
	/**
	 *
	 */
	protected function releaseOutput()
	{
		$this->output = null;
	}

	/**
	 *
	 */
	public function set($name, $value)
	{
		if($this->output)
			$this->output->set($name, $value);
	}

	public function has($name)
	{
		return $this->output->has($name);
	}
	/**
	 *
	 */
	public function get($name)
	{
		if($this->output)
			return $this->output->get($name);
		return null;
	}
	/**
	 *
	 */
	public function all()
	{
		if($this->output)
			return $this->output->all();

		return array();
	}

	public function getSession()
	{
		if($this->output)
			return $this->output->getTraversal()->getSession();
		return null;
	}
}
