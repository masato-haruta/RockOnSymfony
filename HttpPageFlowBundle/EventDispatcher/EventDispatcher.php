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
