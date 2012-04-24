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
	/**
	 *
	 */
	public function __construct(RouterInterface $router, $directionKey = 'd')
	{
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
	public function resolveUrl($direction = null)
	{
		$params   = array($this->getDirectionKey() => $direction);

		// 
		return $this->getRouter()->generate(
			$this->getRoute(),
			$this->getRouteParameters($params)
		);
	}

	/**
	 *
	 */
	protected function getRouteParameters()
	{
		return array();
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
}
