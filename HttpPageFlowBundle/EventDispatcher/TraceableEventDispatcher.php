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

namespace Rock\OnSymfony\HttpPageFlowBundle\EventDispatcher;

use Symfony\Bundle\FrameworkBundle\Debug\TraceableEventDispatcher as Base;
use Symfony\Component\HttpKernel\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\Event;
class TraceableEventDispatcher extends Base
{
	public function __construct(ContainerInterface $container, LoggerInterface $logger = null)
	{
		parent::__construct($container, $logger);
	}

	public function dispatch($eventName, Event $event = null)
	{
		$this->logger->info(sprintf('EventName [%s] is dispatched.', $eventName));
		parent::dispatch($eventName, $event);
	}
}
