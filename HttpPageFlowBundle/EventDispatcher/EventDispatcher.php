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
namespace Rock\OnSymfony\HttpPageFlowBundle\EventDispatcher;
// <Base>
use Symfony\Component\EventDispatcher\EventDispatcher as BaseEventDispatcher;
// <Use> : Event 
use Symfony\Component\EventDispatcher\Event;

/**
 *
 */
class EventDispatcher extends BaseEventDispatcher
  implements
    IStackEventDispatcher
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
	r}
}
