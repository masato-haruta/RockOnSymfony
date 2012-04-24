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
namespace Rock\OnSymfony\HttpPageFlowBundle\Url\Resolver;
// <Use> : Symfony Request
use Symfony\Component\HttpFoundation\Request;
use Rock\Components\Http\Flow\Directions;

use Symfony\Component\Routing\RouterInterface;

use Rock\Components\Http\Flow\State\IPageFlowState;

/**
 *
 */
class UrlResolver
  implements 
    IUrlResolver
{
	protected $router;
	protected $route;
	protected $keys = array();
	protected $patternKeys = array();

	protected $state;

	/**
	 *
	 */
	public function __construct(RouterInterface $router, $directionKey = 'd')
	{
		$this->keys     = array(
			'direction'  => 'd',
		);
		$this->patternKeys = array(
			'direction'  => 'direction',
			'state'      => 'state',
		);
		$this->router   = $router;
		$this->route    = null;
		$this->setDirectionKey($directionKey);
	}


	/**
	 *
	 */
	public function resolveDirectionFromRequest(Request $request)
	{
		$key  = $this->getDirectionKey();

		return $request->get($key, Directions::CURRENT);
	}

	/**
	 *
	 */
	public function resolveUrl($direction)
	{
		$params  = array('_direction' => $direction);
		// 
		return $this->getRouter()->generate(
			$this->getRoute(),
			$this->getRouteParameters($params)
		);
	}

	public function getStateForDirection($direction)
	{
		$flowState  = $this->getFlowState();

		switch($direction)
		{
		case Directions::PREV:
			$step  = $flowState->getPrev();
			break;
		case Directions::NEXT:
			$step  = $flowState->getNext();
			break;
		case Directions::CURRENT:
		default:
			$step  = $flowState->getCurrent();
			break;
		}

		return $step;
	}
	
	/**
	 *
	 */
	protected function getRouteParameters($params = array())
	{
		$direction = $params['_direction'];
		unset($params['_direction']);
		$route   = $this->getRouter()->getRouteCollection()->get($this->getRoute());
		$pattern = $route->getPattern();


		if(false !== strpos($pattern, '{'.$this->getPatternKey('state').'}'))
		{
			$params  = array_merge( $params, array($this->getPatternKey('state') => $this->getStateForDirection($direction)->getName()) );
		}
		else if(false !== strpos($pattern, '{'.$this->getPatternKey('direction').'}'))
		{
			$params  = array_merge( $params, array($this->getPatternKey('direction') => $direction) );
		}
		else
		{
			$params  = array_merge( $params, array($this->getKey('direction') => $direction));
		}

		return $params;
	}

	/**
	 *
	 */
	public function setRouter(RouterInterface $router)
	{
		$this->router  = $router;
	}
	/**
	 *
	 */
	public function getRouter()
	{
		return $this->router;
	}

	/**
	 *
	 */
	public function getRoute()
	{
		return $this->route;
	}

	/**
	 *
	 */
	public function setRoute($route)
	{
		$this->route  = $route;
	}
	/**
	 *
	 */
	public function getDirectionKey()
	{
		return $this->keys['direction'];
	}
	/**
	 *
	 */
	public function setDirectionKey($name)
	{
		$this->keys['direction'] = $name;
	}
	public function getKey($name)
	{
		return $this->keys[$name];
	}

	public function getPatternKey($key)
	{
		return $this->patternKeys[$key];
	}

	public function setFlowState(IPageFlowState $state)
	{
		$this->state  = $state;
	}

	public function getFlowState()
	{
		if(!$this->state)
			throw new \Exception('State is not specified.');
		return $this->state;
	}

}
