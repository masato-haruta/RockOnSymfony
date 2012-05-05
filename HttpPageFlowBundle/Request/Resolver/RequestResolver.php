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
namespace Rock\OnSymfony\HttpPageFlowBundle\Request\Resolver;
// <Interface>
use Rock\OnSymfony\HttpPageFlowBundle\Request\Resolver\IRequestResolver;
// <Use> : Symfony Http Request
use Symfony\Component\HttpFoundation\Request;
// @use Flow Input
use Rock\OnSymfony\HttpPageFlowBundle\Input\Input;
// <Use> : UrlResolver
use Rock\OnSymfony\HttpPageFlowBundle\Url\Resolver\IUrlResolver;

/**
 *
 */
class RequestResolver
  implements 
    IRequestResolver
{
	/**
	 *
	 */
	protected $method;
	/**
	 *
	 */
	protected $urlResolver;
	/**
	 *
	 */
	public function __construct(IUrlResolver $urlResolver = null)
	{
		$this->method       = 'get';
		$this->urlResolver  = $urlResolver;
	}

	/**
	 *
	 */
	public function resolveInput(Request $request, $parameters = array())
	{
		$direction = $this->getUrlResolver()->resolveDirectionFromRequest($request);
		$stateName = $this->getUrlResolver()->resolveStateFromRequest($request);
		
		// 
		$input  = new Input(
			$request,
			$direction,
			array_merge($parameters, $request->query->all())
		);

		// Set StateFilter
		if($stateName)
		{
			$input->setRequestState($stateName);
		}

		return $input;
	}

	/**
	 *
	 */
	public function resolveRequestQuery()
	{
		return array();
	}

	/**
	 *
	 */
	public function getUrlResolver()
	{
		return $this->urlResolver;
	}
	/**
	 *
	 */
	public function setUrlResolver(IUrlResolver $resolver)
	{
		$this->urlResolver = $resolver;
	}
	
	/**
	 *
	 */
	public function setRequestMethod($method)
	{
		switch($method)
		{
		case 'get':
		case 'post':
			$this->method  = $method;
			break;
		default:
			throw new \InvalidArgumentException(sprintf('Method has to be "get" or "post", but "%s" is given.', $method));
			break;
		}
	}
	public function getRequestMethod()
	{
		return $this->method;
	}
}
