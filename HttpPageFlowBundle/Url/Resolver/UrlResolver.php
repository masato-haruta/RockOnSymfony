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
use Rock\Component\Flow\Directions;

use Symfony\Component\Routing\RouterInterface;
//
use Rock\Component\Http\Flow\Traversal\IPageTraversalState;
// <Use>
use Rock\Component\Http\Flow\IPage;
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

	protected $traversal;

	/**
	 *
	 */
	public function __construct(RouterInterface $router, $keys = array())
	{
		$this->keys     = array_merge(array(
			'direction'  => 'direction',
			'state'      => 'state',
		), $keys);
		$this->router   = $router;
		$this->route    = null;
	}


	/**
	 *
	 */
	public function resolveStateFromRequest(Request $request)
	{
		return $request->get($this->getKey('state'));
	}

	/**
	 *
	 */
	public function resolveDirectionFromRequest(Request $request)
	{
		return $request->get($this->getKey('direction'), Directions::CURRENT);
	}

	public function resolveUrlFromState(IPage $page = null)
	{
		$params  = array();
		if($page)
			$params = array($this->getKey('state') => $page->getName());
		else
		{
			$params = array($this->getKey('state') => $this->getLatestState()->getName());
		}
		// 
		return $this->getRouter()->generate(
			$this->getRoute(),
			$this->getRouteParameters($params)
		);
	}
	/**
	 *
	 */
	public function resolveUrlFromDirection($direction)
	{
		$params  = array($this->getKey('direction') => $direction);
		// 
		return $this->getRouter()->generate(
			$this->getRoute(),
			$this->getRouteParameters($params)
		);
	}

	public function getStateForDirection($direction)
	{
		$flowState  = $this->getTraversal();

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

	public function getLatestState()
	{
		$traversal  = $this->getTraversal();
		$trails = $traversal->getTrail();

		if(!$trails || ($trails->count() <= 0))
		{
			throw new \Exception('Failed');
		}

		return $trails->last()->current();
	}
	
	/**
	 *
	 */
	protected function getRouteParameters($params = array())
	{
		$route   = $this->getRouter()->getRouteCollection()->get($this->getRoute());
		$pattern = $route->getPattern();


		// if {state} exists on pattern, fill it with the latest state
		if((false !== strpos($pattern, '{'.$this->getKey('state').'}')) && !isset($params[$this->getKey('state')]))
		{
			$params  = array_merge( $params, array($this->getKey('state') => $this->getLatestState()->getName()) );
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
	public function getKey($name)
	{
		return $this->keys[$name];
	}
	public function setKey($name, $value)
	{
		$this->keys[$name] = $value;
	}

	public function setTraversal(IHtttpPageTraversalState $traversal)
	{
		$this->traversal  = $traversal;
	}

	public function getTraversal()
	{
		if(!$this->traversal)
			throw new \Exception('Traversal is not specified.');
		return $this->traversal;
	}

}
