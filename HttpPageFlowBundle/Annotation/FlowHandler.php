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
namespace Rock\OnSymfony\HttpPageFlowBundle\Annotation;
// @interface
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ConfigurationInterface;

/**
 * 
 * e.x.
 *    @FlowHandler("onInit", method="onInitIndex")
 *
 * @Annotation
 */
class FlowHandler
  implements
    ConfigurationInterface
{
	protected $_eventname;
	protected $owner;
	protected $eventname;
	protected $method;
	/**
	 *
	 */
	public function __construct(array $values)
	{
		foreach($values as $k => $v)
		{
			if(method_exists($this, $method='set'.ucfirst($k)))
			{
				$this->$method($v);
			}
			else
			{
				throw new \RuntimeException(sprintf('Unknown key "%s" is given for Annotation Class "%s".', $k, get_class($this)));
			}
		}
	}
	
	/**
	 * set value
	 */
	public function setValue($value)
	{
		$this->_eventname  = $value;
	}

	/**
	 *
	 */
	public function getEventname()
	{
		if(!$this->eventname)
		{
			$this->cleanEventname();
		}
		return $this->eventname;
	}

	/**
	 *
	 */
	protected function cleanEventname()
	{
		$this->eventname = EventNameResolver::resolve($this->_eventname);
	}

	/**
	 * @param string MethodName
	 */
	public function setMethod($method)
	{
		$this->method = $method;
	}

	/**
	 *
	 */
	public function getMethod()
	{
		return $this->method;
	}

	/**
	 *
	 */
	public function setOwner($owner)
	{
		if($this->method)
		{
			// Validate the owner instance has the method
			$class = new \ReflectionObject($owner);
			if(!$class->hasMethod($this->method))
			{
				throw new \InvalidArgumentException(sprintf('Instance of Class "%s" dose not have the method "%s".', get_class($owner), $this->method));
			}
		}

		$this->owner  = $owner;
	}

	/**
	 *
	 */
	public function getCallable()
	{
		return array($this->owner, $this->getMethod());
	}

	/**
	 * @param void
	 * @return void
	 */
	public function getAliasName()
	{
		return 'FlowHandler';
	}

}
