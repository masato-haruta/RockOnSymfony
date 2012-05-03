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
use Rock\OnSymfony\HttpPageFlowBundle\Event\Resolver\EventNameResolver;

/**
 * @Annotation
 */
class Flow
  implements
    ConfigurationInterface
{
	/**
	 * @var
	 */
	protected $value;
	/**
	 * @var
	 */
	protected $name;
	/**
	 * @var
	 */
	protected $route;
	/**
	 * @var
	 */
	protected $directionKey;
	/**
	 * @var
	 */
	protected $stateKey;
	/**
	 * @var
	 */
	protected $token;

	/**
	 * @var
	 */
	protected $bUseClean;

	/**
	 * @var
	 */
	protected $method;


	/**
	 *
	 */
	public function __construct(array $values)
	{
		$this->bUseClean   = true;
		$this->type        = 'DEFAULT';
		$this->method      = 'get';

		//
		foreach($values as $k => $v)
		{
			if(method_exists($this, $method = 'set'.ucfirst($k)))
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

	// Direction
	public function setDirectionOnRoute($key)
	{
		$this->directionKey  = $key;
	}
	public function getDirectionOnRoute()
	{
		return $this->directionKey;
	}
	// Direction
	public function setStateOnRoute($key)
	{
		$this->stateKey  = $key;
	}
	public function getStateOnRoute()
	{
		return $this->stateKey;
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

	/**
	 *
	 */
	public function setTemplateToken($token)
	{
		$this->token  = $token;
	}

	/**
	 *
	 */
	public function getTemplateToken()
	{
		return $this->token;
	}

	/**
	 *
	 */
	public function setCleanUrl($bClean)
	{
		if(!is_bool($bClean))
			throw new \InvalidArgumentException('useClean has to be a boolean.');
		$this->bUseClean  = $bClean;
	}

	/**
	 *
	 */
	public function useCleanUrl()
	{
		return $this->bUseClean;
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
	public function setMethod($method)
	{
		$method  = strtolower($method);
		switch($method)
		{
		case 'get':
		case 'post':
			$this->method  = $method;
			break;
		default:
			break;
		}
	}
}
