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

// @namespace
namespace Rock\OnSymfony\HttpPageFlowBundle\Annotation;
// @interface
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ConfigurationInterface;
// @use Event
use Rock\OnSymfony\HttpPageFlowBundle\Event\Resolver\IEventNameResolver;
/**
 *
 * e.x.
 *    @FlowHandler("onInit", method="onInitIndex")
 *
 */
/**
 * @Annotation
 */
class FlowHandler
  implements
    ConfigurationInterface
{

	/**
	 * @var 
	 */
	protected $_eventname;

	/**
	 * @var 
	 */
	protected $owner;

	/**
	 * @var 
	 */
	protected $eventname;

	/**
	 * @var 
	 */
	protected $method;

	/**
	 * @var 
	 */
	protected $resolver;

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

		if($this->method === null)
		{
			$this->setMethod($value);
		}
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
		if(!$this->resolver)
			throw new \Exception('EventName Resolver is not initialized.');
		$this->eventname = $this->resolver->resolve($this->_eventname);
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
	 * @var 
	 */
	public function setEventNameResolver(IEventNameResolver $resolver)
	{
		$this->resolver  = $resolver;
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
