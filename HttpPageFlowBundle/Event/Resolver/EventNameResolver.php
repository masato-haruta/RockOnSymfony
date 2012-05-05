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
namespace Rock\OnSymfony\HttpPageFlowBundle\Event\Resolver;
// <Use> : Page Event
use Rock\OnSymfony\HttpPageFlowBundle\Event\PageFlowEvents;

/**
 *
 */
class EventNameResolver
  implements
    IEventNameResolver
{
	public function resolve($name)
	{
		// Page Event
		if(preg_match('/^onPage(?P<name>.*)$/', $name, $match))
		{
			return PageFlowEvents::onPage($this->snakeize($match['name']));
		}
		// Flow Event
		else if(preg_match('/^onFlow(?P<name>.*)$/', $name, $match))
		{
			return PageFlowEvents::onFlow($this->snakeize($match['name']));
		}
		// Builder Event
		else if(preg_match('/on(?P<name>.*)$/', $name, $match))
		{
			return PageFlowEvents::onBuilder($this->snakeize($match['name']));
		}
		return $name;
	}

	/**
	 *
	 */
	public function snakeize($value)
	{
		$value = preg_replace('/([A-Z])/', '_$1', $value);
		$value = strtolower($value);
		return ltrim($value, '_');
	}
}
