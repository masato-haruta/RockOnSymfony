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

use Rock\OnSymfony\Standard\ComponentExtendBundle\Session\Proxy\ISessionProxyManager;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ConfigurationInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route as RouteConfiguration;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;

use Rock\OnSymfony\FlowFrameworkBundle\Configuration\Flow as FlowConfiguration;
use Rock\OnSymfony\FlowBundle\Flow\Builder\IFlowBuilder;
use Rock\OnSymfony\FlowBundle\Flow\Manager\FlowManager;
use Rock\OnSymfony\FlowFrameworkBundle\Request\Resolver\HttpRequestResolver;
use Rock\OnSymfony\FlowBundle\Flow\FlowDirection;

use Symfony\Component\HttpKernel\KernelEvents;
use Rock\OnSymfony\FlowFrameworkBundle\Controller\ControllerFilterController;

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

	/**
	 *
	 */
	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;
	}

	/**
	 *
	 */
	public function onKernelRequest(GetResponseEvent $event)
	{
		$this->resolver  = new HttpRequestResolver($this->getSessionManager(), $event->getRequest());
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
		$object   = new \ReflectionObject($controller[0]);
		// Get ReflectionMethod Instance
		$method   = $object->getMethod($controller[1]);
		$resolver = $this->getRequestResolver();

		$defaultRoute = '';
		$flowConf = null;

		$reader   = $this->getAnnotationReader();
		$builder  = $this->getFlowBuilder();

		$configurations = $reader->getMethodAnnotations($method);
		// Get Annotations for $method
		foreach($reader->getMethodAnnotations($method) as $configuration)
		{
			// If Annotation is for @Flow, build flow 
			if($configuration instanceof FlowConfiguration)
			{
				$flowConf  = $configuration;
				$flowConf->setDefaultRoute($defaultRoute);

				// Apply Builder Configuration
				{
				    $builder->setConfiguration($configuration);
				    $builder->setController($controller[0]);
				}
			}
			else if($configuration instanceof RouteConfiguration)
			{
				if($flowConf)
				{
					$flowConf->setDefaultRoute($configuration->getName());
				}
				else
				{
					$defaultRoute  = $configuration->getName();
				}
			}
		}

		// Regist Flow
		if($flowConf)
		{
			$flow  = $builder->getFlow();
			//$this->getManager()->set($resolver->getControllerName(), $flow);
		    if($this->isFlowControllerInstance($controller[0]))
		    {
		    	$controller->setFlow($flow);
		    }

			
			$wrapper = new ControllerFilterController($event->getController(), $flow);
			$wrapper->setRequestResolver($this->getRequestResolver());
			$event->setController($wrapper->getFilterFunctionArray());
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

	/**
	 *
	 */
	public function getFlowBuilder()
	{
		return $this->container->get('rock.flow.builder');
	}

	/**
	 *
	 */
	public function getFlowManager()
	{
		return $this->container->get('rock.flow.manager');
	}

	/**
	 *
	 */
	public function getSessionManager()
	{
		try
		{
			$manager = $this->container->get('session.proxy.manager');
		}
		catch(ServiceNotFoundException $ex)
		{
			throw new \Exception(sprintf('Service "session.proxy.manager" is not defined, but FlowFramework Required. Plz read README to how to use.'));
		}
	
		if(!$manager instanceof ISessionProxyManager)
		{
			throw new \Exception(sprintf('Service "session.proxy.manager" is not an instance of "ISessionProxyManager", but "%s" given.', get_class($manager)));
		}
		return $manager;
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
