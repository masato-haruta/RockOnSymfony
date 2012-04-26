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
namespace Rock\OnSymfony\HttpPageFlowBundle\EventListener;
// <Base>
use Rock\OnSymfony\HttpPageFlowBundle\Execute\FlowExecuteHandler;

// <Use> : Symfony Modules
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
// <Use> : EventDispatcher
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
// <Use> : Kernel Events
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
// 
use Rock\Components\Flow\IFlow;
// <Use> : WebPage Flow Controller 
use Rock\OnSymfony\HttpPageFlowBundle\Controller\ControllerFilterController;
// <Use> : Annotation Configuration
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ConfigurationInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route as RouteConfiguration;
use Rock\OnSymfony\HttpPageFlowBundle\Annotation\Route as FlowRouteConfiguration;
use Rock\OnSymfony\HttpPageFlowBundle\Annotation\Flow as FlowConfiguration;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template as TemplateConfiguration;
use Rock\OnSymfony\HttpPageFlowBundle\Annotation\Template as FlowTemplateConfiguration;

use Symfony\Component\HttpFoundation\Request;
use Rock\OnSymfony\HttpPageFlowBundle\State\PageFlowStateProxy;

// <Use> : Flow
use Rock\Components\Flow\IFlowContainable;

class FlowListener extends FlowExecuteHandler
{
	/**
	 *
	 */
	protected $container;

	// Configurations
	/**
	 *
	 */
	protected $flowConfiguration = null;
	/**
	 *
	 */
	protected $routeConfiguration = null;
	/**
	 *
	 */
	protected $templateConfiguration = null;

	/**
	 * Original Controller
	 */
	protected $controller;
	/**
	 *
	 */
	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
		$this->builder   = null;

		if($this->container->has('rock.page_flow.url.resolver'))
		{
			$this->setUrlResolver(
				$this->container->get('rock.page_flow.url.resolver')
			);
		}

