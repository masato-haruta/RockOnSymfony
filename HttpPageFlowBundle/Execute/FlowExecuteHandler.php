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
namespace Rock\OnSymfony\HttpPageFlowBundle\Execute;

// <Use> : WebPage Flow Resolvers
use Rock\OnSymfony\HttpPageFlowBundle\Url\Resolver\IUrlResolver;
use Rock\OnSymfony\HttpPageFlowBundle\Request\Resolver\IRequestResolver;
// <Use> : Flow Components
use Rock\Components\Flow\IFlow;
use Rock\Components\Flow\Builder\IFlowBuilder;

// <Use> : Request
use Symfony\Component\HttpFoundation\Request;

class FlowExecuteHandler
{
	/**
	 *
	 */
	protected $urlResolver;
	/**
	 *
	 */
	protected $requestResolver;

	/**
	 *
	 */
	protected $builder;
	/**
	 *
	 */
	public function handleFlow(Request $request)
	{
		//
		$flow  = $this->getFlowBuilder()->build($this->getFlowConfiguration()->getValue());

		//$this->getManager()->set($resolver->getControllerName(), $flow);
		//if($this->isFlowControllerInstance($controller[0]))
		//{
		//	$controller->setFlow($flow);
		//}

		$state   = $flow->createFlowState();
		
		$output  = $flow->handle(
			$this->getRequestResolver()->resolveInput($request),
			$state
		);

		// state proxy
		$state   = new PageFlowStateProxy(
			$output->getState(),
			$this->getUrlResolver()
		);

		return $output->all();
	}

	/**
	 *
	 */
	public function getBuilder()
	{
		return $this->builder;
	}
	/**
	 *
	 */
	public function setBuilder(IFlowBuilder $builder)
	{
		$this->builder = $builder;
	}
	/**
	 *
	 */
	public function getUrlResolver()
	{
		if(!$this->urlResolver)
			throw new \Exception('Url Resolver is not initialized yet.');
		return $this->urlResolver;
	}

	public function setUrlResolver(IUrlResolver $resolver)
	{
		$this->urlResolver  = $resolver;
	}
	/**
	 *
	 */
	public function getRequestResolver()
	{
		if(!$this->requestResolver)
			throw new \Exception('Request Resolver is not initialized yet.');
		return $this->requestResolver;
	}

	public function setRequestResolver(IRequestResolver $resolver)
	{
		$this->requestResolver  = $resolver;
	}
}
