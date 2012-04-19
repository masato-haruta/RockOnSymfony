<?php
/************************************************************************************
 *
 * Description:
 *      
 * $Id$
 * $Date$
 * $Rev$
 * $Author$
 * 
 *  This file is part of the $project$ package.
 *
 *  Copyright (c) 2009, 44services.jp. Inc. All rights reserved.
 *  For the full copyright and license information, please read LICENSE file
 *  that was distributed w/ source code.
 *
 *  Contact Us : Yoshi Aoki <yoshi@44services.jp>
 *
 ************************************************************************************/
// <Namespace>
namespace Rock\OnSymfony\HttpPageFlowBundle\Controller;

// <Interface>
use Rock\OnSymfony\FlowBundle\Flow\IFlowAware;

// <Use> : Flow Components
use Rock\Components\Flow\IFlow;
use Rock\Components\Flow\FlowDirections;

use Rock\OnSymfony\HttpFlowBundle\Request\FlowRequests;
use Rock\OnSymfony\HttpFlowBundle\Request\Resolver\IRequestResolver;
use Rock\OnSymfony\HttpFlowBundle\Flow\State\FlowStateHttpProxy;

// 
use Rock\OnSymfony\HttpPageFlowBundle\Template\Resolver\FlowTokenResolver;

/** 
 *
 */
class ControllerFilterController
  implements 
    IFlowAware
{
	/**
	 *
	 */
	protected $flow;
	/**
	 *
	 */
	protected $controller;

	/**
	 *
	 */
	public function __construct($controller, IFlow $flow)
	{
		$this->controller  = $controller;
		$this->flow        = $flow;
	}

	/**
	 *
	 */
	public function getFlow()
	{
		return $this->flow;
	}
	/**
	 *
	 */
	public function filterAction()
	{
		$args      = func_get_args();

		$flowResponse  = $this->handleFlow($args);
		if(!$flowResponse instanceof Response)
		{
			$args     = array_merge($args, $flowResponse);
			$response = call_user_func_array($this->controller, $args);

			if(!$response instanceof Response)
			{
				$response = array_merge($flowResponse, $response); 
			}
		}

		return $response;
	}

	/**
	 *
	 */
	public function getControllerInstance()
	{
		return $this->controller[0];
	}
	/**
	 *
	 */
	public function getControllerAction()
	{
		return $this->controller[1];
	}

	/**
	 *
	 */
	public function getFilterFunctionArray()
	{
		return array($this, 'filterAction');
	}
	/**
	 *
	 */
	public function getRequestResolver()
	{
		return $this->requestResolver;
	}
	/**
	 *
	 */
	public function setRequestResolver(IRequestResolver $resolver)
	{
		$this->requestResolver = $resolver;
	}
	/**
	 *
	 */
	public function getTemplateResolver()
	{
		return new FlowTokenResolver();
	}
	/**
	 *
	 */
	public function getRequest()
	{
		$request  = $this->getControllerInstance()->get('request');
		return $request;
	}
	/**
	 *
	 */
	protected function handleFlow($args)
	{
		$flow     = $this->getFlow();
		$resolver = $this->getRequestResolver();

		// Initialize State w/ Previous Connection State
		$session  = $resolver->getSession();
		$state    = $flow->createFlowState();
		$state->setSession($session);


		// Execute Flow
		$output   = $flow->handle($resolver->resolve($args), $state);

		//
		if($this->useRedirect() && (FlowDirection::CURRENT !== $output->getInput()->getDirection()))
		{
			throw new \Exception($output->getInput()->getDirection());
			return new RedirectResponse($output->getState()->getCurrentUrl());
		}
		
		// Merge Argument for controller
		$args = array_merge($args, $output->getParameters());

		// Change Template for current state
		{
			$step      = $output->getPath()->last()->current()->getName();
			$request   = $this->getRequest();
			$template  = $request->attributes->get('_template');
			$template  = $this->getTemplateResolver()->resolve($template, $step);
			$request->attributes->set('_template', $template);
		}

		$router  = $this->getControllerInstance()->get('router');
		$route   = $request->attributes->get('_route');
		
		$this->getControllerInstance()->get('request')->attributes->set(
		    '_flow', 
		    new FlowStateHttpProxy(
				$output->getState(), 
				$router, 
				$route, 
				array(FlowRequests::FLOW_ID_KEY => $output->getState()->getSession()->getFlowId())
			)
		);

		return $args;
	}
	/**
	 *
	 */
	protected function useRedirect()
	{
		return false;
	}
}
