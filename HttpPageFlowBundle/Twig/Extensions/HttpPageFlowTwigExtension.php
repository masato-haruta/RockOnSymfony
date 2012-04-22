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

/**
 *
 */
class HttpPageFlowTwigExtension extends Twig_Extension
{
	protected $page;
	private $request;

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

		if($this->hasFlowState())
		{
			$vars = array_merge($vars, array(
				'page_current' => $state->getCurrentPage(), 
				'page_prev'    => $state->getPrevPage(),
				'page_next'    => $state->getNextPage()
			));
		}
		return $vars;	
	}
	public function getFlowState()
	{
	}
	public function hasFlowState()
	{
		$flow = $this->getFlowState();
		return $flow && ($flow instanceof IHttpPageFlowState);
	}

}
