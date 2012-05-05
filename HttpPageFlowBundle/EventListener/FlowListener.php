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
use Rock\Component\Flow\IFlow;
// <Use> : WebPage Flow Controller 
use Rock\OnSymfony\HttpPageFlowBundle\Controller\ControllerFilterController;
// <Use> : Annotation Configuration
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ConfigurationInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route as RouteConfiguration;
use Rock\OnSymfony\HttpPageFlowBundle\Annotation\Route as FlowRouteConfiguration;
use Rock\OnSymfony\HttpPageFlowBundle\Annotation\Flow as FlowConfiguration;
use Rock\OnSymfony\HttpPageFlowBundle\Annotation\FlowHandler as FlowHandlerConfiguration;
use Rock\OnSymfony\HttpPageFlowBundle\Annotation\FlowVars as FlowVarsConfiguration;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template as TemplateConfiguration;
use Rock\OnSymfony\HttpPageFlowBundle\Annotation\Template as FlowTemplateConfiguration;

use Symfony\Component\HttpFoundation\Request;
use Rock\OnSymfony\HttpPageFlowBundle\Traversal\HttpPageTraversalStateProxy;
// <Use> : Flow
use Rock\Component\Flow\IFlowContainable;
use Rock\Component\Http\Flow\Input\IHttpInput;
// <Use> : Response
use Symfony\Component\HttpFoundation\RedirectResponse;
/**
 *
 */
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
	 *
	 */
	protected $handlers = array();

	/**
	 *
	 */
	protected $dispatcher = array();

	/**
	 * Original Controller
	 */
	protected $controller;
	
	/**
	 *
	 */
	protected $inputVars = array();

	/**
	 *
	 */
	public function __construct(ContainerInterface $container)
	{
		$this->container = $container;

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

	public function onKernelRequest(GetResponseEvent $event)
	{
		$this->controller = null;
		$this->inputVars  = array();
		$this->handlers   = array();
		$this->flowConfiguration = null;
		$this->routeConfiguration = null;
		$this->templateConfiguration = null;
	}

	public function onKernelResponse(FilterResponseEvent $event)
	{
		$this->getTraversalStack()->pop();
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
				// set Flow Configuration 
				$this->setFlowConfiguration($configuration);
			}
			else if($configuration instanceof FlowHandlerConfiguration)
			{
				$configuration->setOwner($controller[0]);
				$configuration->setEventnameResolver($this->container->get('rock.page_flow.eventname.resolver'));

				$this->handlers[]  = $configuration;
			}
			else if($configuration instanceof FlowVarsConfiguration)
			{
				$this->inputVars   = array_merge($this->inputVars, $configuration->getValues());
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

		// Initialize FlowBuilder Settings
		$this->initContainer();
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
		$flowContainer  = $this->container->get('rock.page_flow.container');
		$flow  = $flowContainer->getByAlias($this->getFlowConfiguration()->getValue());

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
	
		$state   = $flow->createTraversalState();
		
		$response = array();
		try
		{
			$input   = $this->getRequestResolver()->resolveInput($request, $this->inputVars);
			if($input instanceof IHttpInput)
			{
				$input->setRedirectionSetting($this->getFlowConfiguration()->useCleanUrl());
			}
			

			$output  = $flow->handle(
				$input,
				$state
			);
			// 
			if(!$output->isSuccess())
			{
				throw new \Exception('Flow is somehow failed.');
			}
			else if($output->needRedirect())
			{
				$url  = $this->getUrlResolver()->resolveUrlFromState($output->getRedirectTo());
				
				$response  = new RedirectResponse($url);
			}
			else
			{
				$this->getUrlResolver()->setTraversal($output->getTraversal());
				// apply template value
				$this->applyTemplateName($request, $output->getTraversal()->getCurrent()->getName());

				// state proxy
				$state   = new HttpPageTraversalStateProxy(
					$output->getTraversal(),
					$this->getUrlResolver()
				);

				// Into scope, this scope will be poped when the Kernel::RESPONSE is handled
				$this->getTraversalStack()->push($state);

				$response = $output->all();
			}
		}
		catch(\Exception $ex)
		{
			throw $ex;
		}

		return $response;
	}

	/**
	 *
	 */
	protected function applyTemplateName(Request $request, $name)
	{
		if($request->attributes->has('_template'))
		{
			// Post Handle Template Value
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
			// Pre Handle Template Value
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
	protected function getEventDispatcher()
	{
		// Initialize EventDispatcher
		if(!$this->dispatcher)
		{
			$this->dispatcher  = $this->container->get('rock.page_flow.event_dispatcher');

			foreach($this->handlers as $handler)
			{
				$this->dispatcher->addListener(
					$handler->getEventname(), 
					$handler->getCallable()
				);
			}
		}
		return $this->dispatcher;
	}
	/**
	 *
	 */
	protected function initContainer()
	{
		$config   = $this->getFlowConfiguration();

		//
		{
			// Update Builder with Listener
			$flowContainer = $this->container->get('rock.page_flow.container');
			$builder    = $flowContainer->getComponentBuilder();
			// Initialize EventDispatcher for this flow
			$builder->setEventDispatcher($this->getEventDispatcher());
		}
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

		// Method
		$this->getRequestResolver()->setRequestMethod($config->getMethod());
	}

	/**
	 *
	 */
	protected function initFlowSetting(IFlow $flow)
	{
		//
		$flow->setName($this->getFlowConfiguration()->getName());

		// 
		$flow->setSessionManager($this->container->get('rock.page_flow.session_manager'));
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
	public function getTraversalStack()
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
