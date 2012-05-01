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
use Rock\Component\Http\Flow\PageFlow as BaseFlow;
// <Interface>
use Rock\OnSymfony\HttpPageFlowBundle\EventDispatcher\IEventDispatcherAware;
// <Use> : EventDispatcher
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\Event;
// <Use> : Flow Event
use Rock\OnSymfony\HttpPageFlowBundle\Event\PageEvents;
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
	EventDispatcherInterface
{
	protected $output     = null;
	protected $dispatcher = null;
	protected $bUseRedirection = false;

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
	protected function doInit(ITraversalState $state)
	{
		$this->dispatch(PageEvents::ON_INIT, new HandleFlowWithTraversalEvent($this, $state));

		parent::doInit($state);

		if($this->useRedirection() && ($state->getInput()->getDirection() !== Directions::CURRENT))
		{
			$this->addListener(PageEvents::EVENT_PREFIX.'.'.PageEvents::ON_PAGE_PREFIX, array($this, 'onPageRedirect'));
		}
	}
	
	/**
	 * 
	 */
	protected function doInitPath()
	{
		$this->dispatch(PageEvents::ON_INIT_PATH, new HandleFlowEvent($this));
		parent::doInitPath();
	}
	/**
	 * 
	 */
	protected function doShutdown(ITraversalState $state)
	{
		parent::doShutdown($state);
		$this->dispatch(PageEvents::ON_SHUTDOWN, new HandleFlowWithTraversalEvent($this, $state));
	}

	protected function doHandleInput(ITraversalState $state)
	{
		$this->dispatch(PageEvents::ON_HANDLE_INPUT, new HandleFlowWithTraversalEvent($this, $state));
		// Set state output as this output
		$this->allocateOutput($state->getOutput());

		parent::doHandleInput($state);
		// Release Output
		$this->releaseOutput();
	}

	protected function doRecoverTraversal(ITraversalState $state)
	{
		parent::doRecoverTraversal($state);

		$this->dispatch(PageEvents::ON_RECOVER_STATE, new HandleFlowWithTraversalEvent($this, $state));
	}

	public function getOutput()
	{
		if(!$this->output)
			throw new \RuntimeException('$output is not allocated on this timing.');
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

	/**
	 *
	 */
	protected function createPage($name, $listener)
	{
		$page   = new Page($this->getPath(), $name, $listener);
		$this->getPath()->addVertex($page);
		
		return $page;
	}

	public function setUseRedirection($bUse = true)
	{
		$this->bUseRedirection = $bUse;
	}
	public function useRedirection()
	{
		return $this->bUseRedirection;
	}

	public function onPageRedirect(IPageEvent $event)
	{
		// Redirection is ON
		$output  = $event->getFlow()->getOutput();
		$output->setUseRedirection(true);
	}
}
