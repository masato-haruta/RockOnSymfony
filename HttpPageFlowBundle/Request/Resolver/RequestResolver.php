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
namespace Rock\OnSymfony\HttpPageFlowBundle\Request\Resolver;
// <Interface>
use Rock\OnSymfony\HttpPageFlowBundle\Request\Resolver\IRequestResolver;
// <Use> : Symfony Http Request
use Symfony\Component\HttpFoundation\Request;
// <Use> : Flow HttpInput
use Rock\Components\Http\Flow\Input\Input as FlowInput;
// <Use> : UrlResolver
use Rock\OnSymfony\HttpPageFlowBundle\Url\Resolver\IUrlResolver;

/**
 *
 */
class RequestResolver
  implements 
    IRequestResolver
{
	protected $urlResolver;
	/**
	 *
	 */
	public function __construct(IUrlResolver $urlResolver = null)
	{
		$this->urlResolver  = $urlResolver;
	}

	/**
	 *
	 */
	public function resolveInput(Request $request)
	{
		return new FlowInput(
			$this->getUrlResolver()->resolveDirectionFromRequest($request),
			$request->query->all()
		);
	}

	/**
	 *
	 */
	public function resolveRequestQuery()
	{
		return array();
	}

	public function getUrlResolver()
	{
		return $this->urlResolver;
	}
	public function setUrlResolver(IUrlResolver $resolver)
	{
		$this->urlResolver = $resolver;
	}
}
