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

class PageFlowStateProxy 
  implements
    IFlowState,
	IHttpFlowState
{
	/**
	 * Original State, or Unfreezed State
	 *
	 * @var IFlowState
	 */
	protected $source;
	/**
	 *
	 */
	protected $route;
	/**
	 *
	 */
	protected $routeParams;

	/**
	 *
	 */
	public function __construct()
	{
	}

	/**
	 * Page where the flow on the last
	 */
	public function getCurrentPage()
	{
		return $this->generateUrlFor(Directions::CURRENT);
	}
	public function getNextPage()
	{
		return $this->generateUrlFor(Directions::NEXT);
	}
	
	/**
	 * @param string|IState Direction or IState
	 */
	public function generateUrlFor($target)
	{
		if(is_string($target)
		{
			if(!Directions::isValid($target))
			{
				throw new \InvalidArgumentException(sprintf('Direction "%s" is not valid direction.', $target));
			}
			$params = array_merge($params, array($this->getDirectionKey() => $target));
			
		}
		else if($target instanceof IFlowState)
		{
		}
		else
		{
			throw new \InvalidArgumentException(sprintf('$target has to be an instance of IFlowState or Direction string.'));
		}
		return $this->getRouter()->generate(
			$this->getRoute(),
			$params
		);
	}
	/**
	 *
	 */
	public function hasNext()
	{
	}
	/**
	 *
	 */
	public function getSource()
	{
		return $this->source;
	}
}