		if($this->container->has('rock.page_flow.request.resolver'))
		{
			$this->setRequestResolver(
				$this->container->get('rock.page_flow.request.resolver')
			);
		}
	}


	public function onKernelResponse(FilterResponseEvent $event)
	{
		$this->getStateStack()->pop();
	}
	/**
     * @param FilterControllerEvent $event A FilterControllerEvent instance
     */
    public function onKernelController(FilterControllerEvent $event)
	{
		// Parse Annotation
	    if(is_array($controller = $event->getController()))
		{
			$this->parseControllerAnnotation($controller);
		}

		// is Flow or not
		if($this->hasFlowConfiguration())
		{
			// $this->getFlowConfiguration()->setDefaultRoute($route->getName());
			// Filter Controller
			{
				$controller  = $event->getController();

				// Switch Controller with ControllerFilterController
				if(!$controller instanceof ControllerFilterController)
				{
					$newController  = $this->getControllerFilterController();

					// Add original controller
					$newController->addController($controller);
					$this->setOriginalController($controller);

					// Flow should called before original controller dose.
					$newController->addController(array($this, 'handleFlow'));

					$event->setController($newController);

					$controller  = $newController;
				}
			}	
		}
	}
	/**
	 * Create new ControllerFilterController w/ Container Parameter "scope"="prototype"
	 *
	 * @return 
	 */
	protected function getControllerFilterController()
	{
		return $this->container->get('rock.page_flow.controller.filter');
	}
	protected function parseControllerAnnotation(array $controller)
	{
		// Create ReflectionObject Instance
		$object = new \ReflectionObject($controller[0]);
		// Get ReflectionMethod Instance
		$method   = $object->getMethod($controller[1]);

		$reader   = $this->getAnnotationReader();

		$configurations = $reader->getMethodAnnotations($method);

		// Get Annotations for $method
		foreach($reader->getMethodAnnotations($method) as $configuration)
		{
			if($configuration instanceof FlowConfiguration)
			{
				// For Listeners, set Controller as Listener Owner
				$configuration->setListenerOwner($controller[0]);
				// set Flow Configuration 
				$this->setFlowConfiguration($configuration);
			}
			else if($configuration instanceof RouteConfiguration)
			{
				$this->setRouteConfiguration($configuration);
			}
			else if($configuration instanceof TemplateConfiguration)
			{
				$this->setTemplateConfiguration($configuration);
			}
		}
	}

	/**
	 *
	 */
	public function hasFlowConfiguration()
	{
		return !is_null($this->flowConfiguration);
	}
	/**
	 *
	 */
	public function setFlowConfiguration(FlowConfiguration $configuration)
	{

		$this->flowConfiguration  = $configuration;
		// Initialize FlowBuilder Settings
		$this->initBuilder();

		// Initialize Resolver Settings
		$this->initResolverSetting();
	}

	/**
	 *
	 */
	public function getFlowConfiguration()
	{
		return $this->flowConfiguration;
	}

	/**
	 *
	 */
	public function setRouteConfiguration(RouteConfiguration $config)
	{
		$this->routeConfiguration = $config;
	}

	/**
	 *
	 */
	public function getRouteConfiguration()
	{
		return $this->routeConfiguration;
	}
	/**
	 *
	 */
	public function setTemplateConfiguration(TemplateConfiguration $config)
	{
		$this->templateConfiguration = $config;
	}
	/**
	 *
	 */
	public function getTemplateConfiguration()
	{
		return $this->templateConfiguration;
	}

	/**
	 *
	 */
	public function handleFlow(Request $request)
	{
		//
		$flow  = $this->getBuilder()->build($this->getFlowConfiguration()->getValue());
		$this->setFlowOnOriginal($flow);

		// Set Flow instance as flow, so action parameter can solve $flow
		$request->attributes->set('flow', $flow);
		// Initialize Flow
		$this->initFlowSetting($flow, $this->getFlowConfiguration());

		//$this->getManager()->set($resolver->getControllerName(), $flow);
		//if($this->isFlowControllerInstance($controller[0]))
		//{
		//	$controller->setFlow($flow);
		//}

		$state   = $flow->createFlowState();
		
		$input   = $this->getRequestResolver()->resolveInput($request);
		$output  = $flow->handle(
			$input,
			$state
		);

		$this->getUrlResolver()->setFlowState($output->getState());
		// apply template value
		$this->applyTemplateName($request, $output->getState()->getCurrent()->getName());

		// state proxy
		$state   = new PageFlowStateProxy(
			$output->getState(),
			$this->getUrlResolver()
		);

		// Into scope, this scope will be poped when the Kernel::RESPONSE is handled
		$this->getStateStack()->push($state);

		return $output->all();
	}

	/**
	 *
	 */
	protected function applyTemplateName(Request $request, $name)
	{
		if($request->attributes->has('_template'))
		{
			$template = $request->attributes->get('_template');
			// Replace TemplateToken
			$token    = $this->getFlowConfiguration()->getTemplateToken();
			if(!$token || empty($token))
				$token  = '{state}';

			$template = str_replace($token, $name, $template);

			$request->attributes->set('_template', $template);
		}
		else if(($config = $this->getTemplateConfiguration()) instanceof FlowTemplateConfiguration)
		{
			$config   = $this->getTemplateConfiguration();
			$config->setStateToken($token);
			$config->setStateValue($name);
		}
		else
		{
			throw new \Exception('TemplateListener has to called before FlowListener called.');
		}
	}
	
	/**
	 *
	 */
	protected function initBuilder()
	{
		// 
		$factory = $this->container->get('rock.page_flow.factory');

		$this->setBuilder($factory->createBuilder($this->getFlowConfiguration()->getValue()));
	}

	/**
	 *
	 */
	protected function initResolverSetting()
	{
		$config  = $this->getFlowConfiguration();
		// Setup UrlResolver
		$resolver  = $this->getUrlResolver();
		// Override Setting
		if($key = $config->getDirectionOnRoute())
			$resolver->setKey('direction', $key);
		if($key = $config->getStateOnRoute())
			$resolver->setKey('state', $key);
		$resolver->setRoute($config->getRoute());

		// Setup RequestResolver
		$this->getRequestResolver()->setUrlResolver($resolver);
	}

	/**
	 *
	 */
	protected function initFlowSetting(IFlow $flow)
	{
		if($flow instanceof EventDispatcherInterface)
		{
			foreach($this->getFlowConfiguration()->getListeners() as $eventname => $listener)
			{
				$flow->addListener($eventname, $listener);
			}
		}
		$flow->setName($this->getFlowConfiguration()->getName());
	}


	/**
	 *
	 */
	public function getAnnotationReader()
	{
		return $this->container->get('annotation_reader');
	}

	/**
	 *
	 */
	public function getStateStack()
	{
		return $this->container->get('rock.page_flow.state_stack');
	}


	public function setOriginalController($controller)
	{
		$this->controller = $controller;
	}

	public function setFlowOnOriginal(IFlow $flow)
	{
		if($this->controller)
		{
			if(is_array($this->controller) && ($this->controller[0] instanceof IFlowContainable))
			{
				$this->controller[0]->setFlow($flow);
			}
			else if(is_object($this->controller) && ($this->controller instanceof IFlowContainable))
			{
				$this->controller->setFlow($flow);
			}
		}
	}
}
