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

use Symfony\Bundle\FrameworkBundle\Debug\TraceableEventDispatcher as BaseEventDispatcher;
use Symfony\Component\HttpKernel\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\Event;
class TraceableEventDispatcher extends BaseEventDispatcher
{
	protected $delimiter = '.';

	/**
	 * @override
	 */
	public function dispatch($eventName, Event $event = null)
	{
		$names  = $this->explodeNames($eventName);
		foreach($names as $name)
		{
			parent::dispatch($name, $event);
		}
	}

	/**
	 *
	 */
	protected function explodeNames($name)
	{
		$delimiter = $this->getDelimiter();

		$components = explode($delimiter, $name);

		$names  = array();
		$tmp    = array();
		foreach($components as $comp)
		{
			$tmp[]  = $comp;
			$names[] = implode($delimiter, $tmp);
		}

		return $names;
	}

	public function getDelimiter()
	{
		return $this->delimiter;
	}

}