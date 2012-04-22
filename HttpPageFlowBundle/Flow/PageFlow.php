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

use Rock\OnSymfony\HttpPageFlowBundle\Event\PageEvents;
use Rock\OnSymfony\HttpPageFlowBundle\Event\HandleFlowEvent;
/**
 *
 */
class PageFlow extends BaseFlow
  implements
	IEventDispatcherAware
{
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
		return $this->hasListeners($eventName);
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
	protected function doInit()
	{
		$this->dispatch(PageEvents::ON_INIT, new HandleFlowEvent());
		parent::doInit();
	}
	
	protected function doInitPath()
	{
		$this->dispatch(PageEvents::ON_INIT_PATH, new HandleFlowEvent());
		parent::doInit();
	}
	protected function doShutdown()
	{
		$this->dispatch(PageEvents::ON_SHUTDOWN, new HandleFlowEvent());
		parent::doShutdown();
	}
}
