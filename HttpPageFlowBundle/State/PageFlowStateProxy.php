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
namespace Rock\OnSymfony\HttpPageFlowBundle\State;
// <Interface>
use Rock\Components\Http\Flow\State\IPageFlowState;
// <Use> : FlowState
use Rock\Components\Flow\State\IFlowState;
// <Use> : Directions
use Rock\Components\Flow\Directions;
use Rock\OnSymfony\HttpPageFlowBundle\Url\Resolver\IUrlResolver;

/**
 * PageFlowState <<Proxy>>
 *   
 * This State class overwrap actual State, and convert all parameters for Http Access.  
 */
class PageFlowStateProxy 
  implements
	IPageFlowState
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
	protected $urlResolver;

	/**
	 *
	 */
	public function __construct(IFlowState $state, IUrlResolver $resolver)
	{
		$this->source   = $state;
		$this->urlResolver = $resolver;
	}

	/**
	 * Page where the flow on the last
	 */
	public function getCurrent()
	{
		$current = null;
		$trails  = $this->getSource()->getTrail();
		if($trails)
			$current  = $trails->last()->current();

		return $this->getUrlResolver()->resolveUrlFromState($current);
	}
	/**
	 *
	 */
	public function getPrev()
	{
		if(!$this->hasPrev())
			throw new \Exception('Flow dose not have prev state.');
		return $this->getUrlResolver()->resolveUrlFromDirection(Directions::PREV);
	}
	/**
	 *
	 */
	public function getNext()
	{
		if(!$this->hasNext())
			throw new \Exception('Flow dose not have next state.');
		else
			return $this->getUrlResolver()->resolveUrlFromDirection(Directions::NEXT);
	}
	
	/**
	 *
	 */
	public function hasPrev()
	{
		return $this->getSource()->hasPrev();
	}
	/**
	 *
	 */
	public function hasNext()
	{
		return $this->getSource()->hasNext();
	}

	/**
	 *
	 */
	public function getSource()
	{
		return $this->source;
	}

	/**
	 *
	 */
	public function getSession()
	{
		return $this->getSource()->getSession();
	}

	public function isHandled()
	{
		return $this->getSource()->isHandled();
	}

	public function getUrlResolver()
	{
		return $this->urlResolver;
	}
}
