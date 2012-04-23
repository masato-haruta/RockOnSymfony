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
namespace Rock\OnSymfony\HttpPageFlowBundle\Annotation;
// <Interface>
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ConfigurationInterface;

// <Use> : Event
use Rock\OnSymfony\HttpPageFlowBundle\Event\PageEvents;

/**
 * @Annotation
 */
class Flow
  implements
    ConfigurationInterface
{
	/**
	 *
	 */
	protected $controller;
	/**
	 *
	 */
	protected $value;
	/**
	 *
	 */
	protected $name;
	/**
	 *
	 */
	protected $route;
	/**
	 *
	 */
	protected $directionKey;
	/**
	 *
	 */
	protected $listeners;

	protected $cleanedListeners;


	/**
	 *
	 */
	public function __construct(array $values)
	{
		$this->controller  = null;
		$this->listeners   = array();
		$this->type        = 'DEFAULT';

		//
		foreach($values as $k => $v)
		{
			if(preg_match('/^on/i', $k))
			{
				$this->addListener($k, $v);
			}
			else if(method_exists($this, $method = 'set'.ucfirst($k)))
			{
				$this->$method($v);
			}
			else
			{
				throw new \RuntimeException(sprintf('Unknown key "%s" is given for Annotation Class "%s"', $k, get_class($this)));
			}
		}
	}
	public function setValue($value)
	{
		$this->value = $value;
	}
	public function getValue()
	{
		return $this->value;
	}
	public function setName($name)
	{
		$this->name  = $name;
	}
	public function getName()
	{
		if($this->name)
			return $this->name;
		else
			return $this->getRoute();
	}
	/**
	 *
	 */
	public function setType($type)
	{
		$this->type  = $type;
	}

	/**
	 *
	 */
	public function setController($controller)
	{
		$this->controller  = $controller;
	}
	/**
	 *
	 */
	public function getController()
	{
		if(!$this->controller)
			throw new \Exception("Controller is not initialzed yet.");
		return $this->controller;
	}

	// Direction
	public function setDirectionKey($key)
	{
		$this->directionKey  = $key;
	}
	public function getDirectionKey()
	{
		return $this->directionKey;
	}
	// Listener
	/**
	 *
	 */
	public function addListener($eventname, $value)
	{
		$this->listeners[$eventname]  = $value;
	}

	protected function cleanListeners()
	{
		$this->cleanedListeners  = array();
		foreach($this->listeners as $eventname => $listener)
		{
			$eventname = PageEvents::fromOnName($eventname);
			
			$this->cleanedListeners[$eventname]  = array($this->getController(), $listener);
		}
	}
	/**
	 *
	 */
	public function getListeners()
	{
		if(!$this->cleanedListeners)
		{
			$this->cleanListeners();
		}
		return $this->cleanedListeners;
	}

	// Route
	public function setRoute($route)
	{
		$this->route  = $route;
	}
	public function getRoute()
	{
		return $this->route;
	}
	public function setDefaultRoute($route)
	{
		if(!$this->route)
			$this->route  = $route;
	}
    /**
     * 
     *
     * @return string 'flow'
     */
    public function getAliasName()
	{
	    return 'flow';
	}
}
