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
// @namespace
namespace Rock\OnSymfony\HttpPageFlowBundle\Input;
// @extends
use Rock\Component\Http\Flow\Input\Input as BaseInput;
// @use Request
use Symfony\Component\HttpFoundation\Request;

/** 
 *
 */
class Input extends BaseInput
{
	protected $httpRequest;

	public function __construct(Request $request, $directions, array $params = array())
	{
		parent::__construct($directions, $params);
		$this->httpRequest = $request;
	}
	public function setHttpRequest(Request $request)
	{
		$this->httpRequest  = $request;
	}
	public function getHttpRequest()
	{
		return $this->httpRequest;
	}
}
