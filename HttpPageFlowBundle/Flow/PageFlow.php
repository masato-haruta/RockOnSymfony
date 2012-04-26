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
namespace Rock\OnSymfony\HttpPageFlowBundle\Flow;

// 
use Rock\Components\Http\Flow\PageFlow as BaseFlow;
// <Use> : EventDispatcher
use Rock\OnSymfony\HttpPageFlowBundle\EventDispatcher\IEventDispatcherAware;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\EventDispatcher\Event;
// <Use> : Flow Event
use Rock\OnSymfony\HttpPageFlowBundle\Event\PageEvents;
use Rock\OnSymfony\HttpPageFlowBundle\Event\HandleFlowEvent;

// <Use> : Flow Components
use Rock\Components\Flow\State\IFlowState;
use Rock\Components\Flow\Output\IOutput;
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
	protected function doInit()
	{
		$this->dispatch(PageEvents::ON_INIT, new HandleFlowEvent($this));

		parent::doInit();
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
	protected function doShutdown(IFlowState $state)
	{
		parent::doShutdown($state);
		$this->dispatch(PageEvents::ON_SHUTDOWN, new HandleFlowEvent($this));
	}

	protected function doHandleInput(IFlowState $state)
	{
		$this->dispatch(PageEvents::ON_HANDLE_INPUT, new HandleFlowEvent($this));
		// Set state output as this output
		$this->allocateOutput($state->getOutput());

		parent::doHandleInput($state);
		// Release Output
		$this->releaseOutput();
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
		$this->getPath()->addState($page);
		
		return $page;
	}
}
