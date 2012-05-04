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
// @namespace
namespace Rock\OnSymfony\HttpPageFlowBundle\Definition;
// @extends 
use Rock\Component\Configuration\Definition\ComponentBuilder;
// @implements
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
// @use EventDispatcher Impls
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
// @use Definition Interface
use Rock\Component\Configuration\Definition\Definition;
use Rock\Component\Configuration\Definition\Filter\InterfaceAwareInjectionFilter;

	

/**
 *
 */
class Builder extends ComponentBuilder
  implements
    EventDispatcherInterface
{
	protected $dispatcher;
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
		
		// if Container has EventDipstacher Filter, clear
		if($this->container)
			$this->getContainer()->removeFilter('event_dispatcher_aware');

		// Insert EventDispatcher into Aware
		$this->getContainer()->addFilter(new InterfaceAwareInjectionFilter(
			'interface.event_dispatcher_aware',
			'\\Rock\\OnSymfony\\HttpPageFlowBundle\\Aware\\IEventDispatcherAware',
			'setEventDispatcher',
			$this->dispatcher
		));
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

	///**
	// *
	// */
	//protected function createInstanceFromDefinition(Definition $definition)
	//{
	//	$component = parent::createInstanceFromDefinition($definition);

	//	if($component instanceof EventDispatcherInterface)
	//		$component->setEventDispatcher($this->getEventDispatcher());
	//	return $component;
	//}
}
