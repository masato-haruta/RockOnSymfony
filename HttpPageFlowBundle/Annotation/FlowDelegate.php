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
// @use Event
use Rock\OnSymfony\HttpPageFlowBundle\Event\Resolver\IEventNameResolver;
/**
 * Specify Flow State Delegator
 * This Annotation replace the state handle with specified delegator handler.
 * On example, Form flow has "save" State and the save is depends on EntityManager
 * class, or which ORM Strategy you use. Therefore, use FlowDelegator for 
 * Doctrine FormSave Strategy, and the Delegator handle the save action on FormFlow.
 * 
 * Be care, that Delegate can be accpeted only newest one, not like FlowHandler.
 * FlowHandler is Symfony Extended with EventDispatcher, and can add as many as 
 * you want.
 *
 * e.x.
 *    @FlowDelegate("save", delegator="DoctrineFormSaveDelegator", method="doDelegate")
 *    // Shortcut definition is AS "method"="doDelegate"
 *    @FlowDelegate("save", delegator="DoctrineFormSaveDelegator")
 *    // Select EntityManager
 *    @FlowDelegate("save", delegator="DoctrineFormSaveDelegator", vars={"EntityManager"="default"})
 *
 */
/**
 * @Annotation
 */
class FlowDelegate
  implements
    ConfigurationInterface
{
	/**
	 * @var 
	 */
	protected $state;

	/**
	 * @var 
	 */
	protected $delegator;

	/**
	 * @var 
	 */
	protected $method;

	/**
	 *
	 */
	protected $vars = array();

	/**
	 *
	 */
	public function __construct(array $values)
	{
		$this->vars    = array();
		$this->method  = 'doDelegate';
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
		$this->state = $value;
	}

	/**
	 *
	 */
	public function getState()
	{
		return $this->state;
	}

	/**
	 * @param string|IStateDelegate 
	 */
	public function setDelegator($delegator)
	{

		$this->delegator  = $delegator;
	}
	/**
	 * @param string|IStateDelegate 
	 */
	public function getDelegator()
	{
		return $this->delegator;
	}

	// Method
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

	public function setVars($vars)
	{
		$this->vars  = $vars;
	}

	public function getVars()
	{
		return $this->vars;
	}
	/**
	 * @param void
	 * @return void
	 */
	public function getAliasName()
	{
		return 'FlowDelegate';
	}
}
