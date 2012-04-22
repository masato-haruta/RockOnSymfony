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

// <Use> : Symfony Modules
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

// <Use> : Events
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;
use Symfony\Component\HttpKernel\KernelEvents;

// <Use> : Flow Components
use Rock\Components\Flow\Builder\IFlowBuilder;
use Rock\Components\Flow\Manager\FlowManager;
use Rock\Components\Flow\Directions;
// <Use> : WebPage Flow Requets Resolver
use Rock\OnSymfony\HttpPageFlowBundle\Request\Resolver\RequestResolver;
// <Use> : WebPage Flow Controller 
use Rock\OnSymfony\HttpPageFlowBundle\Controller\ControllerFilterController;
// <Use> : Annotation Configuration
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ConfigurationInterface;
use Rock\OnSymfony\HttpPageFlowBundle\Annotation\Route as RouteConfiguration;
use Rock\OnSymfony\HttpPageFlowBundle\Annotation\Flow as FlowConfiguration;
use Rock\OnSymfony\HttpPageFlowBundle\Annotation\Template as TemplateConfiguration;

class ControllerListener
{
	/**
	 *
	 */
	protected $container;
	/**
	 *
	 */
	protected $resolver;

	protected $builder;
	/**
	 *
	 */
	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
		$this->builder   = null;
		$this->resolver  = new RequestResolver();
	}

	/**
	 *
	 */
	public function onKernelRequest(GetResponseEvent $event)
	{
		//$this->resolver  = new RequestResolver();
	}

	/**
     * @param FilterControllerEvent $event A FilterControllerEvent instance
     */
    public function onKernelController(FilterControllerEvent $event)
	{
	    if(!is_array($controller = $event->getController()))
		{
		    return;
		}

		// Create ReflectionObject Instance
		$object = new \ReflectionObject($controller[0]);
		// Get ReflectionMethod Instance
		$method   = $object->getMethod($controller[1]);

		$defaultRoute = '';
		$flowConfig = null;
		$templateConfig = null;

		$reader   = $this->getAnnotationReader();

		$configurations = $reader->getMethodAnnotations($method);

		// Get Annotations for $method
		foreach($reader->getMethodAnnotations($method) as $configuration)
		{
			// If Annotation is for @Flow, build flow 
			if($configuration instanceof FlowConfiguration)
			{
				$configuration->setController($controller[0]);
				$this->initBuilder($configuration);
				$this->initResolverSetting($configuration);
				$flowConfig  = $configuration;
				$flowConfig->setDefaultRoute($defaultRoute);

				// Apply Builder Configuration
				//{
				//    $builder->setConfiguration($configuration);
				//    $builder->setController($controller[0]);
				//}
			}
			else if($configuration instanceof RouteConfiguration)
			{
				if($flowConfig)
					$flowConfig->setDefaultRoute($configuration->getName());
				else
					$defaultRoute  = $configuration->getName();
			}
			else if($configuration instanceof TemplateConfiguration)
			{
				$templateConfig = $configuration;
			}
		}

		// Regist Flow
		if($flowConfig)
		{
			// Router name as Flow name
			$flow  = $this->getFlowBuilder()->build($flowConfig->getValue());
			$flow->setName($flowConfig->getName());
			//$this->getManager()->set($resolver->getControllerName(), $flow);
		    if($this->isFlowControllerInstance($controller[0]))
		    {
		    	$controller->setFlow($flow);
		    }

			
			$wrapper = new ControllerFilterController($event->getController(), $flow);
			if($templateConfig)
				$wrapper->setTemplateConfiguration($templateConfig);
			$wrapper->setRequestResolver($this->getRequestResolver());
			$event->setController($wrapper->getFilterFunctionArray());

		}
	}
	
	protected function initRouterSetting()
	{
		$router  = $this->getRouter();
	}
	protected function initBuilder(FlowConfiguration $config)
	{
		// 
		$factory = $this->container->get('rock.page_flow.factory');

		$this->builder = $factory->createBuilder($config->getValue());
	}

	protected function initResolverSetting(FlowConfiguration $config)
	{
		$resolver  = $this->getRequestResolver();
		// Override Setting
		if($key = $config->getDirectionKey())
			$resolver->setDirectionKey($key);
	}
	/**
	 *
	 */
	protected function initFlowSetting(IFlow $flow, FlowConfiguration $config)
	{
		if($flow instanceof EventDisptacherInterface)
		{
			foreach($config->getListeners() as $eventname => $listener)
			{
				$flow->addListener($eventname, $listener);
			}
		}
	}
	/**
	 *
	 */
	protected function isFlowControllerInstance($controller)
	{
		return ($controller instanceof IFlowController);
	}


	/**
	 *
	 */
	public function getAnnotationReader()
	{
		return $this->container->get('annotation_reader');
	}

	public function getBuilderFactory()
	{
		return $this->container->get('rock.page_flow.builder_factory');
	}
	/**
	 *
	 */
	public function getFlowBuilder()
	{
		return $this->builder;
	}

	/**
	 *
	 */
	public function getFlowManager()
	{
		return $this->container->get('rock.page_flow.manager');
	}

	/**
	 *
	 */
	public function getRequestResolver()
	{
		if(!$this->resolver)
		{
			throw new \Exception('Request Resolver is not initialized');
		}
		return $this->resolver;
	}
}
