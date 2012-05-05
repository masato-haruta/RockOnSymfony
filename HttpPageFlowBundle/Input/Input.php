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
