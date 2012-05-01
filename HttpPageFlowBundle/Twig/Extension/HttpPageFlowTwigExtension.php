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
namespace Rock\OnSymfony\HttpPageFlowBundle\Twig\Extension;
// <Use> : Request
use Symfony\Component\HttpFoundation\Request;

// 
use Rock\Component\Http\Flow\Traversal\IHttpPageTraversalState;
use Rock\OnSymfony\HttpPageFlowBundle\Traversal\ITraversalStack;

/**
 *
 */
class HttpPageFlowTwigExtension extends \Twig_Extension
{
	protected $page;
	protected $stack;

	/**
	 *
	 */
	public function __construct(ITraversalStack $stack)
	{
		$this->stack = $stack;
	}

	/**
	 * Get Extension Name of Twig
	 */
	public function getName()
	{
		return 'rock_on_symfon_http_page_flow_twig_extension';
	}
	
	/**
	 * Get global variables and path them to the twig engine.
	 */
	public function getGlobals()
	{
		$vars  = array(
			'page_current'=> '#',
			'page_next'   => false,
			'page_prev'   => false,
		);

		if($this->hasTraversalState())
		{
			$state = $this->getTraversalState();
			$vars  = array_merge($vars, array(
				'page_current' => $state->getCurrent(), 
				'page_prev'    => $state->hasPrev() ? $state->getPrev() : false,
				'page_next'    => $state->hasNext() ? $state->getNext() : false
			));
		}
		return $vars;	
	}
	
	/**
	 *
	 */
	public function getTraversalState()
	{
		return $this->getTraversalStack()->top();
	}

	/**
	 *
	 */
	public function hasTraversalState()
	{
		return $this->getTraversalStack()->count() > 0;
	}

	protected function getTraversalStack()
	{
		return $this->stack;
	}
	/**
	 *
	 */
	public function getRequest()
	{
		return $this->request;
	}

	public function getEnvironment()
	{
		return $this->environment;
	}
}
