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
namespace Rock\OnSymfony\HttpPageFlowBundle\Controller;
//
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;

// 
use Symfony\Component\HttpFoundation\Request;
/** 
 *
 */
class ControllerFilterController
//class ControllerFilterController extends Controller
{
	/**
	 *
	 */
	protected $resolver;

	/**
	 *
	 */
	protected $controllers;

	/**
	 *
	 */
	public function __construct(ControllerResolverInterface $resolver, $controller = null)
	{
		$this->controllers = array();
		$this->resolver    = $resolver;
		if($controller)
			$this->addController($controller);
	}

	/**
	 *
	 */
	public function addController($controller)
	{
		$this->controllers[]  = $controller;
	}

	public function setRequest(Request $request)
	{
		$this->request  = $request;
	}

	/**
	 *
	 */
	public function __invoke(Request $request)
	{
		// Execute all controller functions
		$response  = array();

		try
		{
			foreach($this->controllers as $controller)
			{
				$arguments = $this->resolver->getArguments($request, $controller);

				$res  = call_user_func_array($controller, $arguments);

				if(is_array($res))
				{
					$response = array_merge($response, $res);
				}
				else
				{
					// if Response Object is given, then stop
					$response  = $res;
					break;
				}
			}
		}
		catch(\Exception $ex)
		{
			throw $ex;
		}

		return $response;
	}
}
