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
use Rock\Components\Flow\IFlowAware;

// <Use> : Flow Components
use Rock\Components\Flow\IFlow;
use Rock\Components\Flow\FlowDirections;

// <Use> : 
use Rock\OnSymfony\HttpPageFlowBundle\Request\Resolver\RequestResolver;
//use Rock\OnSymfony\HttpPageFlowBundle\Flow\State\FlowStateHttpProxy;


use Rock\OnSymfony\HttpPageFlowBundle\Annotation\Template as TemplateConfiguration;
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

	protected $template;
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
	public function setRequestResolver(RequestResolver $resolver)
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

		// Initialize State w/ Previous Connection State
		$state    = $flow->createFlowState();

		// Execute Flow
		$output   = $flow->handle($this->getRequestResolver()->resolve($this->getRequest()), $state);

		//
		if($this->useRedirect() && (FlowDirection::CURRENT !== $output->getInput()->getDirection()))
		{
			throw new \Exception($output->getInput()->getDirection());
			return new RedirectResponse($output->getState()->getCurrentUrl());
		}
		
		// Merge Argument for controller
		$args = array_merge($args, $output->all());

		// Change Template for current state
		{
			//$step      = $output->getPath()->last()->current()->getName();
			//$request   = $this->getRequest();
			//$template  = $request->attributes->get('_template');
			//$template  = $this->getTemplateResolver()->resolve($template, $step);
			//$request->attributes->set('_template', $template);
			
			$trails = $output->getTrail();
			if($trails)
			{
				$current = $trails->last()->current()->getName();
				$this->getTemplateConfiguration()->setVar('state',$current);
			}
		}

		//$request = $this->getRequest();
		//$router  = $this->getControllerInstance()->get('router');
		//$route   = $request->attributes->get('_route');
		//
		//// Set PageFlowState Proxy as attributes "_flow"
		//$this->getControllerInstance()->get('request')->attributes->set(
		//    '_flow', 
		//    new PageStateProxy(
		//		$output->getState(), 
		//		$router, 
		//		$route, 
		//		array(FlowRequests::FLOW_ID_KEY => $output->getState()->getSession()->getFlowId())
		//	)
		//);

		return $args;
	}
	/**
	 *
	 */
	protected function useRedirect()
	{
		return false;
	}
	/**
	 *
	 */
	public function setTemplateConfiguration(TemplateConfiguration $config)
	{
		$this->template  = $config;
	}
	/**
	 *
	 */
	public function getTemplateConfiguration()
	{
		return $this->template;
	}
}
