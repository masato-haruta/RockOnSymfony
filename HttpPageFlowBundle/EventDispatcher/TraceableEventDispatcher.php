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
