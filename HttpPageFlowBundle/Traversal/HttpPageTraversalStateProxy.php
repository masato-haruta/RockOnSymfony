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

// <Namespace>
namespace Rock\OnSymfony\HttpPageFlowBundle\Traversal;
// <Interface>
use Rock\Component\Http\Flow\Traversal\IHttpPageTraversalState;
// <Use> : TraversalState
use Rock\Component\Flow\Traversal\ITraversalState;
// <Use> : Directions
use Rock\Component\Flow\Directions;
use Rock\OnSymfony\HttpPageFlowBundle\Url\Resolver\IUrlResolver;

/**
 * PageTraversalState <<Proxy>>
 *   
 * This Traversal class overwrap actual State, and convert all parameters for Http Access.  
 */
class HttpPageTraversalStateProxy 
  implements
	IHttpPageTraversalState
{
	/**
	 * Original Traversal, or Unfreezed Traversal
	 *
	 * @var ITraversalState
	 */
	protected $source;
	/**
	 *
	 */
	protected $urlResolver;

	/**
	 *
	 */
	public function __construct(ITraversalState $traversal, IUrlResolver $resolver)
	{
		$this->source   = $traversal;
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
